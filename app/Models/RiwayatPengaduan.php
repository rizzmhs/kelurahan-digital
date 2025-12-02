<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Pengaduan;
use App\Models\User;

class RiwayatPengaduan extends Model
{
    protected $fillable = [
        'pengaduan_id',
        'user_id',
        'status',
        'catatan'
    ];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}