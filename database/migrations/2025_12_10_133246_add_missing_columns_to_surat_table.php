<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('surat', function (Blueprint $table) {
            // Cek dulu apakah kolom sudah ada sebelum menambah
            
            if (!Schema::hasColumn('surat', 'keterangan')) {
                $table->text('keterangan')->nullable()->after('catatan_admin');
            }
            
            if (!Schema::hasColumn('surat', 'alasan_penolakan')) {
                $table->text('alasan_penolakan')->nullable()->after('keterangan');
            }
            
            // HAPUS atau KOMENTARI kolom yang sudah ada di migration sebelumnya
            // $table->foreignId('verifikator_id')->nullable()->after('petugas_id')...
            // $table->timestamp('tanggal_verifikasi')->nullable()...
            // $table->timestamp('tanggal_proses')->nullable()...
            // $table->timestamp('tanggal_siap')->nullable()...
            // $table->timestamp('tanggal_selesai')->nullable()...
            
            // Cek dan tambahkan hanya yang belum ada
            $columnsToCheck = [
                'tanggal_verifikasi' => 'timestamp',
                'tanggal_proses' => 'timestamp',
                'tanggal_siap' => 'timestamp',
                'tanggal_selesai' => 'timestamp',
            ];
            
            foreach ($columnsToCheck as $columnName => $columnType) {
                if (!Schema::hasColumn('surat', $columnName)) {
                    if ($columnType === 'timestamp') {
                        $table->timestamp($columnName)->nullable();
                    }
                }
            }
            
            // Jika 'diproses_pada' belum ada
            if (!Schema::hasColumn('surat', 'diproses_pada')) {
                $table->timestamp('diproses_pada')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('surat', function (Blueprint $table) {
            // Hanya drop kolom yang kita tambahkan di migration ini
            $columns = ['keterangan', 'alasan_penolakan', 'diproses_pada'];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('surat', $column)) {
                    $table->dropColumn($column);
                }
            }
            
            // Jangan drop foreign key yang sudah ada
            // $table->dropForeign(['verifikator_id']);
        });
    }
};