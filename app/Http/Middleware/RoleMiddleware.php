<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Cek jika user tidak login
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = auth()->user();
        
        // Debug: Tambahkan log untuk melihat role user
        \Log::info('RoleMiddleware Check', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'user_role' => $user->role,
            'required_roles' => $roles
        ]);

        // Jika tidak ada role yang ditentukan, lanjutkan
        if (empty($roles)) {
            return $next($request);
        }

        // Ambil role user
        $userRole = $this->getUserRole($user);
        
        // Debug log
        \Log::info('User role detected', [
            'user_role' => $userRole,
            'expected_role' => $roles
        ]);

        // Cek jika user memiliki salah satu role yang diizinkan
        foreach ($roles as $role) {
            if ($userRole === strtolower($role)) {
                return $next($request);
            }
        }

        // Jika tidak memiliki role yang diizinkan
        $roleNames = [
            'admin' => 'Admin',
            'petugas' => 'Petugas', 
            'warga' => 'Warga'
        ];
        
        $userRoleName = $roleNames[$userRole] ?? 'Tidak ada role';
        $requiredRoles = array_map(function($role) use ($roleNames) {
            return $roleNames[$role] ?? $role;
        }, $roles);
        
        // Tambahkan log untuk debugging
        \Log::warning('Access denied', [
            'user_id' => $user->id,
            'user_role' => $userRole,
            'required_roles' => $roles,
            'path' => $request->path()
        ]);
        
        abort(403, 'Akses ditolak. Anda login sebagai ' . $userRoleName . 
              '. Role yang diizinkan: ' . implode(', ', $requiredRoles));
    }

    /**
     * Ambil role user secara konsisten
     */
    private function getUserRole($user): string
    {
        // Prioritaskan field role langsung
        if (isset($user->role) && !empty($user->role)) {
            return strtolower(trim($user->role));
        }
        
        // Jika menggunakan Spatie Permission
        if (method_exists($user, 'getRoleNames') && $user->getRoleNames()->isNotEmpty()) {
            return strtolower($user->getRoleNames()->first());
        }
        
        // Default ke 'warga' jika tidak ada role
        return 'warga';
    }
}