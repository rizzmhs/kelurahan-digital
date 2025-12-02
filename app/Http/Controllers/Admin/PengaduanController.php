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

        $pengaduans = $query->latest()->paginate(20);
        $kategories = KategoriPengaduan::active()->get();
        $petugas = User::petugas()->get();

        return view('admin.pengaduan.index', compact('pengaduans', 'kategories', 'petugas'));
    }

    public function show(Pengaduan $pengaduan)
    {
        $pengaduan->load(['user', 'kategori', 'petugas']);
        return view('admin.pengaduan.show', compact('pengaduan'));
    }

    public function updateStatus(Request $request, Pengaduan $pengaduan)
    {
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

    public function updatePrioritas(Request $request, Pengaduan $pengaduan)
    {
        $validated = $request->validate([
            'prioritas' => 'required|in:rendah,sedang,tinggi,darurat',
        ]);

        $pengaduan->update($validated);

        return back()->with('success', 'Prioritas pengaduan berhasil diperbarui.');
    }

    public function assignPetugas(Request $request, Pengaduan $pengaduan)
    {
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

    public function updateTindakan(Request $request, Pengaduan $pengaduan)
    {
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

    public function verifikasi(Request $request, Pengaduan $pengaduan)
    {
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

    public function tolak(Request $request, Pengaduan $pengaduan)
    {
        $validated = $request->validate([
            'catatan_admin' => 'required|string|min:10|max:1000',
        ]);

        $pengaduan->update([
            'status' => 'ditolak',
            'catatan_admin' => $validated['catatan_admin'],
        ]);

        return back()->with('success', 'Pengaduan berhasil ditolak.');
    }

    public function selesai(Request $request, Pengaduan $pengaduan)
    {
        $pengaduan->update([
            'status' => 'selesai',
            'selesai_at' => now(),
        ]);

        return back()->with('success', 'Pengaduan berhasil ditandai sebagai selesai.');
    }

    public function destroy(Pengaduan $pengaduan)
    {
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

    public function riwayat(Pengaduan $pengaduan)
    {
        // Implementasi riwayat pengaduan
        return view('admin.pengaduan.riwayat', compact('pengaduan'));
    }

    public function exportExcel(Request $request)
    {
        // Implementasi export Excel
        return response()->download('path/to/export.xlsx');
    }

    public function exportPdf(Request $request)
    {
        // Implementasi export PDF
        return response()->download('path/to/export.pdf');
    }
}