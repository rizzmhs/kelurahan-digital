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
            $table->string('nomor_surat')->unique()->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('jenis_surat_id')->constrained('jenis_surat');
            $table->json('data_pengajuan'); // Data dari form dynamic
            $table->json('file_persyaratan')->nullable(); // File upload paths
            $table->enum('status', ['draft', 'diajukan', 'diproses', 'siap_ambil', 'selesai', 'ditolak'])->default('draft');
            $table->string('file_surat')->nullable(); // Generated PDF path
            $table->text('catatan_admin')->nullable();
            $table->text('custom_template')->nullable(); // Custom template jika ada
            $table->timestamps();

            // Indexes
            $table->index('status');
            $table->index('nomor_surat');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat');
    }
};