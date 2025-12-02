<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\KategoriPengaduan;
use App\Models\RiwayatPengaduan;
use App\Models\User;

class Pengaduan extends Model
{
    use HasFactory;

    // TAMBAHKAN BARIS INI - penting!
    protected $table = 'pengaduan';

    protected $fillable = [
        'kode_pengaduan',
        'user_id',
        'kategori_pengaduan_id',
        'judul',
        'deskripsi',
        'lokasi',
        'tanggal_kejadian',
        'foto_bukti',
        'foto_penanganan',
        'status',
        'prioritas',
        'catatan_admin',
        'tindakan',
        'petugas_id',
        'diverifikasi_at',
        'diproses_at',
        'selesai_at'
    ];

    protected $casts = [
        'foto_bukti' => 'array',
        'foto_penanganan' => 'array',
        'tanggal_kejadian' => 'date',
        'diverifikasi_at' => 'datetime',
        'diproses_at' => 'datetime',
        'selesai_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriPengaduan::class, 'kategori_pengaduan_id');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function riwayat()
    {
        return $this->hasMany(RiwayatPengaduan::class);
    }

    // Scope methods
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeUserPengaduan($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Helper methods
    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            'menunggu' => 'bg-yellow-100 text-yellow-800',
            'diverifikasi' => 'bg-blue-100 text-blue-800',
            'diproses' => 'bg-purple-100 text-purple-800',
            'selesai' => 'bg-green-100 text-green-800',
            'ditolak' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getPrioritasBadgeClass(): string
    {
        return match($this->prioritas) {
            'rendah' => 'bg-gray-100 text-gray-800',
            'sedang' => 'bg-blue-100 text-blue-800',
            'tinggi' => 'bg-orange-100 text-orange-800',
            'darurat' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }
}