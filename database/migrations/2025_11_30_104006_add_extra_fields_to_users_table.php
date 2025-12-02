<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['warga', 'petugas', 'admin'])->default('warga');
            $table->string('nik', 16)->unique()->nullable();
            $table->text('alamat')->nullable();
            $table->string('telepon', 15)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('foto_ktp')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->string('status')->default('active');
            $table->timestamp('email_verified_at')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role', 'nik', 'alamat', 'telepon', 
                'tanggal_lahir', 'jenis_kelamin', 'foto_ktp', 
                'is_verified', 'status'
            ]);
        });
    }
};