<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tambah google_id dulu (jika belum ada)
        if (!Schema::hasColumn('users', 'google_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('google_id')->nullable()->unique()->after('id');
            });
        }
        
        // 2. Tambah/Merubah google_token
        if (!Schema::hasColumn('users', 'google_token')) {
            // Jika belum ada, tambah sebagai TEXT
            Schema::table('users', function (Blueprint $table) {
                $table->text('google_token')->nullable()->after('google_id');
            });
        } else {
            // Jika sudah ada, ubah ke TEXT menggunakan raw SQL
            DB::statement('ALTER TABLE users MODIFY google_token TEXT NULL');
        }
        
        // 3. Tambah/Merubah google_refresh_token
        if (!Schema::hasColumn('users', 'google_refresh_token')) {
            // Jika belum ada, tambah sebagai TEXT
            Schema::table('users', function (Blueprint $table) {
                $table->text('google_refresh_token')->nullable()->after('google_token');
            });
        } else {
            // Jika sudah ada, ubah ke TEXT menggunakan raw SQL
            DB::statement('ALTER TABLE users MODIFY google_refresh_token TEXT NULL');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Untuk rollback, kita hanya perlu mengembalikan tipe data jika sudah diubah
        if (Schema::hasColumn('users', 'google_token')) {
            DB::statement('ALTER TABLE users MODIFY google_token VARCHAR(255) NULL');
        }
        
        if (Schema::hasColumn('users', 'google_refresh_token')) {
            DB::statement('ALTER TABLE users MODIFY google_refresh_token VARCHAR(255) NULL');
        }
        
        // Hapus google_id jika ingin rollback lengkap
        if (Schema::hasColumn('users', 'google_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('google_id');
            });
        }
    }
};