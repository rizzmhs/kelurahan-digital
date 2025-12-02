<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nik',
        'alamat',
        'telepon',
        'tanggal_lahir',
        'jenis_kelamin',
        'foto_ktp',
        'is_verified',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'tanggal_lahir' => 'date',
            'is_verified' => 'boolean',
        ];
    }

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

    // Scope methods
    public function scopeWarga($query)
    {
        return $query->where('role', 'warga');
    }

    public function scopePetugas($query)
    {
        return $query->where('role', 'petugas');
    }

    public function scopeAdmin($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    // Role methods - YANG INI YANG DITAMBAHKAN
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

    // Helper methods
    public function isWarga(): bool
    {
        return $this->role === 'warga';
    }

    public function isPetugas(): bool
    {
        return $this->role === 'petugas';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isVerified(): bool
    {
        return $this->is_verified === true;
    }

    // Permission methods (untuk compatibility)
    public function hasPermissionTo($permission): bool
    {
        // Simple permission check based on role
        $permissions = $this->getPermissions();
        return in_array($permission, $permissions);
    }

    public function getPermissions(): array
    {
        $rolePermissions = [
            'admin' => [
                'manage-users',
                'manage-pengaduan', 
                'manage-surat',
                'manage-master-data',
                'view-reports',
                'export-data'
            ],
            'petugas' => [
                'manage-pengaduan',
                'manage-surat',
                'view-reports'
            ],
            'warga' => [
                'create-pengaduan',
                'create-surat',
                'view-own-data'
            ]
        ];

        return $rolePermissions[$this->role] ?? [];
    }

    public function getAllPermissions()
    {
        return collect($this->getPermissions());
    }

    public function getRoleNames()
    {
        return collect([$this->role]);
    }

    public function getInitialsAttribute(): string
    {
        $names = explode(' ', $this->name);
        $initials = '';
        
        foreach ($names as $name) {
            $initials .= strtoupper(substr($name, 0, 1));
        }
        
        return substr($initials, 0, 2);
    }

    // Attribute accessors
    public function getRoleDisplayAttribute(): string
    {
        $roles = [
            'admin' => 'Administrator',
            'petugas' => 'Petugas',
            'warga' => 'Warga'
        ];

        return $roles[$this->role] ?? $this->role;
    }

    public function getStatusDisplayAttribute(): string
    {
        $statuses = [
            'active' => 'Aktif',
            'inactive' => 'Non-Aktif',
            'suspended' => 'Ditangguhkan'
        ];

        return $statuses[$this->status] ?? $this->status;
    }
}