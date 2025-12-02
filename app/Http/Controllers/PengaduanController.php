<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\KategoriPengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    public function index()
    {
        $pengaduans = Pengaduan::with('kategori')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('pengaduan.index', compact('pengaduans'));
    }

    public function create()
    {
        $kategories = KategoriPengaduan::active()->get();
        return view('pengaduan.create', compact('kategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_pengaduan_id' => 'required|exists:kategori_pengaduan,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string|min:10',
            'lokasi' => 'required|string|max:500',
            'tanggal_kejadian' => 'required|date|before_or_equal:today',
            'foto_bukti.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        // Handle file upload
        $fotoPaths = [];
        if ($request->hasFile('foto_bukti')) {
            foreach ($request->file('foto_bukti') as $foto) {
                $path = $foto->store('pengaduan/bukti', 'public');
                $fotoPaths[] = $path;
            }
        }

        // Generate kode pengaduan
        $kodePengaduan = 'P' . date('Ymd') . Str::upper(Str::random(6));

        $pengaduan = Pengaduan::create([
            'kode_pengaduan' => $kodePengaduan,
            'user_id' => auth()->id(),
            'kategori_pengaduan_id' => $validated['kategori_pengaduan_id'],
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'lokasi' => $validated['lokasi'],
            'tanggal_kejadian' => $validated['tanggal_kejadian'],
            'foto_bukti' => $fotoPaths,
            'status' => 'menunggu',
            'prioritas' => 'sedang',
        ]);

        return redirect()->route('warga.pengaduan.show', $pengaduan)
            ->with('success', 'Pengaduan berhasil dikirim. Kode: ' . $kodePengaduan);
    }

    public function show(Pengaduan $pengaduan)
    {
        // Authorization
        if ($pengaduan->user_id !== auth()->id() && !auth()->user()->isAdmin() && !auth()->user()->isPetugas()) {
            abort(403, 'Unauthorized action.');
        }

        $pengaduan->load(['kategori', 'user', 'petugas']);
        
        return view('pengaduan.show', compact('pengaduan'));
    }

    public function edit(Pengaduan $pengaduan)
    {
        // Hanya pemilik yang bisa edit, dan hanya jika status menunggu
        if ($pengaduan->user_id !== auth()->id() || $pengaduan->status !== 'menunggu') {
            abort(403, 'Unauthorized action.');
        }

        $kategories = KategoriPengaduan::active()->get();
        return view('pengaduan.edit', compact('pengaduan', 'kategories'));
    }

    public function update(Request $request, Pengaduan $pengaduan)
    {
        // Hanya pemilik yang bisa edit, dan hanya jika status menunggu
        if ($pengaduan->user_id !== auth()->id() || $pengaduan->status !== 'menunggu') {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'kategori_pengaduan_id' => 'required|exists:kategori_pengaduan,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string|min:10',
            'lokasi' => 'required|string|max:500',
            'tanggal_kejadian' => 'required|date|before_or_equal:today',
        ]);

        $pengaduan->update($validated);

        return redirect()->route('warga.pengaduan.show', $pengaduan)
            ->with('success', 'Pengaduan berhasil diperbarui.');
    }

    public function destroy(Pengaduan $pengaduan)
    {
        // Hanya pemilik yang bisa hapus, dan hanya jika status menunggu
        if ($pengaduan->user_id !== auth()->id() || $pengaduan->status !== 'menunggu') {
            abort(403, 'Unauthorized action.');
        }

        // Hapus file foto jika ada
        if ($pengaduan->foto_bukti) {
            foreach ($pengaduan->foto_bukti as $foto) {
                Storage::disk('public')->delete($foto);
            }
        }

        $pengaduan->delete();

        return redirect()->route('warga.pengaduan.index')
            ->with('success', 'Pengaduan berhasil dihapus.');
    }

    public function uploadBukti(Request $request, Pengaduan $pengaduan)
    {
        if ($pengaduan->user_id !== auth()->id() || $pengaduan->status !== 'menunggu') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'foto_bukti.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $fotoPaths = $pengaduan->foto_bukti ?? [];

        if ($request->hasFile('foto_bukti')) {
            foreach ($request->file('foto_bukti') as $foto) {
                $path = $foto->store('pengaduan/bukti', 'public');
                $fotoPaths[] = $path;
            }
        }

        $pengaduan->update(['foto_bukti' => $fotoPaths]);

        return back()->with('success', 'Foto bukti berhasil ditambahkan.');
    }

    public function track(Pengaduan $pengaduan)
    {
        if ($pengaduan->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('pengaduan.track', compact('pengaduan'));
    }

    public function trackPublic($kode)
    {
        $pengaduan = Pengaduan::where('kode_pengaduan', $kode)
            ->with(['kategori', 'user'])
            ->firstOrFail();

        return view('pengaduan.track-public', compact('pengaduan'));
    }

    public function checkStatus($kode)
    {
        $pengaduan = Pengaduan::where('kode_pengaduan', $kode)
            ->firstOrFail();

        return response()->json([
            'kode' => $pengaduan->kode_pengaduan,
            'status' => $pengaduan->status,
            'judul' => $pengaduan->judul,
            'updated_at' => $pengaduan->updated_at,
        ]);
    }
}