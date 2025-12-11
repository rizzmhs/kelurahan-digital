<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Surat;
use App\Models\JenisSurat;
use App\Models\RiwayatSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class SuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Surat::with(['user', 'jenisSurat', 'petugas', 'verifikator']);

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
                  })
                  ->orWhereHas('jenisSurat', function($q) use ($search) {
                      $q->where('nama', 'like', "%{$search}%");
                  });
            });
        }

        // Untuk petugas non-admin, hanya tampilkan yang ditugaskan atau belum ada petugas
        if (!auth()->user()->isAdmin()) {
            $query->where(function($q) {
                $q->where('petugas_id', auth()->id())
                  ->orWhereNull('petugas_id');
            });
        }

        $surats = $query->latest()->paginate(15);
        $jenisSurat = JenisSurat::active()->get();
        $statuses = [
            'draft' => 'Draft',
            'diajukan' => 'Diajukan',
            'diproses' => 'Diproses', 
            'siap_ambil' => 'Siap Ambil',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak'
        ];

        // Stats untuk dashboard
        $stats = [
            'total' => $query->clone()->count(),
            'diajukan' => $query->clone()->where('status', 'diajukan')->count(),
            'diproses' => $query->clone()->where('status', 'diproses')->count(),
            'siap_ambil' => $query->clone()->where('status', 'siap_ambil')->count(),
            'selesai' => $query->clone()->where('status', 'selesai')->count(),
            'ditolak' => $query->clone()->where('status', 'ditolak')->count(),
        ];

        return view('petugas.surat.index', compact('surats', 'jenisSurat', 'statuses', 'stats'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Surat $surat)
    {
        // Authorization check
        if (!auth()->user()->isAdmin() && $surat->petugas_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk melihat surat ini.');
        }

        // Load relationships
        $surat->load(['user', 'jenisSurat', 'petugas', 'verifikator', 'riwayat.user']);
        
        return view('petugas.surat.show', compact('surat'));
    }

    /**
     * Update the status of the specified resource.
     */
    public function updateStatus(Request $request, Surat $surat)
    {
        // Authorization
        if (!auth()->user()->isAdmin() && $surat->petugas_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengupdate status surat ini.');
        }

        $validated = $request->validate([
            'status' => 'required|in:diajukan,diproses,siap_ambil,selesai,ditolak',
            'catatan' => 'required|string|max:1000',
        ]);

        $oldStatus = $surat->status;
        $newStatus = $validated['status'];
        
        // Validasi transisi status yang valid
        $validTransitions = [
            'diajukan' => ['diproses', 'ditolak'],
            'diproses' => ['siap_ambil', 'ditolak'],
            'siap_ambil' => ['selesai', 'ditolak'],
            'selesai' => [], // Tidak bisa diubah dari selesai
            'ditolak' => ['diajukan'], // Hanya bisa kembali ke diajukan
        ];

        if (isset($validTransitions[$oldStatus]) && !in_array($newStatus, $validTransitions[$oldStatus])) {
            return back()->with('error', 
                "Tidak dapat mengubah status dari {$this->getStatusText($oldStatus)} ke {$this->getStatusText($newStatus)}."
            );
        }

        // Jika status ditolak, validasi alasan penolakan
        if ($newStatus === 'ditolak' && !$request->has('alasan_penolakan')) {
            return back()->with('error', 'Alasan penolakan harus diisi untuk menolak surat.');
        }

        DB::beginTransaction();
        try {
            // Update data berdasarkan status
            $updateData = [
                'status' => $newStatus,
                'updated_at' => now(),
            ];

            // Set data tambahan berdasarkan status
            switch ($newStatus) {
                case 'diproses':
                    $updateData['petugas_id'] = $surat->petugas_id ?? auth()->id();
                    $updateData['tanggal_proses'] = now();
                    $updateData['diproses_pada'] = now();
                    break;
                case 'siap_ambil':
                    $updateData['tanggal_siap'] = now();
                    // Set verifikator jika belum ada
                    if (!$surat->tanggal_verifikasi) {
                        $updateData['tanggal_verifikasi'] = now();
                        $updateData['verifikator_id'] = auth()->id();
                    }
                    break;
                case 'selesai':
                    $updateData['tanggal_selesai'] = now();
                    break;
                case 'ditolak':
                    $updateData['alasan_penolakan'] = $request->alasan_penolakan;
                    break;
            }

            // Jika kembali ke diajukan dari ditolak
            if ($oldStatus == 'ditolak' && $newStatus == 'diajukan') {
                $updateData['alasan_penolakan'] = null;
                $updateData['verifikator_id'] = null;
                $updateData['tanggal_verifikasi'] = null;
            }

            $surat->update($updateData);

            // Buat riwayat
            RiwayatSurat::create([
                'surat_id' => $surat->id,
                'user_id' => auth()->id(),
                'status' => $newStatus,
                'catatan' => $validated['catatan'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            return back()->with('success', 
                "Status surat berhasil diperbarui dari {$this->getStatusText($oldStatus)} menjadi {$this->getStatusText($newStatus)}."
            );

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Update status error: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengupdate status: ' . $e->getMessage());
        }
    }

    /**
     * Process the letter.
     */
    public function prosesSurat(Request $request, Surat $surat)
    {
        // Authorization
        if (!auth()->user()->isAdmin() && $surat->petugas_id && $surat->petugas_id !== auth()->id()) {
            return back()->with('error', 'Surat ini sudah ditugaskan ke petugas lain.');
        }

        // Validasi status sebelumnya
        if ($surat->status != 'diajukan') {
            return back()->with('error', 'Surat hanya bisa diproses dari status "Diajukan".');
        }

        $validated = $request->validate([
            'catatan' => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();
        try {
            // Update status dan set petugas
            $surat->update([
                'status' => 'diproses',
                'petugas_id' => auth()->id(),
                'tanggal_proses' => now(),
                'diproses_pada' => now(),
                'updated_at' => now(),
            ]);

            // Buat riwayat
            RiwayatSurat::create([
                'surat_id' => $surat->id,
                'user_id' => auth()->id(),
                'status' => 'diproses',
                'catatan' => $validated['catatan'] ?? 'Surat diambil untuk diproses',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            return back()->with('success', 'Surat berhasil diambil untuk diproses.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Proses surat error: ' . $e->getMessage());
            return back()->with('error', 'Gagal memproses surat: ' . $e->getMessage());
        }
    }

    /**
     * Generate PDF for the letter.
     */
    public function generatePdf(Request $request, Surat $surat)
    {
        // Authorization
        if (!auth()->user()->isAdmin() && $surat->petugas_id !== auth()->id()) {
            return back()->with('error', 'Anda tidak memiliki akses untuk generate PDF surat ini.');
        }

        // Validasi status surat
        if ($surat->status !== 'diproses') {
            return back()->with('error', 'Surat harus dalam status "Diproses" untuk digenerate.');
        }

        DB::beginTransaction();
        try {
            $surat->load(['user', 'jenisSurat', 'petugas']);

            // Cek template yang akan digunakan
            $templateName = $surat->jenisSurat->template ?? 'default';
            $templateView = "surat.templates.{$templateName}";
            
            // Fallback ke default jika template tidak ada
            if (!view()->exists($templateView)) {
                $templateView = 'surat.templates.default';
            }

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

            // Generate PDF
            $pdf = Pdf::loadView($templateView, $data)
                     ->setPaper('a4', 'portrait')
                     ->setOption('defaultFont', 'Arial')
                     ->setOption('isHtml5ParserEnabled', true)
                     ->setOption('isRemoteEnabled', true);

            // Simpan file dengan nama yang lebih baik
            $nomorFile = $surat->nomor_surat 
                ? str_replace('/', '-', $surat->nomor_surat) 
                : 'surat-' . $surat->id . '-' . time();
            
            $filename = $nomorFile . ".pdf";
            $path = "surat/result/" . $filename;
            
            Storage::disk('public')->put($path, $pdf->output());

            // Update surat
            $surat->update([
                'file_surat' => $path,
                'status' => 'siap_ambil',
                'tanggal_siap' => now(),
                'updated_at' => now(),
            ]);

            // Buat riwayat
            RiwayatSurat::create([
                'surat_id' => $surat->id,
                'user_id' => auth()->id(),
                'status' => 'siap_ambil',
                'catatan' => 'PDF surat berhasil digenerate',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            return back()->with('success', 'PDF surat berhasil digenerate dan status diubah menjadi "Siap Ambil".');

        } catch (\Exception $e) {
            DB::rollBack();
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
        // Authorization - admin, petugas yang ditugaskan, atau pemilik surat
        $isOwner = $surat->user_id == auth()->id();
        $isAssignedPetugas = $surat->petugas_id == auth()->id();
        
        if (!auth()->user()->isAdmin() && !$isOwner && !$isAssignedPetugas) {
            abort(403, 'Anda tidak memiliki akses untuk mengunduh file ini.');
        }

        // Jika warga, hanya boleh download saat status siap_ambil atau selesai
        if ($isOwner && !in_array($surat->status, ['siap_ambil', 'selesai'])) {
            abort(403, 'File surat hanya dapat diunduh untuk surat yang siap diambil atau selesai.');
        }

        if (!$surat->file_surat || !Storage::disk('public')->exists($surat->file_surat)) {
            abort(404, 'File surat belum digenerate atau tidak ditemukan.');
        }

        $filename = $surat->nomor_surat 
            ? str_replace('/', '-', $surat->nomor_surat) . '.pdf'
            : 'surat-' . $surat->id . '.pdf';

        return Storage::disk('public')->download($surat->file_surat, $filename);
    }

    /**
     * Show riwayat surat.
     */
    public function riwayat(Surat $surat)
    {
        // Authorization
        if (!auth()->user()->isAdmin() && $surat->petugas_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk melihat riwayat surat ini.');
        }

        $riwayat = RiwayatSurat::where('surat_id', $surat->id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('petugas.surat.riwayat', compact('surat', 'riwayat'));
    }

    /**
     * Complete the letter process.
     */
    public function selesai(Request $request, Surat $surat)
    {
        // Authorization
        if (!auth()->user()->isAdmin() && $surat->petugas_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk menyelesaikan surat ini.');
        }

        // Validasi status sebelumnya
        if ($surat->status != 'siap_ambil') {
            return back()->with('error', 'Surat hanya bisa diselesaikan dari status "Siap Ambil".');
        }

        $validated = $request->validate([
            'catatan' => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();
        try {
            $surat->update([
                'status' => 'selesai',
                'tanggal_selesai' => now(),
                'updated_at' => now(),
            ]);

            // Buat riwayat
            RiwayatSurat::create([
                'surat_id' => $surat->id,
                'user_id' => auth()->id(),
                'status' => 'selesai',
                'catatan' => $validated['catatan'] ?? 'Surat telah selesai diambil oleh pemohon',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            return back()->with('success', 'Surat telah diselesaikan.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Selesai surat error: ' . $e->getMessage());
            return back()->with('error', 'Gagal menyelesaikan surat: ' . $e->getMessage());
        }
    }

    /**
     * Reject the letter.
     */
    public function tolak(Request $request, Surat $surat)
    {
        // Authorization - hanya admin atau petugas yang ditugaskan
        if (!auth()->user()->isAdmin() && $surat->petugas_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk menolak surat ini.');
        }

        $validated = $request->validate([
            'alasan_penolakan' => 'required|string|min:10|max:1000',
        ]);

        // Hanya bisa menolak surat yang diajukan atau diproses
        if (!in_array($surat->status, ['diajukan', 'diproses'])) {
            return back()->with('error', 'Hanya surat dengan status Diajukan atau Diproses yang dapat ditolak.');
        }

        DB::beginTransaction();
        try {
            $surat->update([
                'status' => 'ditolak',
                'alasan_penolakan' => $validated['alasan_penolakan'],
                'updated_at' => now(),
            ]);

            // Buat riwayat
            RiwayatSurat::create([
                'surat_id' => $surat->id,
                'user_id' => auth()->id(),
                'status' => 'ditolak',
                'catatan' => 'Surat ditolak. Alasan: ' . $validated['alasan_penolakan'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            return back()->with('success', 'Surat telah ditolak.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Tolak surat error: ' . $e->getMessage());
            return back()->with('error', 'Gagal menolak surat: ' . $e->getMessage());
        }
    }

    /**
     * Get status text for display.
     */
    private function getStatusText($status)
    {
        $statuses = [
            'draft' => 'Draft',
            'diajukan' => 'Diajukan',
            'diproses' => 'Diproses',
            'siap_ambil' => 'Siap Ambil', 
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak'
        ];

        return $statuses[$status] ?? $status;
    }

    /**
     * ✅ TAMBAHKAN METHOD generate() UNTUK ROUTE YANG DIPANGGIL
     * Method ini sebagai alias untuk generatePdf
     */
    public function generate(Request $request, Surat $surat)
    {
        // Redirect ke generatePdf atau panggil langsung
        return $this->generatePdf($request, $surat);
    }

    /**
     * ✅ TAMBAHKAN METHOD edit() JIKA DIPERLUKAN
     */
    public function edit(Surat $surat)
    {
        // Authorization
        if (!auth()->user()->isAdmin() && $surat->petugas_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit surat ini.');
        }

        // Hanya surat dengan status tertentu yang bisa diedit
        if (!in_array($surat->status, ['diproses', 'ditolak'])) {
            abort(403, 'Hanya surat dengan status Diproses atau Ditolak yang dapat diedit.');
        }

        $surat->load(['user', 'jenisSurat']);
        
        return view('petugas.surat.edit', compact('surat'));
    }

    /**
     * ✅ TAMBAHKAN METHOD update() JIKA DIPERLUKAN
     */
    public function update(Request $request, Surat $surat)
    {
        // Authorization
        if (!auth()->user()->isAdmin() && $surat->petugas_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengupdate surat ini.');
        }

        // Hanya surat dengan status tertentu yang bisa diupdate
        if (!in_array($surat->status, ['diproses', 'ditolak'])) {
            return back()->with('error', 'Hanya surat dengan status Diproses atau Ditolak yang dapat diupdate.');
        }

        $validated = $request->validate([
            'catatan_admin' => 'nullable|string|max:1000',
            'keterangan' => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();
        try {
            $surat->update([
                'catatan_admin' => $validated['catatan_admin'] ?? $surat->catatan_admin,
                'keterangan' => $validated['keterangan'] ?? $surat->keterangan,
                'updated_at' => now(),
            ]);

            // Buat riwayat jika ada perubahan
            if ($request->has('catatan_admin') || $request->has('keterangan')) {
                RiwayatSurat::create([
                    'surat_id' => $surat->id,
                    'user_id' => auth()->id(),
                    'status' => $surat->status,
                    'catatan' => 'Data surat diperbarui oleh petugas',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();

            return redirect()->route('petugas.surat.show', $surat)
                ->with('success', 'Data surat berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Update surat error: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengupdate surat: ' . $e->getMessage());
        }
    }
}