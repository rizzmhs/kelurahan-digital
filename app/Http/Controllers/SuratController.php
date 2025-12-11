<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\JenisSurat;
use App\Models\RiwayatSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class SuratController extends Controller
{
    public function index()
    {
        $query = Surat::with(['jenisSurat', 'petugas', 'verifikator'])
            ->where('user_id', auth()->id())
            ->latest();

        // Filter berdasarkan status jika ada
        if (request('status')) {
            $query->where('status', request('status'));
        }

        // Search
        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                  ->orWhereHas('jenisSurat', function ($q) use ($search) {
                      $q->where('nama', 'like', "%{$search}%");
                  })
                  ->orWhereHas('user', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $surats = $query->paginate(10);

        // Status untuk filter
        $statuses = [
            'draft' => 'Draft',
            'diajukan' => 'Diajukan',
            'diproses' => 'Diproses',
            'siap_ambil' => 'Siap Ambil',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak'
        ];

        // Stats
        $stats = [
            'total' => Surat::where('user_id', auth()->id())->count(),
            'diajukan' => Surat::where('user_id', auth()->id())->where('status', 'diajukan')->count(),
            'diproses' => Surat::where('user_id', auth()->id())->where('status', 'diproses')->count(),
            'siap_ambil' => Surat::where('user_id', auth()->id())->where('status', 'siap_ambil')->count(),
            'selesai' => Surat::where('user_id', auth()->id())->where('status', 'selesai')->count(),
            'ditolak' => Surat::where('user_id', auth()->id())->where('status', 'ditolak')->count(),
        ];

        return view('surat.index', compact('surats', 'statuses', 'stats'));
    }

    public function create()
    {
        $jenisSurat = JenisSurat::active()->get();
        return view('surat.create', compact('jenisSurat'));
    }

    public function createDraft(JenisSurat $jenisSurat)
    {
        // Check if user can create draft
        if (!$jenisSurat->is_active) {
            abort(404, 'Jenis surat tidak aktif.');
        }

        return view('surat.form', compact('jenisSurat'));
    }

    public function storeDraft(Request $request, JenisSurat $jenisSurat)
    {
        // Check if jenis surat is active
        if (!$jenisSurat->is_active) {
            return redirect()->back()->withErrors(['error' => 'Jenis surat tidak aktif.']);
        }

        // Decode persyaratan JSON
        $persyaratan = json_decode($jenisSurat->persyaratan, true) ?? [];
        
        $validated = $request->validate($this->getValidationRules($persyaratan));

        // Handle file upload untuk persyaratan
        $filePaths = [];
        foreach ($persyaratan as $syarat) {
            if ($syarat['type'] === 'file' && $request->hasFile("file_{$syarat['field']}")) {
                $file = $request->file("file_{$syarat['field']}");
                $filename = Str::slug($syarat['label']) . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs("surat/persyaratan/{$jenisSurat->kode}", $filename, 'public');
                $filePaths[$syarat['field']] = $path;
            }
        }

        // Generate nomor surat jika draft diajukan
        $nomorSurat = $request->has('ajukan_sekarang') 
            ? $this->generateNomorSurat($jenisSurat)
            : null;

        $surat = Surat::create([
            'nomor_surat' => $nomorSurat,
            'user_id' => auth()->id(),
            'jenis_surat_id' => $jenisSurat->id,
            'data_pengajuan' => $validated,
            'file_persyaratan' => $filePaths,
            'status' => $request->has('ajukan_sekarang') ? 'diajukan' : 'draft',
            'tanggal_verifikasi' => $request->has('ajukan_sekarang') ? now() : null,
        ]);

        // Buat riwayat
        $status = $request->has('ajukan_sekarang') ? 'diajukan' : 'draft';
        RiwayatSurat::create([
            'surat_id' => $surat->id,
            'user_id' => auth()->id(),
            'status' => $status,
            'catatan' => $status == 'draft' ? 'Surat dibuat sebagai draft' : 'Surat diajukan untuk verifikasi',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $message = $request->has('ajukan_sekarang') 
            ? 'Surat berhasil diajukan untuk verifikasi.' 
            : 'Surat berhasil disimpan sebagai draft.';

        return redirect()->route('warga.surat.show', $surat)
            ->with('success', $message);
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_surat_id' => 'required|exists:jenis_surat,id',
        ]);

        $jenisSurat = JenisSurat::findOrFail($request->jenis_surat_id);

        // Check if jenis surat is active
        if (!$jenisSurat->is_active) {
            return redirect()->back()->withErrors(['error' => 'Jenis surat tidak aktif.']);
        }

        return redirect()->route('warga.surat.draft.create', $jenisSurat);
    }

    public function show(Surat $surat)
    {
        // Authorization
        if ($surat->user_id !== auth()->id() && !auth()->user()->isAdmin() && !auth()->user()->isPetugas()) {
            abort(403, 'Anda tidak memiliki akses untuk melihat surat ini.');
        }

        // Load semua relasi
        $surat->load(['jenisSurat', 'user', 'petugas', 'verifikator', 'riwayat.user']);
        
        return view('surat.show', compact('surat'));
    }

    public function edit(Surat $surat)
    {
        // Authorization
        if ($surat->user_id !== auth()->id() || !in_array($surat->status, ['draft', 'ditolak'])) {
            abort(403, 'Anda tidak dapat mengedit surat ini.');
        }

        return view('surat.edit', [
            'surat' => $surat->load('jenisSurat'),
        ]);
    }

    public function update(Request $request, Surat $surat)
    {
        // Authorization
        if ($surat->user_id !== auth()->id() || !in_array($surat->status, ['draft', 'ditolak'])) {
            abort(403, 'Anda tidak dapat mengedit surat ini.');
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
                $filename = Str::slug($syarat['label']) . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs("surat/persyaratan/{$surat->jenisSurat->kode}", $filename, 'public');
                $filePaths[$syarat['field']] = $path;
            }
        }

        $surat->update([
            'data_pengajuan' => $validated,
            'file_persyaratan' => $filePaths,
            'updated_at' => now(),
        ]);

        // Riwayat
        RiwayatSurat::create([
            'surat_id' => $surat->id,
            'user_id' => auth()->id(),
            'status' => $surat->status,
            'catatan' => 'Surat diperbarui',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('warga.surat.show', $surat)
            ->with('success', 'Surat berhasil diperbarui.');
    }

    public function destroy(Surat $surat)
    {
        // Authorization
        if ($surat->user_id !== auth()->id() || $surat->status !== 'draft') {
            abort(403, 'Anda hanya dapat menghapus surat dengan status draft.');
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

        // Hapus riwayat terkait
        RiwayatSurat::where('surat_id', $surat->id)->delete();

        $surat->delete();

        return redirect()->route('warga.surat.index')
            ->with('success', 'Surat berhasil dihapus.');
    }

    public function ajukanVerifikasi(Request $request, Surat $surat)
    {
        // Authorization
        if ($surat->user_id !== auth()->id() || $surat->status !== 'draft') {
            abort(403, 'Hanya surat draft yang dapat diajukan.');
        }

        // Pastikan semua persyaratan terpenuhi
        $persyaratan = json_decode($surat->jenisSurat->persyaratan, true) ?? [];
        foreach ($persyaratan as $syarat) {
            if ($syarat['required']) {
                if ($syarat['type'] === 'file') {
                    if (empty($surat->file_persyaratan[$syarat['field']] ?? null)) {
                        return back()->withErrors([
                            'error' => "File {$syarat['label']} harus diunggah sebelum mengajukan verifikasi."
                        ]);
                    }
                } else {
                    // Check text/input fields
                    $fieldValue = $surat->data_pengajuan[$syarat['field']] ?? null;
                    if (empty($fieldValue)) {
                        return back()->withErrors([
                            'error' => "Field {$syarat['label']} harus diisi sebelum mengajukan verifikasi."
                        ]);
                    }
                }
            }
        }

        $surat->update([
            'status' => 'diajukan',
            'tanggal_verifikasi' => now(),
            'verifikator_id' => null,
            'nomor_surat' => $surat->nomor_surat ?? $this->generateNomorSurat($surat->jenisSurat),
            'updated_at' => now(),
        ]);

        // Buat riwayat
        RiwayatSurat::create([
            'surat_id' => $surat->id,
            'user_id' => auth()->id(),
            'status' => 'diajukan',
            'catatan' => 'Surat diajukan untuk verifikasi',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Surat berhasil diajukan untuk verifikasi.');
    }

    public function batalkan(Request $request, Surat $surat)
    {
        // Authorization
        if ($surat->user_id !== auth()->id() || !in_array($surat->status, ['diajukan', 'diproses'])) {
            abort(403, 'Anda hanya dapat membatalkan surat dengan status diajukan atau diproses.');
        }

        $surat->update([
            'status' => 'draft',
            'petugas_id' => null,
            'verifikator_id' => null,
            'updated_at' => now(),
        ]);

        // Buat riwayat
        RiwayatSurat::create([
            'surat_id' => $surat->id,
            'user_id' => auth()->id(),
            'status' => 'draft',
            'catatan' => 'Pengajuan surat dibatalkan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Pengajuan surat berhasil dibatalkan.');
    }

    public function download(Surat $surat)
    {
        // Authorization
        if ($surat->user_id !== auth()->id() && !auth()->user()->isAdmin() && !auth()->user()->isPetugas()) {
            abort(403, 'Anda tidak memiliki akses untuk mengunduh file ini.');
        }

        if (!$surat->file_surat) {
            abort(404, 'File surat tidak ditemukan.');
        }

        if ($surat->user_id === auth()->id() && !in_array($surat->status, ['siap_ambil', 'selesai'])) {
            abort(403, 'File surat hanya dapat diunduh untuk surat yang siap diambil atau selesai.');
        }

        $filename = $surat->nomor_surat 
            ? str_replace('/', '-', $surat->nomor_surat) . '.pdf'
            : 'surat-' . $surat->id . '.pdf';
        
        return Storage::disk('public')->download($surat->file_surat, $filename);
    }

    public function preview(Surat $surat)
    {
        // Authorization
        if ($surat->user_id !== auth()->id() && !auth()->user()->isAdmin() && !auth()->user()->isPetugas()) {
            abort(403, 'Anda tidak memiliki akses untuk melihat surat ini.');
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
            ->with('jenisSurat')
            ->firstOrFail();

        return response()->json([
            'nomor' => $surat->nomor_surat,
            'status' => $surat->status,
            'status_display' => $surat->status_display,
            'jenis_surat' => $surat->jenisSurat->nama,
            'created_at' => $surat->created_at->format('d/m/Y H:i'),
            'updated_at' => $surat->updated_at->format('d/m/Y H:i'),
            'file_available' => !empty($surat->file_surat),
        ]);
    }

    private function getValidationRules(array $persyaratan)
    {
        $rules = [];
        foreach ($persyaratan as $syarat) {
            $fieldName = $syarat['field'];
            
            if ($syarat['type'] === 'file') {
                $rules["file_{$fieldName}"] = $syarat['required'] 
                    ? 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120'
                    : 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120';
            } else {
                $validation = [];
                
                if ($syarat['required'] ?? false) {
                    $validation[] = 'required';
                } else {
                    $validation[] = 'nullable';
                }
                
                // Tentukan tipe validasi berdasarkan type
                switch ($syarat['type'] ?? 'text') {
                    case 'email':
                        $validation[] = 'email';
                        $validation[] = 'max:255';
                        break;
                    case 'number':
                        $validation[] = 'numeric';
                        break;
                    case 'date':
                        $validation[] = 'date';
                        break;
                    case 'textarea':
                        $validation[] = 'string';
                        $validation[] = 'max:1000';
                        break;
                    default: // text, select, radio
                        $validation[] = 'string';
                        $validation[] = 'max:255';
                }
                
                $rules[$fieldName] = implode('|', $validation);
            }
        }
        return $rules;
    }

    private function generateNomorSurat(JenisSurat $jenisSurat)
    {
        $year = date('Y');
        $month = date('m');
        
        $lastSurat = Surat::where('jenis_surat_id', $jenisSurat->id)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('id', 'desc')
            ->first();

        $sequence = 1;
        if ($lastSurat && $lastSurat->nomor_surat) {
            $lastNumber = $lastSurat->nomor_surat;
            if (preg_match('/\/(\d+)$/', $lastNumber, $matches)) {
                $sequence = (int)$matches[1] + 1;
            }
        }

        $kode = $jenisSurat->kode ?? 'S';
        return "{$kode}/{$jenisSurat->id}/{$year}/{$month}/" . str_pad($sequence, 3, '0', STR_PAD_LEFT);
    }

    public function riwayat(Surat $surat)
    {
        // Authorization
        if ($surat->user_id !== auth()->id() && !auth()->user()->isAdmin() && !auth()->user()->isPetugas()) {
            abort(403, 'Anda tidak memiliki akses untuk melihat riwayat surat ini.');
        }

        $riwayat = RiwayatSurat::where('surat_id', $surat->id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('surat.riwayat', compact('surat', 'riwayat'));
    }

    public function perbaruiStatus(Request $request, Surat $surat)
    {
        // Authorization - hanya admin atau petugas yang ditugaskan
        if (!auth()->user()->isAdmin() && $surat->petugas_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengupdate status surat ini.');
        }

        $request->validate([
            'status' => 'required|in:diajukan,diproses,siap_ambil,selesai',
            'catatan' => 'nullable|string|max:1000',
        ]);

        $oldStatus = $surat->status;
        $newStatus = $request->status;
        $catatan = $request->catatan;

        // Validasi transisi status
        $validTransitions = [
            'diajukan' => ['diproses'],
            'diproses' => ['siap_ambil'],
            'siap_ambil' => ['selesai'],
        ];

        if (isset($validTransitions[$oldStatus]) && !in_array($newStatus, $validTransitions[$oldStatus])) {
            return back()->withErrors([
                'error' => "Tidak dapat mengubah status dari {$oldStatus} ke {$newStatus}."
            ]);
        }

        // Update surat
        $updateData = [
            'status' => $newStatus,
            'updated_at' => now(),
        ];

        // Set timestamp sesuai status
        switch ($newStatus) {
            case 'diproses':
                $updateData['tanggal_proses'] = now();
                $updateData['petugas_id'] = $surat->petugas_id ?? auth()->id();
                $updateData['diproses_pada'] = now();
                break;
            case 'siap_ambil':
                $updateData['tanggal_siap'] = now();
                break;
            case 'selesai':
                $updateData['tanggal_selesai'] = now();
                break;
        }

        $surat->update($updateData);

        // Buat riwayat
        RiwayatSurat::create([
            'surat_id' => $surat->id,
            'user_id' => auth()->id(),
            'status' => $newStatus,
            'catatan' => $catatan ?? "Status diubah dari {$oldStatus} menjadi {$newStatus}",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', "Status surat berhasil diubah menjadi {$newStatus}.");
    }

    public function tolak(Request $request, Surat $surat)
    {
        // Authorization - hanya admin atau verifikator
        if (!auth()->user()->isAdmin() && !auth()->user()->isVerifikator()) {
            abort(403, 'Anda tidak memiliki akses untuk menolak surat.');
        }

        $request->validate([
            'alasan_penolakan' => 'required|string|min:10|max:1000',
        ]);

        // Hanya bisa menolak surat yang diajukan
        if ($surat->status !== 'diajukan') {
            return back()->withErrors([
                'error' => 'Hanya surat dengan status diajukan yang dapat ditolak.'
            ]);
        }

        $surat->update([
            'status' => 'ditolak',
            'alasan_penolakan' => $request->alasan_penolakan,
            'updated_at' => now(),
        ]);

        // Buat riwayat
        RiwayatSurat::create([
            'surat_id' => $surat->id,
            'user_id' => auth()->id(),
            'status' => 'ditolak',
            'catatan' => "Surat ditolak. Alasan: {$request->alasan_penolakan}",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Surat berhasil ditolak.');
    }

    // ✅ TAMBAHKAN METHOD UNTUK UPLOAD FILE SYARAT TAMBAHAN
    public function uploadSyarat(Request $request, Surat $surat)
    {
        // Authorization
        if ($surat->user_id !== auth()->id() || !in_array($surat->status, ['draft', 'ditolak'])) {
            abort(403, 'Anda tidak dapat mengupload file untuk surat ini.');
        }

        $request->validate([
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
            'nama_file' => 'required|string|max:100',
        ]);

        $file = $request->file('file');
        $filename = Str::slug($request->nama_file) . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs("surat/syarat-tambahan/{$surat->id}", $filename, 'public');

        // Simpan ke data_pengajuan atau field khusus
        $filePersyaratan = $surat->file_persyaratan ?? [];
        $filePersyaratan[$request->nama_file] = $path;
        
        $surat->update([
            'file_persyaratan' => $filePersyaratan,
            'updated_at' => now(),
        ]);

        // Riwayat
        RiwayatSurat::create([
            'surat_id' => $surat->id,
            'user_id' => auth()->id(),
            'status' => $surat->status,
            'catatan' => "File {$request->nama_file} diupload",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'File berhasil diupload.');
    }
}