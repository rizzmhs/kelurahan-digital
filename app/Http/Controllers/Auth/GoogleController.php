<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            \Log::error('Google login error: ' . $e->getMessage());
            return redirect('/login')->with('error', 'Gagal login dengan Google. Silakan coba lagi.');
        }

        // Cari atau buat user
        $user = $this->findOrCreateUser($googleUser);

        // Login user
        Auth::login($user, remember: true);

        // Redirect langsung ke profile edit tanpa cek apapun
        return redirect()->route('profile.edit')
            ->with('success', 'Login dengan Google berhasil!')
            ->with('info', 'Silakan lengkapi data profil Anda terlebih dahulu.')
            ->with('warning', 'Anda hanya dapat mengakses halaman profil sampai data lengkap.');
    }

    private function findOrCreateUser($googleUser): User
    {
        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        if (!$user) {
            // User baru dari Google
            $user = User::create([
                'google_id' => $googleUser->getId(),
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => Hash::make(Str::random(24)),
                'role' => 'warga',
                'is_verified' => true,
                'status' => 'active',
                'email_verified_at' => now(),
                'google_token' => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken,
            ]);
        } else {
            // Update data Google
            $updateData = [
                'google_token' => $googleUser->token,
                'email_verified_at' => $user->email_verified_at ?? now(),
            ];
            
            if (!$user->google_id) {
                $updateData['google_id'] = $googleUser->getId();
            }
            
            if ($googleUser->refreshToken) {
                $updateData['google_refresh_token'] = $googleUser->refreshToken;
            }
            
            $user->update($updateData);
        }

        return $user;
    }
}