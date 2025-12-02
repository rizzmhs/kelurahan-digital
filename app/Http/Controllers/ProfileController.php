<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'alamat' => ['required', 'string', 'max:500'],
            'telepon' => ['required', 'string', 'max:15'],
            'tanggal_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['required', 'in:L,P'],
        ]);

        $user->update($validated);

        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $user = $request->user();

        // Hapus foto lama jika ada
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        // Simpan foto baru
        $path = $request->file('photo')->store('profile-photos', 'public');

        // Resize image
        $image = Image::make(Storage::disk('public')->path($path));
        $image->fit(200, 200)->save();

        $user->update([
            'profile_photo_path' => $path,
        ]);

        return back()->with('status', 'photo-updated');
    }

    public function updateKtp(Request $request)
    {
        $request->validate([
            'foto_ktp' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:5120'],
        ]);

        $user = $request->user();

        // Hapus KTP lama jika ada
        if ($user->foto_ktp) {
            Storage::disk('public')->delete($user->foto_ktp);
        }

        // Simpan KTP baru
        $path = $request->file('foto_ktp')->store('ktp-photos', 'public');

        $user->update([
            'foto_ktp' => $path,
        ]);

        return back()->with('status', 'ktp-updated');
    }

    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        // Hapus file yang terkait
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }
        if ($user->foto_ktp) {
            Storage::disk('public')->delete($user->foto_ktp);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}