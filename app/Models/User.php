<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // ✅ Sesuaikan dengan role yang ada di sistem: admin, petugas, warga
    const ROLE_ADMIN = 'admin';
    const ROLE_PETUGAS = 'petugas';
    const ROLE_WARGA = 'warga';
    
    // Status user
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_SUSPENDED = 'suspended';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // ✅ Pastikan role ini hanya berisi: admin, petugas, warga
        'nik',
        'alamat',
        'telepon',
        'tanggal_lahir',
        'jenis_kelamin',
        'foto_ktp',
        'is_verified',
        'status',
        'google_id',
        'google_token',
        'google_refresh_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'tanggal_lahir' => 'date',
            'is_verified' => 'boolean',
        ];
    }

    protected $appends = [
        'role_display',
        'status_display',
        'initials',
        'is_admin',
        'is_petugas',
        'is_warga',
    ];

    // Relationships
    public function pengaduans()
    {
        return $this->hasMany(Pengaduan::class);
    }

    public function surats()
    {
        return $this->hasMany(Surat::class);
    }

    public function tugasPengaduan()
    {
        return $this->hasMany(Pengaduan::class, 'petugas_id');
    }

    public function riwayatSurat()
    {
        return $this->hasMany(RiwayatSurat::class);
    }

    // Untuk surat yang ditugaskan ke petugas
    public function suratTugas()
    {
        return $this->hasMany(Surat::class, 'petugas_id');
    }

    // ❌ HAPUS suratVerifikasi karena tidak ada role verifikator
    // public function suratVerifikasi()
    // {
    //     return $this->hasMany(Surat::class, 'verifikator_id');
    // }

    // Scope methods
    public function scopeWarga($query)
    {
        return $query->where('role', self::ROLE_WARGA);
    }

    public function scopePetugas($query)
    {
        return $query->where('role', self::ROLE_PETUGAS);
    }

    public function scopeAdmin($query)
    {
        return $query->where('role', self::ROLE_ADMIN);
    }

    // ❌ HAPUS scopeVerifikator karena tidak ada role verifikator
    // public function scopeVerifikator($query)
    // {
    //     return $query->where('role', 'verifikator');
    // }

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    // Role checking methods - SIMPLIFIED
    public function hasRole($role): bool
    {
        if (is_array($role)) {
            return in_array($this->role, $role);
        }
        
        return $this->role === $role;
    }

    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->role, $roles);
    }

    // Helper methods - Lebih sederhana
    public function isWarga(): bool
    {
        return $this->role === self::ROLE_WARGA;
    }

    public function isPetugas(): bool
    {
        return $this->role === self::ROLE_PETUGAS;
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    // ❌ HAPUS karena tidak ada role verifikator
    // public function isVerifikator(): bool
    // {
    //     return $this->role === 'verifikator';
    // }

    // Method untuk memeriksa kemampuan user
    public function dapatMemverifikasi(): bool
    {
        // Hanya admin yang bisa memverifikasi
        return $this->isAdmin();
    }

    public function dapatMemprosesSurat(): bool
    {
        // Admin dan petugas bisa memproses surat
        return $this->isAdmin() || $this->isPetugas();
    }

    public function dapatMemprosesPengaduan(): bool
    {
        // Admin dan petugas bisa memproses pengaduan
        return $this->isAdmin() || $this->isPetugas();
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isVerified(): bool
    {
        return $this->is_verified === true;
    }

    // ❌ OPSIONAL: HAPUS permission system jika tidak diperlukan
    // Karena Anda pakai role middleware sederhana
    /*
    public function hasPermissionTo($permission): bool
    {
        // Jika ingin tetap pakai permission, sesuaikan dengan role yang ada
        $permissions = $this->getPermissions();
        return in_array($permission, $permissions);
    }

    public function getPermissions(): array
    {
        // Sesuaikan dengan role yang ada
        $rolePermissions = [
            self::ROLE_ADMIN => [
                'manage-users',
                'manage-pengaduan', 
                'manage-surat',
                'manage-master-data',
                'view-reports',
                'export-data',
                'verify-surat',
                'assign-petugas',
                'process-surat',
                'generate-pdf'
            ],
            self::ROLE_PETUGAS => [
                'manage-pengaduan',
                'manage-surat',
                'process-surat',
                'generate-pdf',
                'view-reports'
            ],
            self::ROLE_WARGA => [
                'create-pengaduan',
                'create-surat',
                'view-own-data',
                'track-status'
            ]
        ];

        return $rolePermissions[$this->role] ?? [];
    }

    public function getAllPermissions()
    {
        return collect($this->getPermissions());
    }
    */

    public function getRoleNames()
    {
        return collect([$this->role]);
    }

    // Attribute accessors
    public function getInitialsAttribute(): string
    {
        $names = explode(' ', $this->name);
        $initials = '';
        
        foreach ($names as $name) {
            $initials .= strtoupper(substr($name, 0, 1));
        }
        
        return substr($initials, 0, 2);
    }

    public function getRoleDisplayAttribute(): string
    {
        $roles = [
            self::ROLE_ADMIN => 'Administrator',
            self::ROLE_PETUGAS => 'Petugas',
            self::ROLE_WARGA => 'Warga'
        ];

        return $roles[$this->role] ?? ucfirst($this->role);
    }

    public function getStatusDisplayAttribute(): string
    {
        $statuses = [
            self::STATUS_ACTIVE => 'Aktif',
            self::STATUS_INACTIVE => 'Non-Aktif',
            self::STATUS_SUSPENDED => 'Ditangguhkan'
        ];

        return $statuses[$this->status] ?? ucfirst($this->status);
    }

    // Helper attributes untuk template Blade
    public function getIsAdminAttribute(): bool
    {
        return $this->isAdmin();
    }

    public function getIsPetugasAttribute(): bool
    {
        return $this->isPetugas();
    }

    public function getIsWargaAttribute(): bool
    {
        return $this->isWarga();
    }

    // Method untuk mendapatkan tugas
    public function getSuratDapatDiproses()
    {
        if ($this->dapatMemprosesSurat()) {
            return Surat::whereIn('status', ['diajukan', 'diproses'])
                ->when($this->isPetugas(), function ($query) {
                    // Petugas hanya melihat yang ditugaskan ke mereka atau belum ada petugas
                    return $query->where(function($q) {
                        $q->where('petugas_id', $this->id)
                          ->orWhereNull('petugas_id');
                    });
                })
                ->get();
        }
        
        return collect();
    }

    public function getSuratDapatDiverifikasi()
    {
        if ($this->dapatMemverifikasi()) {
            return Surat::where('status', 'diajukan')
                ->get();
        }
        
        return collect();
    }
    
    // Method untuk mendapatkan pengaduan yang dapat diproses
    public function getPengaduanDapatDiproses()
    {
        if ($this->dapatMemprosesPengaduan()) {
            return Pengaduan::whereIn('status', ['diterima', 'diproses'])
                ->when($this->isPetugas(), function ($query) {
                    return $query->where(function($q) {
                        $q->where('petugas_id', $this->id)
                          ->orWhereNull('petugas_id');
                    });
                })
                ->get();
        }
        
        return collect();
    }
}