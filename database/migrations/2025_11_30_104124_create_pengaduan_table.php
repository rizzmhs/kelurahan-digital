<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pengaduan')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('kategori_pengaduan_id')->constrained('kategori_pengaduan');
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('lokasi');
            $table->date('tanggal_kejadian');
            $table->json('foto_bukti')->nullable();
            $table->json('foto_penanganan')->nullable();
            $table->enum('status', ['menunggu', 'diverifikasi', 'diproses', 'selesai', 'ditolak'])->default('menunggu');
            $table->enum('prioritas', ['rendah', 'sedang', 'tinggi', 'darurat'])->default('sedang');
            $table->text('catatan_admin')->nullable();
            $table->text('tindakan')->nullable();
            $table->foreignId('petugas_id')->nullable()->constrained('users');
            $table->timestamp('diverifikasi_at')->nullable();
            $table->timestamp('diproses_at')->nullable();
            $table->timestamp('selesai_at')->nullable();
            $table->timestamps();

            // Indexes for better performance
            $table->index('status');
            $table->index('prioritas');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaduan');
    }
};