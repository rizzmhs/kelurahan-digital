<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Surat;
use App\Models\JenisSurat;
use App\Models\RiwayatSurat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class SuratController extends Controller
{
    public function index(Request $request)
    {
        $query = Surat::with(['user', 'jenisSurat']);

        // Filters
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('jenis_surat') && $request->jenis_surat != '') {
            $query->where('jenis_surat_id', $request->jenis_surat);
        }

        if ($request->has('tanggal_dari') && $request->tanggal_dari != '') {
            $query->whereDate('created_at', '>=', $request->tanggal_dari);
        }

        if ($request->has('tanggal_sampai') && $request->tanggal_sampai != '') {
            $query->whereDate('created_at', '<=', $request->tanggal_sampai);
        }

        $surats = $query->latest()->paginate(20);
        $jenisSurat = JenisSurat::active()->get();

        return view('admin.surat.index', compact('surats', 'jenisSurat'));
    }

    public function show(Surat $surat)
    {
        $surat->load(['user', 'jenisSurat', 'riwayat.user']);
        return view('admin.surat.show', compact('surat'));
    }

    public function updateStatus(Request $request, Surat $surat)
    {
        $validated = $request->validate([
            'status' => 'required|in:draft,diajukan,diproses,siap_ambil,selesai,ditolak',
            'catatan' => 'nullable|string|max:1000',
        ]);

        $surat->update(['status' => $validated['status']]);

        // Buat riwayat
        RiwayatSurat::create([
            'surat_id' => $surat->id,
            'status' => $validated['status'],
            'catatan' => $validated['catatan'] ?? 'Status surat diubah',
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Status surat berhasil diperbarui.');
    }

    public function verifikasi(Request $request, Surat $surat)
    {
        $validated = $request->validate([
            'catatan' => 'nullable|string|max:1000',
        ]);

        $surat->update(['status' => 'diproses']);

        RiwayatSurat::create([
            'surat_id' => $surat->id,
            'status' => 'diproses',
            'catatan' => $validated['catatan'] ?? 'Surat diverifikasi dan diproses',
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Surat berhasil diverifikasi dan diproses.');
    }

    public function tolak(Request $request, Surat $surat)
    {
        $validated = $request->validate([
            'catatan' => 'required|string|min:10|max:1000',
        ]);

        $surat->update(['status' => 'ditolak']);

        RiwayatSurat::create([
            'surat_id' => $surat->id,
            'status' => 'ditolak',
            'catatan' => $validated['catatan'],
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Surat berhasil ditolak.');
    }

    public function proses(Request $request, Surat $surat)
    {
        $surat->update(['status' => 'diproses']);

        RiwayatSurat::create([
            'surat_id' => $surat->id,
            'status' => 'diproses',
            'catatan' => 'Surat sedang diproses oleh admin',
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Surat sedang diproses.');
    }

    public function siapAmbil(Request $request, Surat $surat)
    {
        // Generate PDF jika belum ada
        if (!$surat->file_surat) {
            $this->generatePdf($request, $surat);
        }

        $surat->update(['status' => 'siap_ambil']);

        RiwayatSurat::create([
            'surat_id' => $surat->id,
            'status' => 'siap_ambil',
            'catatan' => 'Surat siap diambil/didownload',
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Surat telah siap diambil.');
    }

    public function selesai(Request $request, Surat $surat)
    {
        $surat->update(['status' => 'selesai']);

        RiwayatSurat::create([
            'surat_id' => $surat->id,
            'status' => 'selesai',
            'catatan' => 'Surat telah selesai',
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Surat telah diselesaikan.');
    }

    public function generatePdf(Request $request, Surat $surat)
    {
        $surat->load(['user', 'jenisSurat']);

        // Data untuk template
        $data = [
            'surat' => $surat,
            'user' => $surat->user,
            'jenisSurat' => $surat->jenisSurat,
            'data' => $surat->data_pengajuan,
            'tanggal' => now()->format('d F Y'),
        ];

        // Generate PDF
        $pdf = Pdf::loadView('surat.templates.' . $surat->jenisSurat->template, $data);
        
        // Simpan file
        $filename = "surat_{$surat->nomor_surat}.pdf";
        $path = "surat/result/{$filename}";
        Storage::disk('public')->put($path, $pdf->output());

        $surat->update(['file_surat' => $path]);

        return back()->with('success', 'PDF surat berhasil digenerate.');
    }

    public function preview(Surat $surat)
    {
        if (!$surat->file_surat) {
            abort(404, 'File surat belum digenerate.');
        }

        return response()->file(Storage::disk('public')->path($surat->file_surat));
    }

    public function editTemplate(Request $request, Surat $surat)
    {
        return view('admin.surat.edit-template', compact('surat'));
    }

    public function updateTemplate(Request $request, Surat $surat)
    {
        $validated = $request->validate([
            'template' => 'required|string',
        ]);

        // Update template custom untuk surat ini
        $surat->update(['custom_template' => $validated['template']]);

        return back()->with('success', 'Template surat berhasil diperbarui.');
    }

    public function riwayat(Surat $surat)
    {
        $riwayat = $surat->riwayat()->with('user')->latest()->get();
        return view('admin.surat.riwayat', compact('surat', 'riwayat'));
    }

    public function destroy(Surat $surat)
    {
        // Hapus file persyaratan
        if ($surat->file_persyaratan) {
            foreach ($surat->file_persyaratan as $file) {
                Storage::disk('public')->delete($file);
            }
        }

        // Hapus file surat PDF jika ada
        if ($surat->file_surat) {
            Storage::disk('public')->delete($surat->file_surat);
        }

        // Hapus riwayat
        $surat->riwayat()->delete();

        $surat->delete();

        return redirect()->route('admin.surat.index')
            ->with('success', 'Surat berhasil dihapus.');
    }

    // Quick create form for admin to create surat faster with dynamic form
    public function createQuick()
    {
        $jenisSurat = JenisSurat::active()->get();
        $users = User::warga()->verified()->active()->get();

        return view('admin.surat.quick-create', compact('jenisSurat', 'users'));
    }

    // Store quick-created surat with file handling
    public function storeQuick(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'jenis_surat_id' => 'required|exists:jenis_surat,id',
            'generate_pdf' => 'nullable|boolean',
            'data.*' => 'nullable',
            'file.*' => 'nullable|file|max:5120',
        ]);

        $user = User::findOrFail($validated['user_id']);
        $jenisSurat = JenisSurat::findOrFail($validated['jenis_surat_id']);

        // Parse data dari request
        $data = [];
        $filePaths = [];

        if ($request->has('data')) {
            foreach ($request->input('data', []) as $key => $value) {
                if (!empty($value)) {
                    $data[$key] = $value;
                }
            }
        }

        // Handle file uploads
        if ($request->hasAny('file')) {
            foreach ($request->file('file', []) as $key => $file) {
                if ($file) {
                    $path = $file->store("surat/persyaratan/{$jenisSurat->kode}", 'public');
                    $filePaths[$key] = $path;
                }
            }
        }

        // Merge file paths dengan data
        $data = array_merge($data, $filePaths);

        // Generate nomor surat
        $timestamp = now()->format('Ymd');
        $random = strtoupper(substr(md5(time()), 0, 6));
        $nomor = "{$jenisSurat->kode}/{$timestamp}/{$random}";

        // Create surat record
        $surat = Surat::create([
            'nomor_surat' => $nomor,
            'user_id' => $user->id,
            'jenis_surat_id' => $jenisSurat->id,
            'data_pengajuan' => $data,
            'status' => 'diproses',
        ]);

        // Create riwayat
        RiwayatSurat::create([
            'surat_id' => $surat->id,
            'status' => 'diproses',
            'catatan' => 'Surat dibuat oleh admin melalui quick-create.',
            'user_id' => auth()->id(),
        ]);

        // Optionally generate PDF
        if (!empty($validated['generate_pdf'])) {
            $this->generatePdf($request, $surat);
            $surat->update(['status' => 'siap_ambil']);

            RiwayatSurat::create([
                'surat_id' => $surat->id,
                'status' => 'siap_ambil',
                'catatan' => 'PDF digenerate otomatis oleh admin.',
                'user_id' => auth()->id(),
            ]);
        }

        return redirect()->route('admin.surat.show', $surat)
            ->with('success', 'Surat berhasil dibuat.');
    }
}