<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create or Update Admin User
        User::updateOrCreate(
            ['email' => 'admin@kelurahan.dev'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'nik' => '1234567890123456',
                'alamat' => 'Kantor Kelurahan, Jl. Merdeka No. 1',
                'telepon' => '081234567890',
                'tanggal_lahir' => '1980-01-01',
                'jenis_kelamin' => 'L',
                'is_verified' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create or Update Petugas User
        User::updateOrCreate(
            ['email' => 'petugas@kelurahan.dev'],
            [
                'name' => 'Petugas Kelurahan',
                'password' => Hash::make('password123'),
                'role' => 'petugas',
                'nik' => '1234567890123457',
                'alamat' => 'Kantor Kelurahan, Jl. Merdeka No. 1',
                'telepon' => '081234567891',
                'tanggal_lahir' => '1985-05-15',
                'jenis_kelamin' => 'P',
                'is_verified' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create or Update Sample Warga
        User::updateOrCreate(
            ['email' => 'budi@warga.dev'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password123'),
                'role' => 'warga',
                'nik' => '3214567890123456',
                'alamat' => 'Jl. Melati No. 15, RT 01/RW 02',
                'telepon' => '081298765432',
                'tanggal_lahir' => '1990-08-20',
                'jenis_kelamin' => 'L',
                'is_verified' => true,
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'siti@warga.dev'],
            [
                'name' => 'Siti Rahayu',
                'password' => Hash::make('password123'),
                'role' => 'warga',
                'nik' => '3214567890123457',
                'alamat' => 'Jl. Anggrek No. 8, RT 03/RW 01',
                'telepon' => '081287654321',
                'tanggal_lahir' => '1992-12-10',
                'jenis_kelamin' => 'P',
                'is_verified' => true,
                'email_verified_at' => now(),
            ]
        );

        echo "Admin users seeded successfully!\n";
    }
}