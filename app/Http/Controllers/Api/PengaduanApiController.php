<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\KategoriPengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PengaduanApiController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $pengaduans = Pengaduan::with('kategori')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $pengaduans
        ]);
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'kategori_pengaduan_id' => 'required|exists:kategori_pengaduan,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string|min:10',
            'lokasi' => 'required|string|max:500',
            'tanggal_kejadian' => 'required|date|before_or_equal:today',
            'foto_bukti.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

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
            'user_id' => $request->user()->id,
            'kategori_pengaduan_id' => $request->kategori_pengaduan_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'lokasi' => $request->lokasi,
            'tanggal_kejadian' => $request->tanggal_kejadian,
            'foto_bukti' => $fotoPaths,
            'status' => 'menunggu',
            'prioritas' => 'sedang',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pengaduan berhasil dikirim',
            'data' => $pengaduan
        ], 201);
    }

    public function show(Pengaduan $pengaduan)
    {
        // Authorization
        if ($pengaduan->user_id !== request()->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $pengaduan->load(['kategori', 'user', 'petugas']);

        return response()->json([
            'success' => true,
            'data' => $pengaduan
        ]);
    }

    public function trackPublic($kode)
    {
        $pengaduan = Pengaduan::where('kode_pengaduan', $kode)
            ->with(['kategori', 'user'])
            ->first();

        if (!$pengaduan) {
            return response()->json([
                'success' => false,
                'message' => 'Pengaduan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $pengaduan
        ]);
    }
}