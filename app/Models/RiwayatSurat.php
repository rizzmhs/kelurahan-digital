<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatSurat extends Model
{
    use HasFactory;

    protected $table = 'riwayat_surat';
    
    protected $fillable = [
        'surat_id',
        'status',
        'catatan',
        'user_id'
    ];

    // Relationships
    public function surat()
    {
        return $this->belongsTo(Surat::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}