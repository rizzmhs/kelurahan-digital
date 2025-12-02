<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\Surat;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_warga' => User::warga()->count(),
            'total_petugas' => User::petugas()->count(),
            'total_pengaduan' => Pengaduan::count(),
            'pengaduan_menunggu' => Pengaduan::where('status', 'menunggu')->count(),
            'pengaduan_diproses' => Pengaduan::where('status', 'diproses')->count(),
            'total_surat' => Surat::count(),
            'surat_diproses' => Surat::whereIn('status', ['diajukan', 'diproses'])->count(),
            'surat_siap_ambil' => Surat::where('status', 'siap_ambil')->count(),
        ];

        $recentPengaduan = Pengaduan::with('user')->latest()->limit(5)->get();
        $recentSurat = Surat::with('user')->latest()->limit(5)->get();

        $chartData = $this->getChartData();

        return view('admin.dashboard', compact('stats', 'recentPengaduan', 'recentSurat', 'chartData'));
    }

    public function statistik()
    {
        $pengaduanPerBulan = $this->getPengaduanPerBulan();
        $pengaduanPerKategori = $this->getPengaduanPerKategori();
        $suratPerBulan = $this->getSuratPerBulan();
        $suratPerJenis = $this->getSuratPerJenis();

        return view('admin.statistik', compact(
            'pengaduanPerBulan',
            'pengaduanPerKategori',
            'suratPerBulan',
            'suratPerJenis'
        ));
    }

    public function laporan(Request $request)
    {
        return view('admin.laporan');
    }

    public function generateLaporan(Request $request)
    {
        $validated = $request->validate([
            'jenis_laporan' => 'required|in:pengaduan,surat,users',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'format' => 'required|in:pdf,excel',
        ]);

        // Logic untuk generate laporan
        // ...

        return back()->with('success', 'Laporan berhasil digenerate.');
    }

    private function getChartData()
    {
        return [
            'pengaduan_per_bulan' => $this->getPengaduanPerBulan(),
            'pengaduan_per_kategori' => $this->getPengaduanPerKategori(),
        ];
    }

    private function getPengaduanPerBulan()
    {
        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $count = Pengaduan::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
            
            $data[] = [
                'bulan' => $month->format('M Y'),
                'jumlah' => $count,
            ];
        }

        return $data;
    }

    private function getPengaduanPerKategori()
    {
        return Pengaduan::with('kategori')
            ->selectRaw('kategori_pengaduan_id, COUNT(*) as total')
            ->groupBy('kategori_pengaduan_id')
            ->get()
            ->map(function ($item) {
                return [
                    'kategori' => $item->kategori->nama_kategori,
                    'jumlah' => $item->total,
                ];
            });
    }

    private function getSuratPerBulan()
    {
        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $count = Surat::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
            
            $data[] = [
                'bulan' => $month->format('M Y'),
                'jumlah' => $count,
            ];
        }

        return $data;
    }

    private function getSuratPerJenis()
    {
        return Surat::with('jenisSurat')
            ->selectRaw('jenis_surat_id, COUNT(*) as total')
            ->groupBy('jenis_surat_id')
            ->get()
            ->map(function ($item) {
                return [
                    'jenis' => $item->jenisSurat->nama,
                    'jumlah' => $item->total,
                ];
            });
    }
}