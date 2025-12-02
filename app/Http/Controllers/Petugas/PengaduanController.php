<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\KategoriPengaduan;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengaduan::with(['user', 'kategori', 'petugas']);

        // Filters
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
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

        $pengaduans = $query->latest()->paginate(15);

        return view('petugas.pengaduan.index', compact('pengaduans'));
    }

    /**
     * Display pengaduan yang ditugaskan kepada petugas yang login
     */
    public function tugasSaya(Request $request)
    {
        $query = Pengaduan::with(['user', 'kategori'])
                         ->where('petugas_id', auth()->id());

        // Filters
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('prioritas') && $request->prioritas != '') {
            $query->where('prioritas', $request->prioritas);
        }

        $pengaduans = $query->latest()->paginate(15);

        return view('petugas.pengaduan.tugas-saya', compact('pengaduans'));
    }

    public function show(Pengaduan $pengaduan)
    {
        // ✅ SIMPLE AUTHORIZATION: Petugas dan admin bisa akses
        if (!auth()->user()->isPetugas() && !auth()->user()->isAdmin()) {
            abort(403, 'Hanya petugas dan admin yang bisa mengakses.');
        }

        $pengaduan->load(['user', 'kategori', 'riwayat.user']);
        return view('petugas.pengaduan.show', compact('pengaduan'));
    }

    public function updateStatus(Request $request, Pengaduan $pengaduan)
    {
        // ✅ SIMPLE AUTHORIZATION: Petugas dan admin bisa update
        if (!auth()->user()->isPetugas() && !auth()->user()->isAdmin()) {
            abort(403, 'Hanya petugas dan admin yang bisa mengupdate.');
        }

        // Petugas hanya bisa update pengaduan yang ditugaskan ke mereka
        if (auth()->user()->isPetugas() && $pengaduan->petugas_id !== auth()->id()) {
            abort(403, 'Anda hanya bisa mengupdate pengaduan yang ditugaskan kepada Anda.');
        }

        $validated = $request->validate([
            'status' => 'required|in:diajukan,diproses,selesai,ditolak',
            'catatan' => 'nullable|string|max:1000',
        ]);

        $oldStatus = $pengaduan->status;
        $pengaduan->update(['status' => $validated['status']]);

        // Jika status diproses dan belum ada petugas, assign petugas saat ini
        if ($validated['status'] == 'diproses' && !$pengaduan->petugas_id) {
            $pengaduan->update(['petugas_id' => auth()->id()]);
        }

        // Buat riwayat
        $pengaduan->riwayat()->create([
            'status' => $validated['status'],
            'catatan' => $validated['catatan'] ?? 'Status diubah oleh petugas',
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Status pengaduan berhasil diperbarui.');
    }

    public function updateTindakan(Request $request, Pengaduan $pengaduan)
    {
        // ✅ SIMPLE AUTHORIZATION
        if (!auth()->user()->isPetugas() && !auth()->user()->isAdmin()) {
            abort(403, 'Hanya petugas dan admin yang bisa mengupdate.');
        }

        if (auth()->user()->isPetugas() && $pengaduan->petugas_id !== auth()->id()) {
            abort(403, 'Anda hanya bisa mengupdate pengaduan yang ditugaskan kepada Anda.');
        }

        $validated = $request->validate([
            'tindakan' => 'required|string|max:2000',
        ]);

        $pengaduan->update(['tindakan' => $validated['tindakan']]);

        return back()->with('success', 'Tindakan berhasil diperbarui.');
    }

    public function uploadPenanganan(Request $request, Pengaduan $pengaduan)
    {
        // ✅ SIMPLE AUTHORIZATION
        if (!auth()->user()->isPetugas() && !auth()->user()->isAdmin()) {
            abort(403, 'Hanya petugas dan admin yang bisa mengupload.');
        }

        if (auth()->user()->isPetugas() && $pengaduan->petugas_id !== auth()->id()) {
            abort(403, 'Anda hanya bisa mengupload bukti untuk pengaduan yang ditugaskan kepada Anda.');
        }

        $validated = $request->validate([
            'bukti_penanganan' => 'required|array',
            'bukti_penanganan.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $uploadedFiles = [];
        foreach ($request->file('bukti_penanganan') as $file) {
            $path = $file->store('bukti_penanganan', 'public');
            $uploadedFiles[] = $path;
        }

        // Update atau tambah ke bukti penanganan yang sudah ada
        $existingFiles = $pengaduan->bukti_penanganan ? json_decode($pengaduan->bukti_penanganan) : [];
        $allFiles = array_merge($existingFiles, $uploadedFiles);
        
        $pengaduan->update(['bukti_penanganan' => json_encode($allFiles)]);

        return back()->with('success', 'Bukti penanganan berhasil diupload.');
    }

    public function riwayat(Pengaduan $pengaduan)
    {
        // ✅ SIMPLE AUTHORIZATION
        if (!auth()->user()->isPetugas() && !auth()->user()->isAdmin()) {
            abort(403, 'Hanya petugas dan admin yang bisa mengakses.');
        }

        $riwayat = $pengaduan->riwayat()->with('user')->latest()->get();
        return view('petugas.pengaduan.riwayat', compact('pengaduan', 'riwayat'));
    }

    public function dashboard()
    {
        $stats = [
            'total_pengaduan' => Pengaduan::count(),
            'pengaduan_diajukan' => Pengaduan::where('status', 'diajukan')->count(),
            'pengaduan_diproses' => Pengaduan::where('status', 'diproses')->count(),
            'pengaduan_selesai' => Pengaduan::where('status', 'selesai')->count(),
            'tugas_saya' => Pengaduan::where('petugas_id', auth()->id())->count(),
        ];

        $pengaduanTerbaru = Pengaduan::with(['user', 'kategori'])
                                   ->latest()
                                   ->take(10)
                                   ->get();

        return view('petugas.dashboard', compact('stats', 'pengaduanTerbaru'));
    }
}