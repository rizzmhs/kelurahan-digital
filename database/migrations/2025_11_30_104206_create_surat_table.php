<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat', function (Blueprint $table) {
            $table->id();
            
            // Informasi dasar
            $table->string('nomor_surat')->unique()->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Kolom relasi ke user lainnya
            // HAPUS ->after() UNTUK MARIADB
            $table->foreignId('petugas_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');
                  
            $table->foreignId('verifikator_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');
                  
            $table->foreignId('jenis_surat_id')->constrained('jenis_surat');
            
            // Data pengajuan
            $table->json('data_pengajuan');
            $table->json('file_persyaratan')->nullable();
            
            // Status dan tracking
            $table->enum('status', ['draft', 'diajukan', 'diproses', 'siap_ambil', 'selesai', 'ditolak'])->default('draft');
            
            // Timestamps untuk setiap status
            $table->timestamp('tanggal_verifikasi')->nullable();
            $table->timestamp('tanggal_proses')->nullable();
            $table->timestamp('tanggal_siap')->nullable();
            $table->timestamp('tanggal_selesai')->nullable();
            $table->timestamp('diproses_pada')->nullable();
            
            // File dan dokumen
            $table->string('file_surat')->nullable();
            
            // Catatan dan keterangan
            $table->text('keterangan')->nullable();
            $table->text('catatan_admin')->nullable();
            $table->text('alasan_penolakan')->nullable();
            $table->text('custom_template')->nullable();
            
            $table->timestamps();

            // Indexes untuk performa query
            $table->index('status');
            $table->index('nomor_surat');
            $table->index('user_id');
            $table->index('petugas_id');
            $table->index('verifikator_id');
            $table->index('jenis_surat_id');
            $table->index('created_at');
            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat');
    }
};