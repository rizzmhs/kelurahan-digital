<?php

namespace Database\Seeders;

use App\Models\Pengaduan;
use App\Models\Surat;
use App\Models\RiwayatSurat;
use Illuminate\Database\Seeder;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create sample pengaduan
        $pengaduanSamples = [
            [
                'judul' => 'Jalan Berlubang di RT 05',
                'deskripsi' => 'Terdapat jalan berlubang yang cukup dalam di depan rumah No. 15 RT 05. Lubang tersebut membahayakan pengendara terutama pada malam hari.',
                'lokasi' => 'Jl. Melati No. 15, RT 05/RW 02',
                'status' => 'selesai',
                'prioritas' => 'tinggi',
            ],
            [
                'judul' => 'Sampah Menumpuk di TPS',
                'deskripsi' => 'Sampah di TPS RW 03 sudah menumpuk dan tidak diangkut selama 3 hari. Menimbulkan bau tidak sedap dan mengundang lalat.',
                'lokasi' => 'TPS RW 03, Jl. Anggrek',
                'status' => 'diproses',
                'prioritas' => 'sedang',
            ],
            [
                'judul' => 'Lampu Jalan Mati',
                'deskripsi' => 'Lampu jalan di depan gang 7 RT 02 mati total sejak 2 hari yang lalu. Gang menjadi gelap dan rawan kejahatan.',
                'lokasi' => 'Gang 7, RT 02/RW 01',
                'status' => 'diverifikasi',
                'prioritas' => 'tinggi',
            ],
            [
                'judul' => 'Saluran Air Tersumbat',
                'deskripsi' => 'Saluran air di depan rumah No. 8 RT 04 tersumbat oleh sampah plastik. Air tidak mengalir dan berpotensi banjir saat hujan.',
                'lokasi' => 'Jl. Mawar No. 8, RT 04/RW 03',
                'status' => 'menunggu',
                'prioritas' => 'sedang',
            ],
        ];

        $users = \App\Models\User::warga()->get();
        $kategories = \App\Models\KategoriPengaduan::all();
        $petugas = \App\Models\User::petugas()->first();

        foreach ($pengaduanSamples as $index => $sample) {
            $pengaduan = Pengaduan::create([
                'kode_pengaduan' => 'P' . date('Ymd') . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'user_id' => $users->random()->id,
                'kategori_pengaduan_id' => $kategories->random()->id,
                'judul' => $sample['judul'],
                'deskripsi' => $sample['deskripsi'],
                'lokasi' => $sample['lokasi'],
                'tanggal_kejadian' => now()->subDays(rand(1, 10)),
                'status' => $sample['status'],
                'prioritas' => $sample['prioritas'],
                'petugas_id' => $sample['status'] !== 'menunggu' ? $petugas->id : null,
                'diverifikasi_at' => $sample['status'] !== 'menunggu' ? now()->subDays(rand(1, 5)) : null,
                'diproses_at' => in_array($sample['status'], ['diproses', 'selesai']) ? now()->subDays(rand(1, 3)) : null,
                'selesai_at' => $sample['status'] === 'selesai' ? now()->subDays(1) : null,
                'tindakan' => $sample['status'] === 'selesai' ? 'Telah dilakukan perbaikan jalan dengan penambalan aspal. Kondisi jalan sudah aman untuk dilalui.' : null,
            ]);
        }

        // Create sample surat
        $jenisSurat = \App\Models\JenisSurat::all();
        $suratSamples = [
            [
                'status' => 'selesai',
                'data' => [
                    'alamat_sekarang' => 'Jl. Melati No. 15, RT 05/RW 02',
                    'alamat_asal' => 'Jl. Kenanga No. 10, Jakarta',
                    'tujuan' => 'Pendaftaran Sekolah',
                ]
            ],
            [
                'status' => 'siap_ambil', 
                'data' => [
                    'tujuan' => 'Beasiswa Pendidikan',
                    'penghasilan' => 'Rp 1.500.000',
                    'jumlah_tanggungan' => '4',
                ]
            ],
            [
                'status' => 'diproses',
                'data' => [
                    'nama_usaha' => 'Toko Sembako Maju Jaya',
                    'alamat_usaha' => 'Jl. Pasar No. 25',
                    'jenis_usaha' => 'Perdagangan Sembako',
                    'tujuan' => 'Perpanjangan Izin Usaha',
                ]
            ],
        ];

        foreach ($suratSamples as $index => $sample) {
            $surat = Surat::create([
                'nomor_surat' => $sample['status'] !== 'draft' ? 'SKD/' . date('Ym') . '/' . str_pad($index + 1, 3, '0', STR_PAD_LEFT) : null,
                'user_id' => $users->random()->id,
                'jenis_surat_id' => $jenisSurat->random()->id,
                'data_pengajuan' => $sample['data'],
                'status' => $sample['status'],
                'file_surat' => $sample['status'] === 'selesai' ? 'surat/result/surat_SKD_202412_001.pdf' : null,
            ]);

            // Create riwayat for surat
            $statusHistory = ['draft', 'diajukan'];
            if (in_array($sample['status'], ['diproses', 'siap_ambil', 'selesai'])) {
                $statusHistory[] = 'diproses';
            }
            if (in_array($sample['status'], ['siap_ambil', 'selesai'])) {
                $statusHistory[] = 'siap_ambil';
            }
            if ($sample['status'] === 'selesai') {
                $statusHistory[] = 'selesai';
            }

            foreach ($statusHistory as $status) {
                RiwayatSurat::create([
                    'surat_id' => $surat->id,
                    'status' => $status,
                    'catatan' => $this->getStatusNote($status),
                    'user_id' => $status === 'draft' ? $surat->user_id : $petugas->id,
                    'created_at' => now()->subDays(count($statusHistory) - array_search($status, $statusHistory)),
                ]);
            }
        }
    }

    private function getStatusNote($status): string
    {
        return match($status) {
            'draft' => 'Surat dibuat sebagai draft',
            'diajukan' => 'Surat diajukan untuk verifikasi',
            'diproses' => 'Surat sedang diproses oleh petugas',
            'siap_ambil' => 'Surat siap diambil/didownload',
            'selesai' => 'Surat telah selesai',
            default => 'Status surat diubah'
        };
    }
}