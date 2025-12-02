<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_surat', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 10)->unique();
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->integer('estimasi_hari')->default(3);
            $table->decimal('biaya', 10, 2)->default(0);
            $table->json('persyaratan'); // JSON field untuk dynamic form
            $table->string('template')->default('default');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('is_active');
            $table->index('kode');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_surat');
    }
};