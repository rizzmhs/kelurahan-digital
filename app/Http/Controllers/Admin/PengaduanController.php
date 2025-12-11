<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\KategoriPengaduan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    /**
     * Display a listing of pengaduans.
     */
    public function index(Request $request)
    {
        $query = Pengaduan::with(['user', 'kategori', 'petugas']);

        // Filters
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori_pengaduan_id', $request->kategori);
        }

        if ($request->has('prioritas') && $request->prioritas != '') {
            $query->where('prioritas', $request->prioritas);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('kode_pengaduan', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('nik', 'like', "%{$search}%");
                  });
            });
        }

        $pengaduans = $query->latest()->paginate(20);
        $kategories = KategoriPengaduan::all();
        $petugas = User::where('role', 'petugas')->get();

        return view('admin.pengaduan.index', compact('pengaduans', 'kategories', 'petugas'));
    }

    /**
     * Display the specified pengaduan.
     */
    public function show(Pengaduan $pengaduan)
    {
        // ✅ SIMPLE AUTHORIZATION: Hanya admin yang bisa akses
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Hanya admin yang bisa mengakses.');
        }

        $pengaduan->load(['user', 'kategori', 'petugas']);
        $petugas = User::where('role', 'petugas')->get();
        
        return view('admin.pengaduan.show', compact('pengaduan', 'petugas'));
    }

    /**
     * Show the form for editing the specified pengaduan.
     */
    public function edit(Pengaduan $pengaduan)
    {
        // ✅ SIMPLE AUTHORIZATION: Hanya admin yang bisa edit
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Hanya admin yang bisa mengedit.');
        }

        $pengaduan->load(['user', 'kategori', 'petugas']);
        $kategories = KategoriPengaduan::all();
        $petugas = User::where('role', 'petugas')->get();
        
        return view('admin.pengaduan.edit', compact('pengaduan', 'kategories', 'petugas'));
    }

    /**
     * Update the specified pengaduan.
     */
    public function update(Request $request, Pengaduan $pengaduan)
    {
        // ✅ SIMPLE AUTHORIZATION: Hanya admin yang bisa update
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Hanya admin yang bisa mengupdate.');
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string|min:10',
            'lokasi' => 'required|string|max:500',
            'kategori_pengaduan_id' => 'required|exists:kategori_pengaduan,id',
            'prioritas' => 'required|in:rendah,sedang,tinggi,darurat',
            'catatan_admin' => 'nullable|string|max:1000',
        ]);

        $pengaduan->update($validated);

        return redirect()->route('admin.pengaduan.show', $pengaduan)
            ->with('success', 'Pengaduan berhasil diperbarui.');
    }

    /**
     * Update the status of specified pengaduan.
     */
    public function updateStatus(Request $request, Pengaduan $pengaduan)
    {
        // ✅ SIMPLE AUTHORIZATION: Hanya admin yang bisa update status
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Hanya admin yang bisa mengupdate status.');
        }

        $validated = $request->validate([
            'status' => 'required|in:menunggu,diverifikasi,diproses,selesai,ditolak',
            'catatan_admin' => 'nullable|string|max:1000',
        ]);

        // Update timestamp berdasarkan status
        $timestampFields = [
            'diverifikasi' => 'diverifikasi_at',
            'diproses' => 'diproses_at',
            'selesai' => 'selesai_at'
        ];

        if (isset($timestampFields[$validated['status']])) {
            $validated[$timestampFields[$validated['status']]] = now();
        }

        $pengaduan->update($validated);

        return back()->with('success', 'Status pengaduan berhasil diperbarui.');
    }

    /**
     * Update the priority of specified pengaduan.
     */
    public function updatePrioritas(Request $request, Pengaduan $pengaduan)
    {
        // ✅ SIMPLE AUTHORIZATION: Hanya admin yang bisa update prioritas
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Hanya admin yang bisa mengupdate prioritas.');
        }

        $validated = $request->validate([
            'prioritas' => 'required|in:rendah,sedang,tinggi,darurat',
        ]);

        $pengaduan->update($validated);

        return back()->with('success', 'Prioritas pengaduan berhasil diperbarui.');
    }

    /**
     * Assign petugas to pengaduan.
     */
    public function assignPetugas(Request $request, Pengaduan $pengaduan)
    {
        // ✅ SIMPLE AUTHORIZATION: Hanya admin yang bisa assign petugas
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Hanya admin yang bisa menugaskan petugas.');
        }

        $validated = $request->validate([
            'petugas_id' => 'required|exists:users,id',
            'catatan_admin' => 'nullable|string|max:1000',
        ]);

        $pengaduan->update([
            'petugas_id' => $validated['petugas_id'],
            'status' => 'diproses',
            'diproses_at' => now(),
            'catatan_admin' => $validated['catatan_admin'] ?? $pengaduan->catatan_admin,
        ]);

        return back()->with('success', 'Petugas berhasil ditugaskan.');
    }

    /**
     * Update tindakan for pengaduan.
     */
    public function updateTindakan(Request $request, Pengaduan $pengaduan)
    {
        // ✅ SIMPLE AUTHORIZATION: Hanya admin yang bisa update tindakan
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Hanya admin yang bisa mengupdate tindakan.');
        }

        $validated = $request->validate([
            'tindakan' => 'required|string|min:10',
            'foto_penanganan.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        // Handle file upload untuk foto penanganan
        if ($request->hasFile('foto_penanganan')) {
            $fotoPaths = $pengaduan->foto_penanganan ?? [];
            foreach ($request->file('foto_penanganan') as $foto) {
                $path = $foto->store('pengaduan/penanganan', 'public');
                $fotoPaths[] = $path;
            }
            $validated['foto_penanganan'] = $fotoPaths;
        }

        $pengaduan->update($validated);

        return back()->with('success', 'Tindakan berhasil diperbarui.');
    }

    /**
     * Verify pengaduan.
     */
    public function verifikasi(Request $request, Pengaduan $pengaduan)
    {
        // ✅ SIMPLE AUTHORIZATION: Hanya admin yang bisa verifikasi
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Hanya admin yang bisa memverifikasi.');
        }

        $validated = $request->validate([
            'catatan_admin' => 'nullable|string|max:1000',
        ]);

        $pengaduan->update([
            'status' => 'diverifikasi',
            'diverifikasi_at' => now(),
            'catatan_admin' => $validated['catatan_admin'] ?? $pengaduan->catatan_admin,
        ]);

        return back()->with('success', 'Pengaduan berhasil diverifikasi.');
    }

    /**
     * Reject pengaduan.
     */
    public function tolak(Request $request, Pengaduan $pengaduan)
    {
        // ✅ SIMPLE AUTHORIZATION: Hanya admin yang bisa tolak
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Hanya admin yang bisa menolak pengaduan.');
        }

        $validated = $request->validate([
            'catatan_admin' => 'required|string|min:10|max:1000',
        ]);

        $pengaduan->update([
            'status' => 'ditolak',
            'catatan_admin' => $validated['catatan_admin'],
        ]);

        return back()->with('success', 'Pengaduan berhasil ditolak.');
    }

    /**
     * Mark pengaduan as completed.
     */
    public function selesai(Request $request, Pengaduan $pengaduan)
    {
        // ✅ SIMPLE AUTHORIZATION: Hanya admin yang bisa tandai selesai
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Hanya admin yang bisa menandai selesai.');
        }

        $pengaduan->update([
            'status' => 'selesai',
            'selesai_at' => now(),
        ]);

        return back()->with('success', 'Pengaduan berhasil ditandai sebagai selesai.');
    }

    /**
     * Remove the specified pengaduan.
     */
    public function destroy(Pengaduan $pengaduan)
    {
        // ✅ SIMPLE AUTHORIZATION: Hanya admin yang bisa delete
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Hanya admin yang bisa menghapus.');
        }

        // Hapus file foto jika ada
        if ($pengaduan->foto_bukti) {
            foreach ($pengaduan->foto_bukti as $foto) {
                Storage::disk('public')->delete($foto);
            }
        }

        if ($pengaduan->foto_penanganan) {
            foreach ($pengaduan->foto_penanganan as $foto) {
                Storage::disk('public')->delete($foto);
            }
        }

        $pengaduan->delete();

        return redirect()->route('admin.pengaduan.index')
            ->with('success', 'Pengaduan berhasil dihapus.');
    }

    /**
     * Show riwayat of pengaduan.
     */
    public function riwayat(Pengaduan $pengaduan)
    {
        // ✅ SIMPLE AUTHORIZATION: Hanya admin yang bisa akses riwayat
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Hanya admin yang bisa mengakses riwayat.');
        }

        return view('admin.pengaduan.riwayat', compact('pengaduan'));
    }

    /**
     * Export pengaduan to Excel.
     */
    public function exportExcel(Request $request)
    {
        // ✅ SIMPLE AUTHORIZATION: Hanya admin yang bisa export
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Hanya admin yang bisa export.');
        }

        // Implementasi export Excel
        return response()->download('path/to/export.xlsx');
    }

    /**
     * Export pengaduan to PDF.
     */
    public function exportPdf(Request $request)
    {
        // ✅ SIMPLE AUTHORIZATION: Hanya admin yang bisa export
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Hanya admin yang bisa export.');
        }

        // Implementasi export PDF
        return response()->download('path/to/export.pdf');
    }
}