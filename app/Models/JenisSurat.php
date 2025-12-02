<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSurat extends Model
{
    use HasFactory;

    protected $table = 'jenis_surat';
    
    protected $fillable = [
        'kode',
        'nama',
        'deskripsi',
        'estimasi_hari',
        'biaya',
        'persyaratan',
        'template',
        'is_active'
    ];

    protected $casts = [
        'persyaratan' => 'array',
        'biaya' => 'decimal:2',
    ];

    public function surats()
    {
        return $this->hasMany(Surat::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}