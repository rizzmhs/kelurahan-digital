<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckProfileComplete
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        // Skip jika tidak ada user atau bukan warga
        if (!$user || $user->role !== User::ROLE_WARGA) {
            return $next($request);
        }
        
        // Cek apakah profile sudah lengkap
        if (!$user->isProfileComplete()) {
            // HANYA izinkan route profile.* dan logout
            $allowedRoutes = [
                'profile.edit',
                'profile.update',
                'profile.update.photo',
                'profile.update.ktp',
                'logout',
                'verification.notice',
                'verification.send',
                'verification.verify',
            ];
            
            $currentRoute = $request->route()->getName();
            
            // Jika mencoba akses route yang tidak diizinkan (termasuk dashboard)
            if (!in_array($currentRoute, $allowedRoutes)) {
                return redirect()->route('profile.edit')
                    ->with('error', 'Lengkapi profil Anda terlebih dahulu!')
                    ->with('warning', 'Anda hanya dapat mengakses halaman profil sampai data lengkap.');
            }
        }
        
        return $next($request);
    }
}