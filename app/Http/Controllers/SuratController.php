<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\JenisSurat;
use App\Models\RiwayatSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class SuratController extends Controller
{
    public function index()
    {
        $surats = Surat::with('jenisSurat')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('surat.index', compact('surats'));
    }

    public function create()
    {
        $jenisSurat = JenisSurat::active()->get();
        return view('surat.create', compact('jenisSurat'));
    }

    public function createDraft(JenisSurat $jenisSurat)
    {
        return view('surat.form', compact('jenisSurat'));
    }

    public function storeDraft(Request $request, JenisSurat $jenisSurat)
    {
        // Decode persyaratan JSON
        $persyaratan = json_decode($jenisSurat->persyaratan, true) ?? [];
        
        $validated = $request->validate($this->getValidationRules($persyaratan));

        // Handle file upload untuk persyaratan
        $filePaths = [];
        foreach ($persyaratan as $syarat) {
            if ($syarat['type'] === 'file' && $request->hasFile("file_{$syarat['field']}")) {
                $file = $request->file("file_{$syarat['field']}");
                $path = $file->store("surat/persyaratan/{$jenisSurat->kode}", 'public');
                $filePaths[$syarat['field']] = $path;
            }
        }

        $surat = Surat::create([
            'nomor_surat' => $this->generateNomorSurat($jenisSurat),
            'user_id' => auth()->id(),
            'jenis_surat_id' => $jenisSurat->id,
            'data_pengajuan' => $validated,
            'file_persyaratan' => $filePaths,
            'status' => 'draft',
        ]);

        // Buat riwayat
        RiwayatSurat::create([
            'surat_id' => $surat->id,
            'status' => 'draft',
            'catatan' => 'Surat dibuat sebagai draft',
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('warga.surat.show', $surat)
            ->with('success', 'Surat berhasil disimpan sebagai draft.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_surat_id' => 'required|exists:jenis_surat,id',
        ]);

        $jenisSurat = JenisSurat::findOrFail($request->jenis_surat_id);

        return redirect()->route('warga.surat.draft.create', $jenisSurat);
    }

    public function show(Surat $surat)
    {
        if ($surat->user_id !== auth()->id() && !auth()->user()->isAdmin() && !auth()->user()->isPetugas()) {
            abort(403, 'Unauthorized action.');
        }

        $surat->load(['jenisSurat', 'user', 'riwayat.user']);
        
        return view('surat.show', compact('surat'));
    }

    public function edit(Surat $surat)
    {
        if ($surat->user_id !== auth()->id() || !in_array($surat->status, ['draft', 'ditolak'])) {
            abort(403, 'Unauthorized action.');
        }

        return view('surat.edit', compact('surat'));
    }

    public function update(Request $request, Surat $surat)
    {
        if ($surat->user_id !== auth()->id() || !in_array($surat->status, ['draft', 'ditolak'])) {
            abort(403, 'Unauthorized action.');
        }

        // Decode persyaratan JSON
        $persyaratan = json_decode($surat->jenisSurat->persyaratan, true) ?? [];
        
        $validated = $request->validate($this->getValidationRules($persyaratan));

        // Handle file upload update
        $filePaths = $surat->file_persyaratan ?? [];
        foreach ($persyaratan as $syarat) {
            if ($syarat['type'] === 'file' && $request->hasFile("file_{$syarat['field']}")) {
                // Hapus file lama jika ada
                if (isset($filePaths[$syarat['field']])) {
                    Storage::disk('public')->delete($filePaths[$syarat['field']]);
                }

                $file = $request->file("file_{$syarat['field']}");
                $path = $file->store("surat/persyaratan/{$surat->jenisSurat->kode}", 'public');
                $filePaths[$syarat['field']] = $path;
            }
        }

        $surat->update([
            'data_pengajuan' => $validated,
            'file_persyaratan' => $filePaths,
        ]);

        return redirect()->route('warga.surat.show', $surat)
            ->with('success', 'Surat berhasil diperbarui.');
    }

    public function destroy(Surat $surat)
    {
        if ($surat->user_id !== auth()->id() || $surat->status !== 'draft') {
            abort(403, 'Unauthorized action.');
        }

        // Hapus file persyaratan
        if ($surat->file_persyaratan && is_array($surat->file_persyaratan)) {
            foreach ($surat->file_persyaratan as $file) {
                if ($file && is_string($file)) {
                    Storage::disk('public')->delete($file);
                }
            }
        }

        // Hapus file surat PDF jika ada
        if ($surat->file_surat) {
            Storage::disk('public')->delete($surat->file_surat);
        }

        $surat->delete();

        return redirect()->route('warga.surat.index')
            ->with('success', 'Surat berhasil dihapus.');
    }

    public function ajukanVerifikasi(Request $request, Surat $surat)
    {
        if ($surat->user_id !== auth()->id() || $surat->status !== 'draft') {
            abort(403, 'Unauthorized action.');
        }

        $surat->update(['status' => 'diajukan']);

        // Buat riwayat
        RiwayatSurat::create([
            'surat_id' => $surat->id,
            'status' => 'diajukan',
            'catatan' => 'Surat diajukan untuk verifikasi',
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Surat berhasil diajukan untuk verifikasi.');
    }

    public function batalkan(Request $request, Surat $surat)
    {
        if ($surat->user_id !== auth()->id() || $surat->status === 'selesai') {
            abort(403, 'Unauthorized action.');
        }

        $surat->update(['status' => 'draft']);

        // Buat riwayat
        RiwayatSurat::create([
            'surat_id' => $surat->id,
            'status' => 'draft',
            'catatan' => 'Pengajuan surat dibatalkan',
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Pengajuan surat berhasil dibatalkan.');
    }

    public function download(Surat $surat)
    {
        if ($surat->user_id !== auth()->id() || $surat->status !== 'siap_ambil') {
            abort(403, 'Unauthorized action.');
        }

        if (!$surat->file_surat) {
            abort(404, 'File surat tidak ditemukan.');
        }

        return Storage::disk('public')->download($surat->file_surat, "{$surat->nomor_surat}.pdf");
    }

    public function preview(Surat $surat)
    {
        if ($surat->user_id !== auth()->id() && !auth()->user()->isAdmin() && !auth()->user()->isPetugas()) {
            abort(403, 'Unauthorized action.');
        }

        if (!$surat->file_surat) {
            abort(404, 'File surat tidak ditemukan.');
        }

        return response()->file(Storage::disk('public')->path($surat->file_surat));
    }

    public function trackPublic($nomor)
    {
        $surat = Surat::where('nomor_surat', $nomor)
            ->with(['jenisSurat', 'user'])
            ->firstOrFail();

        return view('surat.track-public', compact('surat'));
    }

    public function checkStatus($nomor)
    {
        $surat = Surat::where('nomor_surat', $nomor)
            ->firstOrFail();

        return response()->json([
            'nomor' => $surat->nomor_surat,
            'status' => $surat->status,
            'jenis_surat' => $surat->jenisSurat->nama,
            'updated_at' => $surat->updated_at,
        ]);
    }

    private function getValidationRules(array $persyaratan)
    {
        $rules = [];
        foreach ($persyaratan as $syarat) {
            if ($syarat['type'] === 'file') {
                $rules["file_{$syarat['field']}"] = $syarat['required'] 
                    ? 'required|file|mimes:pdf,jpg,jpeg,png|max:5120'
                    : 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120';
            } else {
                $rules[$syarat['field']] = $syarat['required'] 
                    ? 'required|string|max:255'
                    : 'nullable|string|max:255';
            }
        }
        return $rules;
    }

    private function generateNomorSurat(JenisSurat $jenisSurat)
    {
        $timestamp = now()->format('Ymd');
        $random = Str::upper(Str::random(6));
        return "{$jenisSurat->kode}/{$timestamp}/{$random}";
    }
}