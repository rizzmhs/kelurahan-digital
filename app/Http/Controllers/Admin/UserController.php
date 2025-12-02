<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Filters
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        if ($request->has('verified') && $request->verified != '') {
            $query->where('is_verified', $request->verified);
        }

        $users = $query->latest()->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:warga,petugas,admin'],
            'nik' => ['required', 'string', 'size:16', 'unique:users'],
            'alamat' => ['required', 'string', 'max:500'],
            'telepon' => ['required', 'string', 'max:15'],
            'tanggal_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['required', 'in:L,P'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'nik' => $validated['nik'],
            'alamat' => $validated['alamat'],
            'telepon' => $validated['telepon'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'is_verified' => true, // Auto-verify untuk admin created users
        ]);

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'User berhasil dibuat.');
    }

    public function show(User $user)
    {
        $user->loadCount(['pengaduans', 'surats']);
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'alamat' => ['required', 'string', 'max:500'],
            'telepon' => ['required', 'string', 'max:15'],
            'tanggal_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['required', 'in:L,P'],
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        // Prevent deletion if user has related data
        if ($user->pengaduans()->exists() || $user->surats()->exists()) {
            return back()->with('error', 'Tidak dapat menghapus user yang memiliki data terkait.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }

    public function verify(Request $request, User $user)
    {
        $user->update(['is_verified' => true]);

        return back()->with('success', 'User berhasil diverifikasi.');
    }

    public function updateRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => ['required', 'in:warga,petugas,admin'],
        ]);

        $user->update(['role' => $validated['role']]);

        return back()->with('success', 'Role user berhasil diperbarui.');
    }

    public function updateStatus(Request $request, User $user)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:active,suspended'],
        ]);

        $user->update(['status' => $validated['status']]);

        return back()->with('success', 'Status user berhasil diperbarui.');
    }
}