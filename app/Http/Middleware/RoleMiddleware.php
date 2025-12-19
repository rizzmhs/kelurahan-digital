<?php

namespace App\Http\Middleware;

use App\Models\User;
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
            // Simpan intended URL untuk redirect setelah login
            if (!$request->is('login')) {
                session()->put('url.intended', $request->fullUrl());
            }
            
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = auth()->user();
        
        // Jika tidak ada role yang ditentukan, lanjutkan
        if (empty($roles)) {
            return $next($request);
        }

        // Normalize roles to lowercase
        $roles = array_map('strtolower', $roles);
        
        // Cek jika user memiliki salah satu role yang diizinkan
        if ($this->hasAnyRole($user, $roles)) {
            return $next($request);
        }

        // Jika tidak memiliki role yang diizinkan
        return $this->handleUnauthorizedAccess($user, $roles, $request);
    }

    /**
     * Check if user has any of the required roles
     */
    private function hasAnyRole($user, array $roles): bool
    {
        $userRole = $this->getUserRole($user);
        
        return in_array($userRole, $roles, true);
    }

    /**
     * Get user role consistently
     */
    private function getUserRole($user): string
    {
        // Gunakan cache untuk menghindari pemrosesan berulang
        return cache()->remember("user.{$user->id}.role", 60, function () use ($user) {
            // Prioritaskan field role langsung
            if (isset($user->role) && !empty($user->role)) {
                return strtolower(trim($user->role));
            }
            
            // Jika menggunakan Spatie Permission (optional)
            if (method_exists($user, 'getRoleNames') && $user->getRoleNames()->isNotEmpty()) {
                return strtolower($user->getRoleNames()->first());
            }
            
            // Default ke 'warga' jika tidak ada role
            return 'warga';
        });
    }

    /**
     * Handle unauthorized access
     */
    private function handleUnauthorizedAccess($user, array $roles, Request $request): Response
    {
        $userRole = $this->getUserRole($user);
        
        // Log hanya untuk debugging atau monitoring
        if (config('app.debug')) {
            \Log::warning('RoleMiddleware: Access denied', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'user_role' => $userRole,
                'required_roles' => $roles,
                'path' => $request->path(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);
        }
        
        // Berikan response berdasarkan tipe request
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Akses ditolak. Anda tidak memiliki izin untuk mengakses resource ini.',
                'error' => 'Forbidden',
                'status' => 403
            ], 403);
        }
        
        // Untuk web request
        $roleNames = $this->getRoleDisplayNames();
        $userRoleName = $roleNames[$userRole] ?? ucfirst($userRole);
        $requiredRoles = array_map(function($role) use ($roleNames) {
            return $roleNames[$role] ?? ucfirst($role);
        }, $roles);
        
        // Redirect berdasarkan role user
        return $this->redirectBasedOnRole($userRole, $userRoleName, $requiredRoles);
    }

    /**
     * Get role display names
     */
    private function getRoleDisplayNames(): array
    {
        return [
            User::ROLE_ADMIN => 'Administrator',
            User::ROLE_PETUGAS => 'Petugas',
            User::ROLE_WARGA => 'Warga'
        ];
    }

    /**
     * Redirect user based on their role
     */
    private function redirectBasedOnRole(string $userRole, string $userRoleName, array $requiredRoles): Response
    {
        $message = 'Akses ditolak. Anda login sebagai ' . $userRoleName . 
                  '. Role yang diizinkan: ' . implode(', ', $requiredRoles);
        
        // Redirect ke dashboard yang sesuai dengan role
        switch ($userRole) {
            case User::ROLE_ADMIN:
                return redirect()->route('admin.dashboard')
                    ->with('error', $message);
                    
            case User::ROLE_PETUGAS:
                return redirect()->route('petugas.dashboard')
                    ->with('error', $message);
                    
            case User::ROLE_WARGA:
            default:
                return redirect()->route('dashboard')
                    ->with('error', $message);
        }
    }
}