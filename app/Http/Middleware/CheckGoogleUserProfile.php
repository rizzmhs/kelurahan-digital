<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckGoogleUserProfile
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        // Skip jika tidak ada user atau bukan warga
        if (!$user || $user->role !== 'warga') {
            return $next($request);
        }
        
        // Cek apakah user login dengan Google DAN profil belum lengkap
        if ($this->isGoogleUserWithIncompleteProfile($user)) {
            // Daftar route yang diizinkan tanpa profil lengkap
            $allowedRoutes = [
                'profile.edit',
                'profile.update',
                'profile.update.photo',
                'profile.update.ktp',
                'logout',
                'verification.notice',
                'verification.send',
                'verification.verify',
                'dashboard', // Boleh akses dashboard tapi dengan warning
            ];
            
            $currentRoute = $request->route()->getName();
            
            // Jika mencoba akses route yang tidak diizinkan
            if (!in_array($currentRoute, $allowedRoutes)) {
                return redirect()->route('profile.edit')
                    ->with('error', 'Silakan lengkapi profil Anda terlebih dahulu sebelum mengakses fitur lain.')
                    ->with('warning', 'Anda login dengan Google. Data profil masih belum lengkap.');
            }
            
            // Tambahkan warning di dashboard jika profile tidak lengkap
            if ($currentRoute === 'dashboard') {
                $request->session()->flash('warning', 
                    'Profil Anda belum lengkap. Silakan lengkapi data profil untuk menggunakan semua fitur.');
            }
        }
        
        return $next($request);
    }
    
    /**
     * Cek apakah user Google dengan profil belum lengkap
     */
    private function isGoogleUserWithIncompleteProfile($user): bool
    {
        // Cek apakah user memiliki google_id (login dengan Google)
        if (empty($user->google_id)) {
            return false; // Bukan user Google
        }
        
        // Cek apakah profil sudah lengkap
        return !$this->isProfileComplete($user);
    }
    
    /**
     * Cek kelengkapan profil
     */
    private function isProfileComplete($user): bool
    {
        // Field wajib untuk warga
        $requiredFields = ['nik', 'telepon', 'alamat', 'tanggal_lahir', 'jenis_kelamin'];
        
        foreach ($requiredFields as $field) {
            if (empty($user->{$field})) {
                return false;
            }
        }
        
        return true;
    }
}