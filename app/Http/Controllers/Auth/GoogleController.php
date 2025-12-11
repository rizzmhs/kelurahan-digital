<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController
{
    /**
     * Redirect ke Google OAuth
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback dari Google
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Gagal login dengan Google');
        }

        // Cari user berdasarkan google_id atau email
        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        // Jika user tidak ditemukan, buat user baru
        if (!$user) {
            $user = User::create([
                'google_id' => $googleUser->getId(),
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => bcrypt(uniqid()), // Password random untuk OAuth users
                'role' => 'warga', // Default role
                'is_verified' => true, // Otomatis verified karena dari Google
                'status' => 'active',
            ]);
        } else {
            // Update google_id dan token jika belum ada
            if (!$user->google_id) {
                $user->update([
                    'google_id' => $googleUser->getId(),
                ]);
            }
        }

        // Update token Google
        $user->update([
            'google_token' => $googleUser->token,
            'google_refresh_token' => $googleUser->refreshToken ?? $user->google_refresh_token,
        ]);

        // Login user
        Auth::login($user, remember: true);

        return redirect('/dashboard')->with('success', 'Login berhasil dengan Google!');
    }
}
