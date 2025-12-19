<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $user = $request->user();
        
        return view('profile.edit', [
            'user' => $user,
            'isProfileComplete' => $user->isProfileComplete(),
            'missingFields' => $user->getMissingProfileFields(),
            'completionPercentage' => $user->getProfileCompletionPercentage(),
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();
        
        // Validasi dasar
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ];

        $messages = [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah terdaftar.',
        ];

        // Validasi untuk field yang kosong
        $this->addConditionalValidation($user, $request, $rules, $messages);

        // Foto KTP
        $fotoKtpRequired = empty($user->foto_ktp) ? 'required' : 'nullable';
        if ($request->hasFile('foto_ktp') || empty($user->foto_ktp)) {
            $rules['foto_ktp'] = [$fotoKtpRequired, 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'];
            $messages['foto_ktp.mimes'] = 'Format file harus JPG, PNG, atau PDF.';
            $messages['foto_ktp.max'] = 'Ukuran file maksimal 2MB.';
        }

        $validated = $request->validate($rules, $messages);

        // Handle upload foto KTP
        if ($request->hasFile('foto_ktp')) {
            $validated['foto_ktp'] = $this->handleKtpUpload($request->file('foto_ktp'), $user, $validated);
        }

        // Update user
        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Cek apakah profile sekarang sudah lengkap
        $wasIncomplete = !$user->isProfileComplete();
        $isNowComplete = $user->isProfileComplete();
        
        if ($isNowComplete && $wasIncomplete && $user->role === 'warga') {
            // Jika baru saja melengkapi profil
            $user->update(['is_verified' => true]);
            
            // Redirect ke dashboard dengan pesan sukses
            return redirect()->route('dashboard')
                ->with('success', 'Profil berhasil dilengkapi!')
                ->with('profile-completed', true);
        }

        return redirect()->route('profile.edit')
            ->with('status', 'profile-updated')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    private function addConditionalValidation($user, $request, &$rules, &$messages): void
    {
        // Telepon
        $teleponInput = $request->input('telepon');
        if (empty($user->telepon) || ($teleponInput !== null && $teleponInput !== '')) {
            $rules['telepon'] = ['required', 'string', 'max:15', 'regex:/^[0-9]{10,15}$/'];
            $messages['telepon.regex'] = 'Nomor telepon harus 10-15 digit angka.';
        }

        // Tanggal lahir
        $tanggalLahirInput = $request->input('tanggal_lahir');
        if (empty($user->tanggal_lahir) || ($tanggalLahirInput !== null && $tanggalLahirInput !== '')) {
            $rules['tanggal_lahir'] = ['required', 'date', 'before_or_equal:' . now()->subYears(17)->format('Y-m-d')];
            $messages['tanggal_lahir.before_or_equal'] = 'Minimal usia 17 tahun.';
        }

        // Jenis kelamin
        $jenisKelaminInput = $request->input('jenis_kelamin');
        if (empty($user->jenis_kelamin) || ($jenisKelaminInput !== null && $jenisKelaminInput !== '')) {
            $rules['jenis_kelamin'] = ['required', 'in:L,P'];
        }

        // Alamat
        $alamatInput = $request->input('alamat');
        if (empty($user->alamat) || ($alamatInput !== null && $alamatInput !== '')) {
            $rules['alamat'] = ['required', 'string', 'max:500'];
        }

        // NIK: hanya jika kosong dan ada input
        $nikInput = $request->input('nik');
        if (empty($user->nik) && $nikInput !== null && $nikInput !== '') {
            $rules['nik'] = ['required', 'string', 'size:16', 'regex:/^[0-9]{16}$/', 'unique:users,nik,' . $user->id];
            $messages['nik.required'] = 'NIK wajib diisi.';
            $messages['nik.unique'] = 'NIK sudah terdaftar.';
        }
    }

    private function handleKtpUpload($file, $user, $validated = []): string
    {
        if ($user->foto_ktp && Storage::disk('public')->exists($user->foto_ktp)) {
            Storage::disk('public')->delete($user->foto_ktp);
        }
        
        $nik = $validated['nik'] ?? $user->nik ?? 'user_' . $user->id;
        $filename = 'ktp_' . time() . '_' . $nik . '.' . $file->getClientOriginalExtension();
        $filename = preg_replace('/[^a-z0-9\._-]/i', '_', $filename);
        
        return $file->storeAs('ktp', $filename, 'public');
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $user = $request->user();

        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        $path = $request->file('photo')->store('profile-photos', 'public');

        if (class_exists('Intervention\Image\Facades\Image')) {
            try {
                $image = Image::make(Storage::disk('public')->path($path));
                $image->fit(200, 200)->save();
            } catch (\Exception $e) {
                \Log::error('Error resizing profile photo: ' . $e->getMessage());
            }
        }

        $user->update([
            'profile_photo_path' => $path,
        ]);

        return back()->with('status', 'photo-updated')
            ->with('success', 'Foto profil berhasil diperbarui.');
    }

    public function updateKtp(Request $request)
    {
        $request->validate([
            'foto_ktp' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ]);

        $user = $request->user();

        $path = $this->handleKtpUpload($request->file('foto_ktp'), $user);

        $user->update([
            'foto_ktp' => $path,
        ]);

        $wasIncomplete = !$user->isProfileComplete();
        $isNowComplete = $user->isProfileComplete();
        
        if ($isNowComplete && $wasIncomplete && $user->role === 'warga') {
            $user->update(['is_verified' => true]);
            
            return redirect()->route('dashboard')
                ->with('success', 'Foto KTP berhasil diunggah! Profil sekarang lengkap.')
                ->with('profile-completed', true);
        }

        return back()->with('status', 'ktp-updated')
            ->with('success', 'Foto KTP berhasil diperbarui.');
    }

    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }
        if ($user->foto_ktp) {
            Storage::disk('public')->delete($user->foto_ktp);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('status', 'account-deleted');
    }
}