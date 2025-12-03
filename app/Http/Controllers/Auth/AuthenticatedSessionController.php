<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();
        
        // Redirect berdasarkan role user setelah login
        return $this->redirectBasedOnRole($user);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Redirect user based on their role.
     */
    protected function redirectBasedOnRole($user): RedirectResponse
    {
        // Jika user tidak memiliki role, redirect ke home
        if (!$user) {
            return redirect()->route('home');
        }

        // Cek role dengan berbagai metode
        $roleName = '';
        
        // 1. Cek jika user memiliki property role sebagai object
        if (is_object($user->role ?? null)) {
            $roleName = $user->role->name ?? '';
        } 
        // 2. Cek jika user memiliki property role sebagai string
        elseif (is_string($user->role ?? '')) {
            $roleName = $user->role;
        }
        // 3. Cek jika menggunakan Spatie/Permission atau Laravel Permission
        elseif (method_exists($user, 'getRoleNames') && $user->getRoleNames()->isNotEmpty()) {
            $roleName = $user->getRoleNames()->first();
        }
        // 4. Cek jika menggunakan role_id
        elseif (property_exists($user, 'role_id') && class_exists('App\Models\Role')) {
            try {
                $role = \App\Models\Role::find($user->role_id);
                $roleName = $role->name ?? 'warga';
            } catch (\Exception $e) {
                $roleName = 'warga';
            }
        }
        
        // Convert ke lowercase untuk konsistensi
        $roleName = strtolower($roleName);
        
        // Redirect berdasarkan role
        switch (true) {
            case str_contains($roleName, 'admin'):
            case $roleName === 'administrator':
            case $roleName === 'superadmin':
                return redirect()->route('admin.dashboard');
                
            case str_contains($roleName, 'petugas'):
            case $roleName === 'staff':
            case $roleName === 'officer':
            case $roleName === 'pegawai':
                return redirect()->route('petugas.dashboard');
                
            case str_contains($roleName, 'warga'):
            case $roleName === 'masyarakat':
            case $roleName === 'user':
            case $roleName === 'pengguna':
            default:
                return redirect()->route('dashboard');
        }
    }
}