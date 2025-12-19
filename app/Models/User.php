<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // ✅ Role constants - konsisten dengan seluruh sistem
    const ROLE_ADMIN = 'admin';
    const ROLE_PETUGAS = 'petugas';
    const ROLE_WARGA = 'warga';
    
    // Status user constants
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_SUSPENDED = 'suspended';

    // Login method constants (untuk tracking cara login)
    const LOGIN_METHOD_GOOGLE = 'google';
    const LOGIN_METHOD_MANUAL = 'manual';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // admin, petugas, warga
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
        'profile_photo_path', // tambahkan ini jika belum ada
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'google_token',
        'google_refresh_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'tanggal_lahir' => 'date',
            'is_verified' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    protected $appends = [
        'role_display',
        'status_display',
        'initials',
        'is_admin',
        'is_petugas',
        'is_warga',
        'profile_completion_percentage',
        'is_profile_complete',
        'login_method',
    ];

    // ==================== RELATIONSHIPS ====================
    
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

    public function suratTugas()
    {
        return $this->hasMany(Surat::class, 'petugas_id');
    }

    // ==================== SCOPES ====================
    
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

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeGoogleUsers($query)
    {
        return $query->whereNotNull('google_id');
    }

    public function scopeManualUsers($query)
    {
        return $query->whereNull('google_id');
    }

    public function scopeWithIncompleteProfile($query)
    {
        return $query->where(function($q) {
            $q->whereNull('nik')
              ->orWhereNull('telepon')
              ->orWhereNull('alamat')
              ->orWhereNull('tanggal_lahir')
              ->orWhereNull('jenis_kelamin');
        })->where('role', self::ROLE_WARGA);
    }

    // ==================== ROLE CHECKING METHODS ====================
    
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

    // ==================== CAPABILITY METHODS ====================
    
    public function dapatMemverifikasi(): bool
    {
        return $this->isAdmin();
    }

    public function dapatMemprosesSurat(): bool
    {
        return $this->isAdmin() || $this->isPetugas();
    }

    public function dapatMemprosesPengaduan(): bool
    {
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

    public function isGoogleUser(): bool
    {
        return !empty($this->google_id);
    }

    // ==================== PROFILE COMPLETION METHODS ====================
    
    /**
     * Check if user profile is complete
     */
    public function isProfileComplete(): bool
    {
        // Jika bukan warga, dianggap lengkap
        if (!$this->isWarga()) {
            return true;
        }

        // Field wajib untuk warga
        $requiredFields = ['nik', 'telepon', 'alamat', 'tanggal_lahir', 'jenis_kelamin'];
        
        foreach ($requiredFields as $field) {
            if (empty($this->{$field})) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get missing profile fields
     */
    public function getMissingProfileFields(): array
    {
        if (!$this->isWarga()) {
            return [];
        }

        $missing = [];
        $fields = [
            'nik' => 'NIK',
            'telepon' => 'Nomor Telepon',
            'alamat' => 'Alamat',
            'tanggal_lahir' => 'Tanggal Lahir',
            'jenis_kelamin' => 'Jenis Kelamin',
            'foto_ktp' => 'Foto KTP'
        ];

        foreach ($fields as $field => $label) {
            if (empty($this->{$field})) {
                $missing[] = $label;
            }
        }

        return $missing;
    }

    /**
     * Calculate profile completion percentage
     */
    public function getProfileCompletionPercentage(): int
    {
        if (!$this->isWarga()) {
            return 100;
        }

        $fields = ['nik', 'telepon', 'alamat', 'tanggal_lahir', 'jenis_kelamin'];
        $filled = 0;
        
        foreach ($fields as $field) {
            if (!empty($this->{$field})) {
                $filled++;
            }
        }

        return $filled === 0 ? 0 : round(($filled / count($fields)) * 100);
    }

    // ==================== HELPER METHODS ====================
    
    public function getRoleNames()
    {
        return collect([$this->role]);
    }

    public function getSuratDapatDiproses()
    {
        if ($this->dapatMemprosesSurat()) {
            return Surat::whereIn('status', ['diajukan', 'diproses'])
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

    public function getSuratDapatDiverifikasi()
    {
        if ($this->dapatMemverifikasi()) {
            return Surat::where('status', 'diajukan')
                ->get();
        }
        
        return collect();
    }
    
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

    // ==================== ATTRIBUTE ACCESSORS ====================
    
    public function getInitialsAttribute(): string
    {
        $names = explode(' ', $this->name);
        $initials = '';
        
        foreach ($names as $name) {
            if (!empty($name)) {
                $initials .= strtoupper(substr($name, 0, 1));
            }
        }
        
        return substr($initials, 0, 2) ?: '??';
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

    public function getProfileCompletionPercentageAttribute(): int
    {
        return $this->getProfileCompletionPercentage();
    }

    public function getIsProfileCompleteAttribute(): bool
    {
        return $this->isProfileComplete();
    }

    public function getLoginMethodAttribute(): string
    {
        return $this->isGoogleUser() ? self::LOGIN_METHOD_GOOGLE : self::LOGIN_METHOD_MANUAL;
    }

    public function getProfilePhotoUrlAttribute(): ?string
    {
        if ($this->profile_photo_path) {
            return asset('storage/' . $this->profile_photo_path);
        }
        
        // Fallback ke Gravatar atau default avatar
        $hash = md5(strtolower(trim($this->email)));
        return "https://www.gravatar.com/avatar/{$hash}?d=mp&s=200";
    }

    public function getKtpUrlAttribute(): ?string
    {
        if ($this->foto_ktp) {
            return asset('storage/' . $this->foto_ktp);
        }
        
        return null;
    }

    // ==================== BUSINESS LOGIC ====================
    
    /**
     * Complete user profile and auto-verify if applicable
     */
    public function completeProfile(): bool
    {
        if ($this->isProfileComplete() && !$this->is_verified && $this->isWarga()) {
            $this->update(['is_verified' => true]);
            return true;
        }
        
        return false;
    }

    /**
     * Mark user as Google user
     */
    public function markAsGoogleUser(string $googleId, string $token, ?string $refreshToken = null): void
    {
        $this->update([
            'google_id' => $googleId,
            'google_token' => $token,
            'google_refresh_token' => $refreshToken,
            'email_verified_at' => $this->email_verified_at ?? now(),
        ]);
    }

    /**
     * Check if user can access specific feature based on profile completion
     */
    public function canAccessFeature(string $feature): bool
    {
        // Jika bukan warga, selalu bisa akses
        if (!$this->isWarga()) {
            return true;
        }

        // Jika profile belum lengkap, hanya bisa akses feature tertentu
        if (!$this->isProfileComplete()) {
            $allowedFeatures = ['dashboard', 'profile.edit', 'profile.update', 'logout'];
            return in_array($feature, $allowedFeatures);
        }

        return true;
    }

    /**
     * Get user's dashboard route based on role
     */
    public function getDashboardRoute(): string
    {
        return match($this->role) {
            self::ROLE_ADMIN => 'admin.dashboard',
            self::ROLE_PETUGAS => 'petugas.dashboard',
            default => 'dashboard',
        };
    }

    /**
     * Format tanggal lahir untuk display
     */
    public function getTanggalLahirFormattedAttribute(): string
    {
        if (!$this->tanggal_lahir) {
            return '-';
        }

        return $this->tanggal_lahir->translatedFormat('d F Y');
    }

    /**
     * Calculate age from tanggal lahir
     */
    public function getAgeAttribute(): ?int
    {
        if (!$this->tanggal_lahir) {
            return null;
        }

        return $this->tanggal_lahir->age;
    }

    /**
     * Check if user is 17+ years old
     */
    public function isAdult(): bool
    {
        if (!$this->tanggal_lahir) {
            return false;
        }

        return $this->tanggal_lahir->age >= 17;
    }
}