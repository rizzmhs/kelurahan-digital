<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;

    protected $table = 'surat';

    protected $fillable = [
        'nomor_surat',
        'user_id',
        'jenis_surat_id', 
        'data_pengajuan',
        'status',
        'file_surat',
        'keterangan',
        'tanggal_verifikasi',
        'verifikator_id',
        'petugas_id', // ✅ TAMBAHKAN JIKA ADA
        'tanggal_proses', // ✅ TAMBAHKAN JIKA ADA
        'tanggal_siap', // ✅ TAMBAHKAN JIKA ADA  
        'tanggal_selesai', // ✅ TAMBAHKAN JIKA ADA
        'alasan_penolakan', // ✅ TAMBAHKAN JIKA ADA
    ];

    protected $casts = [
        'data_pengajuan' => 'array',
        'tanggal_verifikasi' => 'datetime',
        'tanggal_proses' => 'datetime', // ✅ TAMBAHKAN
        'tanggal_siap' => 'datetime', // ✅ TAMBAHKAN
        'tanggal_selesai' => 'datetime', // ✅ TAMBAHKAN
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class, 'jenis_surat_id');
    }

    public function verifikator()
    {
        return $this->belongsTo(User::class, 'verifikator_id');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    // ✅ TAMBAHKAN RELATIONSHIP RIWAYAT
    public function riwayat()
    {
        return $this->hasMany(RiwayatSurat::class, 'surat_id');
    }

    // Scope methods
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeUserSurat($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // ✅ TAMBAHKAN SCOPE METHODS BARU
    public function scopeDiajukan($query)
    {
        return $query->where('status', 'diajukan');
    }

    public function scopeDiproses($query)
    {
        return $query->where('status', 'diproses');
    }

    public function scopeSiapAmbil($query)
    {
        return $query->where('status', 'siap_ambil');
    }

    public function scopeSelesai($query)
    {
        return $query->where('status', 'selesai');
    }

    public function scopeDitolak($query)
    {
        return $query->where('status', 'ditolak');
    }

    public function scopeTerkaitPetugas($query, $petugasId)
    {
        return $query->where('petugas_id', $petugasId);
    }

    // ✅ TAMBAHKAN HELPER METHODS
    public function getStatusDisplayAttribute()
    {
        $statuses = [
            'diajukan' => 'Diajukan',
            'diproses' => 'Diproses',
            'siap_ambil' => 'Siap Ambil',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak'
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            'diajukan' => 'yellow',
            'diproses' => 'purple', 
            'siap_ambil' => 'green',
            'selesai' => 'gray',
            'ditolak' => 'red'
        ];

        return $colors[$this->status] ?? 'gray';
    }

    public function canBeProcessed()
    {
        return $this->status === 'diajukan';
    }

    public function canGeneratePdf()
    {
        return $this->status === 'diproses' && $this->file_surat === null;
    }

    public function canBeCompleted()
    {
        return $this->status === 'siap_ambil';
    }

    public function isVerified()
    {
        return !is_null($this->tanggal_verifikasi);
    }

    public function hasFile()
    {
        return !is_null($this->file_surat);
    }

    // ✅ TAMBAHKAN METHOD UNTUK GENERATE NOMOR SURAT
    public static function generateNomorSurat($jenisSurat)
    {
        $prefix = 'S';
        $year = date('Y');
        $month = date('m');
        
        $lastSurat = static::where('nomor_surat', 'like', "{$prefix}/{$jenisSurat}/{$year}/{$month}/%")
            ->orderBy('id', 'desc')
            ->first();

        $sequence = 1;
        if ($lastSurat) {
            $lastSequence = (int) substr($lastSurat->nomor_surat, -3);
            $sequence = $lastSequence + 1;
        }

        return "{$prefix}/{$jenisSurat}/{$year}/{$month}/" . str_pad($sequence, 3, '0', STR_PAD_LEFT);
    }

    // ✅ TAMBAHKAN METHOD UNTUK DATA PENGISIAN SURAT
    public function getDataPengisianAttribute()
    {
        return collect($this->data_pengajuan ?? [])->mapWithKeys(function ($value, $key) {
            return [str_replace('_', ' ', $key) => $value];
        });
    }

    // ✅ TAMBAHKAN METHOD UNTUK CEK APAKAH SURAT DAPAT DIPROSES
    public function dapatDiprosesOleh($user)
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isPetugas()) {
            return in_array($this->status, ['diajukan', 'diproses']);
        }

        return false;
    }
}