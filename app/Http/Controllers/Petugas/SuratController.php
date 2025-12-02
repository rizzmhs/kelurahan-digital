<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Surat;
use App\Models\JenisSurat;
use App\Models\RiwayatSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class SuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('nik', 'like', "%{$search}%");
                  });
            });
        }

        $surats = $query->latest()->paginate(15);
        $jenisSurat = JenisSurat::active()->get();
        $statuses = [
            'diajukan' => 'Diajukan',
            'diproses' => 'Diproses', 
            'siap_ambil' => 'Siap Ambil',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak'
        ];

        return view('petugas.surat.index', compact('surats', 'jenisSurat', 'statuses'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Surat $surat)
    {
        // Load relationships dengan safety check
        $surat->load(['user', 'jenisSurat']);
        
        // Cek jika relationship riwayat ada sebelum load
        if (method_exists($surat, 'riwayat') && class_exists(RiwayatSurat::class)) {
            $surat->load(['riwayat.user']);
        }
        
        return view('petugas.surat.show', compact('surat'));
    }

    /**
     * Update the status of the specified resource.
     */
    public function updateStatus(Request $request, Surat $surat)
    {
        $validated = $request->validate([
            'status' => 'required|in:diajukan,diproses,siap_ambil,selesai,ditolak',
            'catatan' => 'required|string|max:1000',
        ]);

        $oldStatus = $surat->status;
        
        // Update data berdasarkan status
        $updateData = ['status' => $validated['status']];
        
        // Jika status diproses, set petugas_id
        if ($validated['status'] == 'diproses' && !$surat->petugas_id) {
            $updateData['petugas_id'] = auth()->id();
        }
        
        // Jika status siap_ambil, set tanggal_verifikasi dan verifikator_id
        if ($validated['status'] == 'siap_ambil' && !$surat->tanggal_verifikasi) {
            $updateData['tanggal_verifikasi'] = now();
            $updateData['verifikator_id'] = auth()->id();
        }

        $surat->update($updateData);

        // Buat riwayat
        if (class_exists(RiwayatSurat::class)) {
            RiwayatSurat::create([
                'surat_id' => $surat->id,
                'status' => $validated['status'],
                'catatan' => $validated['catatan'],
                'user_id' => auth()->id(),
            ]);
        }

        return back()->with('success', 'Status surat berhasil diperbarui dari ' . $this->getStatusText($oldStatus) . ' menjadi ' . $this->getStatusText($validated['status']) . '.');
    }

    /**
     * Process the letter.
     */
    public function prosesSurat(Request $request, Surat $surat)
    {
        // Validasi status sebelumnya
        if ($surat->status != 'diajukan') {
            return back()->with('error', 'Surat hanya bisa diproses dari status "Diajukan".');
        }

        $validated = $request->validate([
            'catatan' => 'nullable|string|max:1000',
        ]);

        // Update status dan set petugas
        $surat->update([
            'status' => 'diproses',
            'petugas_id' => auth()->id(),
        ]);

        // Buat riwayat
        if (class_exists(RiwayatSurat::class)) {
            RiwayatSurat::create([
                'surat_id' => $surat->id,
                'status' => 'diproses',
                'catatan' => $validated['catatan'] ?? 'Surat diproses oleh petugas',
                'user_id' => auth()->id(),
            ]);
        }

        return back()->with('success', 'Surat sedang diproses.');
    }

    /**
     * Generate PDF for the letter.
     */
    public function generatePdf(Request $request, Surat $surat)
    {
        // Validasi status surat
        if ($surat->status !== 'diproses') {
            return back()->with('error', 'Surat harus dalam status "Diproses" untuk digenerate.');
        }

        // Validasi template exists
        $templateView = 'surat.templates.' . $surat->jenisSurat->template;
        if (!view()->exists($templateView)) {
            return back()->with('error', 'Template surat tidak ditemukan.');
        }

        try {
            $surat->load(['user', 'jenisSurat']);

            // Data untuk template
            $data = [
                'surat' => $surat,
                'user' => $surat->user,
                'jenisSurat' => $surat->jenisSurat,
                'data' => $surat->data_pengajuan ?? [],
                'tanggal' => now()->translatedFormat('d F Y'),
                'petugas' => auth()->user(),
                'tanggal_surat' => now()->format('Y-m-d'),
            ];

            // Generate PDF dengan options
            $pdf = Pdf::loadView($templateView, $data)
                     ->setPaper('a4', 'portrait')
                     ->setOption('defaultFont', 'Arial')
                     ->setOption('isHtml5ParserEnabled', true)
                     ->setOption('isRemoteEnabled', true);

            // Simpan file
            $filename = "surat_{$surat->nomor_surat}_{$surat->jenisSurat->nama}.pdf";
            $path = "surat/result/{$filename}";
            
            Storage::disk('public')->put($path, $pdf->output());

            // Update surat - gunakan kolom yang ada di database
            $surat->update([
                'file_surat' => $path,
                'status' => 'siap_ambil',
                'tanggal_verifikasi' => now(), // Gunakan tanggal_verifikasi yang sudah ada
                'verifikator_id' => auth()->id(),
            ]);

            // Buat riwayat
            if (class_exists(RiwayatSurat::class)) {
                RiwayatSurat::create([
                    'surat_id' => $surat->id,
                    'status' => 'siap_ambil',
                    'catatan' => 'PDF surat berhasil digenerate dan siap diambil',
                    'user_id' => auth()->id(),
                ]);
            }

            return back()->with('success', 'PDF surat berhasil digenerate dan status diubah menjadi "Siap Ambil".');

        } catch (\Exception $e) {
            \Log::error('PDF Generation Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal generate PDF: ' . $e->getMessage());
        }
    }

    /**
     * Preview generated PDF.
     */
    public function preview(Surat $surat)
    {
        if (!$surat->file_surat || !Storage::disk('public')->exists($surat->file_surat)) {
            abort(404, 'File surat belum digenerate atau tidak ditemukan.');
        }

        $filePath = Storage::disk('public')->path($surat->file_surat);
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($surat->file_surat) . '"'
        ]);
    }

    /**
     * Download PDF.
     */
    public function download(Surat $surat)
    {
        if (!$surat->file_surat || !Storage::disk('public')->exists($surat->file_surat)) {
            abort(404, 'File surat belum digenerate atau tidak ditemukan.');
        }

        $filePath = Storage::disk('public')->path($surat->file_surat);
        $filename = "surat_{$surat->nomor_surat}.pdf";

        return response()->download($filePath, $filename, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    /**
     * Show riwayat surat.
     */
    public function riwayat(Surat $surat)
    {
        // Safety check untuk riwayat
        if (method_exists($surat, 'riwayat') && class_exists(RiwayatSurat::class)) {
            $riwayat = $surat->riwayat()->with('user')->latest()->get();
        } else {
            $riwayat = collect(); // Return empty collection jika tidak ada
        }
        
        return view('petugas.surat.riwayat', compact('surat', 'riwayat'));
    }

    /**
     * Complete the letter process.
     */
    public function selesaikanSurat(Request $request, Surat $surat)
    {
        // Validasi status sebelumnya
        if ($surat->status != 'siap_ambil') {
            return back()->with('error', 'Surat hanya bisa diselesaikan dari status "Siap Ambil".');
        }

        $validated = $request->validate([
            'catatan' => 'nullable|string|max:1000',
        ]);

        $surat->update([
            'status' => 'selesai',
        ]);

        // Buat riwayat
        if (class_exists(RiwayatSurat::class)) {
            RiwayatSurat::create([
                'surat_id' => $surat->id,
                'status' => 'selesai',
                'catatan' => $validated['catatan'] ?? 'Surat telah selesai dan diambil oleh pemohon',
                'user_id' => auth()->id(),
            ]);
        }

        return back()->with('success', 'Surat telah diselesaikan.');
    }

    /**
     * Reject the letter.
     */
    public function tolakSurat(Request $request, Surat $surat)
    {
        $validated = $request->validate([
            'alasan_penolakan' => 'required|string|max:1000',
        ]);

        $surat->update([
            'status' => 'ditolak',
            'alasan_penolakan' => $validated['alasan_penolakan'],
        ]);

        // Buat riwayat
        if (class_exists(RiwayatSurat::class)) {
            RiwayatSurat::create([
                'surat_id' => $surat->id,
                'status' => 'ditolak',
                'catatan' => 'Surat ditolak: ' . $validated['alasan_penolakan'],
                'user_id' => auth()->id(),
            ]);
        }

        return back()->with('success', 'Surat telah ditolak.');
    }

    /**
     * Get status text for display.
     */
    private function getStatusText($status)
    {
        $statuses = [
            'diajukan' => 'Diajukan',
            'diproses' => 'Diproses',
            'siap_ambil' => 'Siap Ambil', 
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak'
        ];

        return $statuses[$status] ?? $status;
    }

    /**
     * Get statistics for dashboard.
     */
    public function dashboard()
    {
        $stats = [
            'total_surat' => Surat::count(),
            'surat_diajukan' => Surat::where('status', 'diajukan')->count(),
            'surat_diproses' => Surat::where('status', 'diproses')->count(),
            'surat_siap_ambil' => Surat::where('status', 'siap_ambil')->count(),
            'surat_selesai' => Surat::where('status', 'selesai')->count(),
        ];

        $suratTerbaru = Surat::with(['user', 'jenisSurat'])
                           ->latest()
                           ->take(10)
                           ->get();

        return view('petugas.dashboard', compact('stats', 'suratTerbaru'));
    }
}