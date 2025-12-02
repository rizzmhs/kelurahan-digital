<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Surat;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $data = [];

        if ($user->isWarga()) {
            $data = $this->getWargaDashboardData($user);
        } elseif ($user->isPetugas()) {
            $data = $this->getPetugasDashboardData($user);
        } elseif ($user->isAdmin()) {
            $data = $this->getAdminDashboardData();
        }

        return view('dashboard', compact('data'));
    }

    private function getWargaDashboardData($user)
    {
        return [
            'total_pengaduan' => Pengaduan::where('user_id', $user->id)->count(),
            'pengaduan_menunggu' => Pengaduan::where('user_id', $user->id)->where('status', 'menunggu')->count(),
            'pengaduan_diproses' => Pengaduan::where('user_id', $user->id)->where('status', 'diproses')->count(),
            'pengaduan_selesai' => Pengaduan::where('user_id', $user->id)->where('status', 'selesai')->count(),
            'total_surat' => Surat::where('user_id', $user->id)->count(),
            'surat_diproses' => Surat::where('user_id', $user->id)->whereIn('status', ['diajukan', 'diproses'])->count(),
            'surat_siap_ambil' => Surat::where('user_id', $user->id)->where('status', 'siap_ambil')->count(),
            'recent_pengaduan' => Pengaduan::where('user_id', $user->id)->latest()->limit(5)->get(),
            'recent_surat' => Surat::where('user_id', $user->id)->latest()->limit(5)->get(),
        ];
    }

    private function getPetugasDashboardData($user)
    {
        return [
            'total_tugas' => Pengaduan::where('petugas_id', $user->id)->count(),
            'tugas_diproses' => Pengaduan::where('petugas_id', $user->id)->where('status', 'diproses')->count(),
            'tugas_selesai' => Pengaduan::where('petugas_id', $user->id)->where('status', 'selesai')->count(),
            'surat_diproses' => Surat::whereIn('status', ['diajukan', 'diproses'])->count(),
            'recent_tugas' => Pengaduan::where('petugas_id', $user->id)->latest()->limit(5)->get(),
            'recent_surat' => Surat::latest()->limit(5)->get(),
        ];
    }

    private function getAdminDashboardData()
    {
        return [
            'total_warga' => User::warga()->count(),
            'total_petugas' => User::petugas()->count(),
            'total_pengaduan' => Pengaduan::count(),
            'pengaduan_menunggu' => Pengaduan::where('status', 'menunggu')->count(),
            'pengaduan_diproses' => Pengaduan::where('status', 'diproses')->count(),
            'total_surat' => Surat::count(),
            'surat_diproses' => Surat::whereIn('status', ['diajukan', 'diproses'])->count(),
            'recent_pengaduan' => Pengaduan::with('user')->latest()->limit(5)->get(),
            'recent_surat' => Surat::with('user')->latest()->limit(5)->get(),
            'chart_data' => $this->getChartData(),
        ];
    }

    private function getChartData()
    {
        // Data untuk chart (contoh sederhana)
        return [
            'pengaduan_per_bulan' => $this->getPengaduanPerBulan(),
            'pengaduan_per_kategori' => $this->getPengaduanPerKategori(),
        ];
    }

    private function getPengaduanPerBulan()
    {
        // Implementasi chart data
        return [];
    }

    private function getPengaduanPerKategori()
    {
        // Implementasi chart data
        return [];
    }
}