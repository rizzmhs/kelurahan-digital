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
        'petugas_id', // ✅ TAMBAHKAN INI
        'jenis_surat_id', 
        'data_pengajuan',
        'file_persyaratan', // ✅ TAMBAHKAN INI (dari migration)
        'status',
        'file_surat',
        'catatan_admin', // ✅ GUNAKAN INI dari migration (bukan 'keterangan')
        'custom_template', // ✅ TAMBAHKAN INI (dari migration)
        'tanggal_verifikasi', // ✅ TAMBAHKAN JIKA ADA DI DATABASE
        'verifikator_id', // ✅ TAMBAHKAN JIKA ADA DI DATABASE
        'tanggal_proses', // ✅ TAMBAHKAN JIKA ADA DI DATABASE
        'tanggal_siap', // ✅ TAMBAHKAN JIKA ADA DI DATABASE
        'tanggal_selesai', // ✅ TAMBAHKAN JIKA ADA DI DATABASE
        'alasan_penolakan', // ✅ TAMBAHKAN JIKA ADA DI DATABASE
        // ✅ TAMBAHKAN 'diproses_pada' JIKA DITAMBAHKAN DI MIGRATION
        'diproses_pada',
    ];

    protected $casts = [
        'data_pengajuan' => 'array',
        'file_persyaratan' => 'array', // ✅ CAST SEBAGAI ARRAY
        'tanggal_verifikasi' => 'datetime',
        'tanggal_proses' => 'datetime',
        'tanggal_siap' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'diproses_pada' => 'datetime', // ✅ TAMBAHKAN JIKA ADA
    ];

    protected $appends = [
        'status_display',
        'status_color',
        'data_pengisian',
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

    // ✅ PERBAIKI SCOPE METHODS UNTUK SEMUA STATUS
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

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

    // ✅ TAMBAHKAN SCOPE LAINNYA
    public function scopeBelumDiverifikasi($query)
    {
        return $query->whereNull('tanggal_verifikasi');
    }

    public function scopeSudahDiverifikasi($query)
    {
        return $query->whereNotNull('tanggal_verifikasi');
    }

    // Accessors
    public function getStatusDisplayAttribute()
    {
        $statuses = [
            'draft' => 'Draft',
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
            'draft' => 'gray',
            'diajukan' => 'yellow',
            'diproses' => 'blue',
            'siap_ambil' => 'purple',
            'selesai' => 'green',
            'ditolak' => 'red'
        ];

        return $colors[$this->status] ?? 'gray';
    }

    public function getDataPengisianAttribute()
    {
        return collect($this->data_pengajuan ?? [])->mapWithKeys(function ($value, $key) {
            return [str_replace('_', ' ', $key) => $value];
        });
    }

    // Helper methods
    public function canBeProcessed()
    {
        return $this->status === 'diajukan' || $this->status === 'draft';
    }

    public function canGeneratePdf()
    {
        return in_array($this->status, ['diproses', 'siap_ambil', 'selesai']) && $this->file_surat === null;
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

    public function hasRequirementsFiles()
    {
        return !empty($this->file_persyaratan);
    }

    // ✅ TAMBAHKAN METHOD UNTUK CEK APAKAH SURAT MILIK USER
    public function isOwnedBy($userId)
    {
        return $this->user_id == $userId;
    }

    // Static methods
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

    // ✅ PERBAIKI METHOD UNTUK ROLE CHECKING
    public function dapatDiprosesOleh($user)
    {
        // Asumsi method isAdmin() dan isPetugas() ada di model User
        if ($user->isAdmin() || $user->isVerifikator()) {
            return in_array($this->status, ['draft', 'diajukan']);
        }

        if ($user->isPetugas()) {
            return in_array($this->status, ['diajukan', 'diproses']);
        }

        return false;
    }

    // ✅ TAMBAHKAN METHOD UNTUK UPDATE STATUS
    public function updateStatus($status, $userId = null, $catatan = null)
    {
        $updates = ['status' => $status];
        
        switch ($status) {
            case 'diajukan':
                $updates['tanggal_verifikasi'] = now();
                $updates['verifikator_id'] = $userId ?? auth()->id();
                break;
            case 'diproses':
                $updates['petugas_id'] = $userId ?? auth()->id();
                $updates['tanggal_proses'] = now();
                $updates['diproses_pada'] = now();
                break;
            case 'siap_ambil':
                $updates['tanggal_siap'] = now();
                break;
            case 'selesai':
                $updates['tanggal_selesai'] = now();
                break;
            case 'ditolak':
                $updates['alasan_penolakan'] = $catatan;
                break;
        }

        if ($catatan && $status !== 'ditolak') {
            $updates['catatan_admin'] = $catatan;
        }

        $this->update($updates);

        // Buat riwayat
        $this->riwayat()->create([
            'user_id' => $userId ?? auth()->id(),
            'status' => $status,
            'catatan' => $catatan,
        ]);

        return $this;
    }
}