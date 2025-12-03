<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi semua field
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nik' => ['required', 'string', 'size:16', 'regex:/^[0-9]{16}$/', 'unique:users'],
            'telepon' => ['required', 'string', 'max:15', 'regex:/^[0-9]{10,15}$/'],
            'tanggal_lahir' => ['required', 'date', 'before_or_equal:' . now()->subYears(17)->format('Y-m-d')],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'alamat' => ['required', 'string', 'max:500'],
            'foto_ktp' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'terms' => ['required', 'accepted'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.size' => 'NIK harus terdiri dari 16 digit angka.',
            'nik.regex' => 'NIK harus terdiri dari 16 digit angka.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'telepon.required' => 'Nomor telepon wajib diisi.',
            'telepon.regex' => 'Nomor telepon harus terdiri dari 10-15 digit angka.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.before_or_equal' => 'Anda harus berusia minimal 17 tahun untuk mendaftar.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin tidak valid.',
            'alamat.required' => 'Alamat wajib diisi.',
            'foto_ktp.required' => 'Foto KTP wajib diunggah.',
            'foto_ktp.mimes' => 'File harus berupa JPG, JPEG, PNG, atau PDF.',
            'foto_ktp.max' => 'Ukuran file maksimal 2MB.',
            'terms.required' => 'Anda harus menyetujui syarat dan ketentuan.',
            'terms.accepted' => 'Anda harus menyetujui syarat dan ketentuan.',
        ]);

        try {
            // Handle upload foto KTP
            $fotoKtpPath = null;
            if ($request->hasFile('foto_ktp')) {
                $file = $request->file('foto_ktp');
                
                // Generate nama file yang aman
                $filename = 'ktp_' . time() . '_' . $validated['nik'] . '.' . $file->getClientOriginalExtension();
                $filename = preg_replace('/[^a-z0-9\._-]/i', '_', $filename);
                
                // Simpan file ke storage
                $fotoKtpPath = $file->storeAs('ktp', $filename, 'public');
            }

            // Create user dengan semua data
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'nik' => $validated['nik'],
                'telepon' => $validated['telepon'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'alamat' => $validated['alamat'],
                'foto_ktp' => $fotoKtpPath,
                'role' => 'warga', // Default role sesuai model
                'is_verified' => false, // Menunggu verifikasi admin
                'status' => 'active', // Default status 'active' sesuai scope di model
                'email_verified_at' => null, // Akan diverifikasi via email
            ]);

            // Fire registered event untuk trigger email verification
            event(new Registered($user));

            // Login user secara otomatis
            Auth::login($user);

            // Log activity (opsional)
            if (method_exists($user, 'logActivity')) {
                $user->logActivity('register', 'User melakukan registrasi akun baru');
            }

            // Redirect dengan pesan sukses
            return redirect(route('dashboard', absolute: false))
                ->with('success', 'Registrasi berhasil! Selamat datang di Sistem Layanan Kelurahan Terpadu. Akun Anda sedang menunggu verifikasi admin.');

        } catch (\Exception $e) {
            // Jika ada error saat upload file, hapus file yang sudah terupload
            if (isset($fotoKtpPath) && Storage::disk('public')->exists($fotoKtpPath)) {
                Storage::disk('public')->delete($fotoKtpPath);
            }

            // Log error
            \Log::error('Registration error: ' . $e->getMessage(), [
                'user_data' => [
                    'name' => $validated['name'] ?? null,
                    'email' => $validated['email'] ?? null,
                    'nik' => $validated['nik'] ?? null,
                ],
                'error' => $e->getMessage(),
            ]);

            // Redirect back dengan error
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat registrasi. Silakan coba lagi.');
        }
    }

    /**
     * Custom validation untuk cek usia minimal 17 tahun
     */
    protected function validateAge($attribute, $value, $parameters, $validator)
    {
        $minAge = 17;
        $birthDate = new \DateTime($value);
        $today = new \DateTime();
        $age = $today->diff($birthDate)->y;
        
        return $age >= $minAge;
    }
}