<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPengaduan extends Model
{
    use HasFactory;

    protected $table = 'kategori_pengaduan';
    
    protected $fillable = [
        'nama_kategori',
        'deskripsi',
        'icon',
        'is_active'
    ];

    public function pengaduans()
    {
        return $this->hasMany(Pengaduan::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}