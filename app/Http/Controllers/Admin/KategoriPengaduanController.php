<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriPengaduan;
use Illuminate\Http\Request;

class KategoriPengaduanController extends Controller
{
    public function index()
    {
        $kategories = KategoriPengaduan::latest()->paginate(10);
        return view('admin.kategori_pengaduan.index', compact('kategories')); // ✅ FIXED: ganti ke underscore
    }

    public function create()
    {
        return view('admin.kategori_pengaduan.create'); // ✅ FIXED: ganti ke underscore
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_pengaduan',
            'deskripsi' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:50',
            'is_active' => 'boolean' // ✅ ADDED: field status
        ]);

        // Set default status jika tidak ada
        $validated['is_active'] = $validated['is_active'] ?? true;

        KategoriPengaduan::create($validated);

        return redirect()->route('admin.kategori_pengaduan.index') // ✅ FIXED: route name
            ->with('success', 'Kategori pengaduan berhasil dibuat.');
    }

    public function edit($id)
    {
        $kategori = KategoriPengaduan::findOrFail($id);
        return view('admin.kategori_pengaduan.edit', compact('kategori')); // ✅ FIXED: ganti ke underscore
    }

    public function update(Request $request, $id)
    {
        $kategori = KategoriPengaduan::findOrFail($id);
        
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_pengaduan,nama_kategori,' . $kategori->id,
            'deskripsi' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:50',
            'is_active' => 'boolean'
        ]);

        $kategori->update($validated);

        return redirect()->route('admin.kategori_pengaduan.index') // ✅ FIXED: route name
            ->with('success', 'Kategori pengaduan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kategori = KategoriPengaduan::findOrFail($id);
        
        // Check if kategori has pengaduan
        if ($kategori->pengaduans()->exists()) {
            return back()->with('error', 'Tidak dapat menghapus kategori yang memiliki pengaduan.');
        }

        $kategori->delete();

        return redirect()->route('admin.kategori_pengaduan.index') // ✅ FIXED: route name
            ->with('success', 'Kategori pengaduan berhasil dihapus.');
    }

    public function updateStatus(Request $request, $id)
    {
        $kategori = KategoriPengaduan::findOrFail($id);
        
        $kategori->update([
            'is_active' => !$kategori->is_active
        ]);

        $status = $kategori->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Kategori berhasil {$status}.");
    }

    public function show($id)
    {
        $kategori = KategoriPengaduan::with('pengaduans')->findOrFail($id);
        return view('admin.kategori_pengaduan.show', compact('kategori')); // ✅ FIXED: ganti ke underscore
    }
}