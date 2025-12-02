<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('riwayat_pengaduans', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('pengaduan_id'); // Mengacu ke table 'pengaduan' (bukan 'pengaduans')
        $table->unsignedBigInteger('user_id');
        $table->string('status');
        $table->text('catatan')->nullable();
        $table->timestamps();

        // Foreign key ke table 'pengaduan' (singular)
        $table->foreign('pengaduan_id')->references('id')->on('pengaduan')->onDelete('cascade');
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}

    public function down(): void
    {
        Schema::dropIfExists('riwayat_pengaduans');
    }
};