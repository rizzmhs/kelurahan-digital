<?php

namespace Database\Seeders;

use App\Models\KategoriPengaduan;
use Illuminate\Database\Seeder;

class KategoriPengaduanSeeder extends Seeder
{
    public function run(): void
    {
        $kategories = [
            [
                'nama_kategori' => 'Infrastruktur & Jalan',
                'deskripsi' => 'Pengaduan terkait kerusakan jalan, jembatan, drainase, dan infrastruktur publik lainnya',
                'icon' => 'road',
                'is_active' => true,
            ],
            [
                'nama_kategori' => 'Kebersihan & Lingkungan',
                'deskripsi' => 'Pengaduan terkait sampah, sanitasi, pencemaran, dan kebersihan lingkungan',
                'icon' => 'trash',
                'is_active' => true,
            ],
            [
                'nama_kategori' => 'Penerangan Jalan',
                'deskripsi' => 'Pengaduan terkait lampu jalan yang mati atau rusak',
                'icon' => 'lightbulb',
                'is_active' => true,
            ],
            [
                'nama_kategori' => 'Administrasi & Pelayanan',
                'deskripsi' => 'Pengaduan terkait pelayanan administrasi kelurahan',
                'icon' => 'file-text',
                'is_active' => true,
            ],
            [
                'nama_kategori' => 'Keamanan & Ketertiban',
                'deskripsi' => 'Pengaduan terkait gangguan keamanan dan ketertiban masyarakat',
                'icon' => 'shield',
                'is_active' => true,
            ],
            [
                'nama_kategori' => 'Kesehatan',
                'deskripsi' => 'Pengaduan terkait fasilitas kesehatan dan pelayanan kesehatan',
                'icon' => 'heart',
                'is_active' => true,
            ],
            [
                'nama_kategori' => 'Lainnya',
                'deskripsi' => 'Pengaduan lainnya yang tidak termasuk dalam kategori di atas',
                'icon' => 'more-horizontal',
                'is_active' => true,
            ],
        ];

        foreach ($kategories as $kategori) {
            KategoriPengaduan::updateOrCreate(
                ['nama_kategori' => $kategori['nama_kategori']],
                $kategori
            );
        }

        echo "Kategori pengaduan seeded successfully!\n";
    }
}