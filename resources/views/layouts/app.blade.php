<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistem Layanan Kelurahan Terpadu') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Additional Fonts & Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom Styles -->
    <style>
        .font-poppins {
            font-family: 'Poppins', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .gradient-text {
            background: linear-gradient(90deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        .pulse-animation {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .stats-counter {
            font-feature-settings: "tnum";
            font-variant-numeric: tabular-nums;
        }
        
        [x-cloak] { display: none !important; }
        
        /* Smooth transitions */
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 200ms;
        }
        
        /* Glassmorphism effect */
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        /* Navigation Styles - IMPROVED */
        .nav-item {
            position: relative;
            display: inline-flex;
            align-items: center;
            height: 42px;
            padding: 0 16px;
            border-radius: 10px;
            transition: all 0.2s ease;
        }
        
        /* Dropdown improvements */
        .dropdown-container {
            position: relative;
        }
        
        .dropdown-content {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%) translateY(-10px);
            min-width: 200px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 15px 50px rgba(0,0,0,0.15);
            border: 1px solid rgba(229, 231, 235, 0.8);
            opacity: 0;
            visibility: hidden;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 9998 !important;
            pointer-events: none;
        }
        
        .dropdown-container:hover .dropdown-content {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(5px);
            pointer-events: auto;
        }
        
        /* Dropdown item improvements */
        .dropdown-item {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            color: #374151;
            text-decoration: none;
            transition: all 0.15s ease;
            border-left: 3px solid transparent;
        }
        
        .dropdown-item:hover {
            background-color: #f9fafb;
            border-left-color: #3b82f6;
            padding-left: 20px;
        }
        
        .dropdown-item.active {
            background-color: #eff6ff;
            color: #1d4ed8;
            font-weight: 500;
            border-left-color: #1d4ed8;
        }
        
        .dropdown-icon {
            width: 20px;
            text-align: center;
            margin-right: 12px;
            color: #6b7280;
        }
        
        .dropdown-item:hover .dropdown-icon {
            color: #3b82f6;
        }
        
        .dropdown-item.active .dropdown-icon {
            color: #1d4ed8;
        }
        
        /* Badge styles */
        .nav-badge {
            font-size: 0.7rem;
            padding: 2px 6px;
            border-radius: 9999px;
            margin-left: auto;
        }
        
        /* Section headers in dropdown */
        .dropdown-section {
            padding: 10px 16px;
            font-size: 0.75rem;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid #f3f4f6;
        }
        
        /* Active state improvements */
        .nav-link-active {
            background-color: rgba(255, 255, 255, 0.15);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        /* Chevron animation */
        .chevron-rotate {
            transition: transform 0.2s ease;
            margin-left: 6px;
        }
        
        .dropdown-container:hover .chevron-rotate {
            transform: rotate(180deg);
        }
        
        /* Mobile menu improvements */
        .mobile-menu-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            border-radius: 10px;
            margin: 4px 12px;
            transition: all 0.2s ease;
        }
        
        .mobile-menu-item:hover {
            background-color: rgba(255, 255, 255, 0.15);
        }
        
        .mobile-menu-item.active {
            background-color: rgba(255, 255, 255, 0.2);
            font-weight: 500;
        }
        
        /* User dropdown improvements */
        .user-dropdown {
            min-width: 280px;
            max-width: 320px;
        }
        
        /* Main content padding */
        .pt-nav {
            padding-top: 64px;
        }
        
        /* Modal z-index fixes */
        nav {
            z-index: 9999 !important;
        }
        
        .dropdown-content {
            z-index: 9998 !important;
        }
        
        .modal-overlay {
            z-index: 9997 !important;
        }
        
        /* Hover effect for all nav items */
        .nav-hover-effect {
            transition: all 0.2s ease;
        }
        
        .nav-hover-effect:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-1px);
        }
    </style>
    
    <!-- Additional Styles -->
    @stack('styles')
</head>
<body class="font-poppins antialiased" x-data="{
    // Navigation state
    open: false, 
    profileOpen: false,
    
    // Modal state
    modalOpen: false,
    activeModal: null,
    
    // Modal methods
    showModal(modalId) {
        this.activeModal = modalId;
        this.modalOpen = true;
        document.body.style.overflow = 'hidden';
    },
    
    closeModal() {
        this.activeModal = null;
        this.modalOpen = false;
        document.body.style.overflow = 'auto';
    },
    
    isModalOpen(modalId) {
        return this.activeModal === modalId;
    }
}" 
x-on:keydown.escape.window="closeModal()"
x-on:show-modal.window="showModal($event.detail.modalId)"
:class="{ 'overflow-hidden': modalOpen }">

@php
    // Deklarasi variabel global untuk role checking
    function getUserRoleData() {
        if (!auth()->check()) {
            return [
                'isWarga' => false,
                'isPetugas' => false,
                'isAdmin' => false,
                'roleName' => '',
                'roleClass' => 'bg-gray-100 text-gray-800'
            ];
        }
        
        $user = auth()->user();
        $roleName = '';
        
        if (is_object($user->role ?? null)) {
            $roleName = $user->role->name ?? '';
        } elseif (is_string($user->role ?? '')) {
            $roleName = $user->role;
        } elseif (method_exists($user, 'getRoleNames') && $user->getRoleNames()->isNotEmpty()) {
            $roleName = $user->getRoleNames()->first();
        }
        
        // Tentukan tipe user
        $isWarga = false;
        $isPetugas = false;
        $isAdmin = false;
        
        $roleLower = strtolower($roleName);
        $isWarga = in_array($roleLower, ['warga', 'masyarakat', 'user']);
        $isPetugas = in_array($roleLower, ['petugas', 'staff', 'officer']);
        $isAdmin = in_array($roleLower, ['admin', 'administrator', 'superadmin']);
        
        // Tentukan warna badge
        $roleClass = 'bg-gray-100 text-gray-800';
        if ($isAdmin) {
            $roleClass = 'bg-purple-100 text-purple-800';
        } elseif ($isPetugas) {
            $roleClass = 'bg-blue-100 text-blue-800';
        } elseif ($isWarga) {
            $roleClass = 'bg-green-100 text-green-800';
        }
        
        return [
            'isWarga' => $isWarga,
            'isPetugas' => $isPetugas,
            'isAdmin' => $isAdmin,
            'roleName' => $roleName,
            'roleClass' => $roleClass
        ];
    }
    
    // Helper function untuk mendapatkan route dashboard berdasarkan role
    function getDashboardRoute() {
        $user = auth()->user();
        
        if (!$user) {
            return 'home';
        }
        
        $roleData = getUserRoleData();
        
        if ($roleData['isAdmin']) {
            return 'admin.dashboard';
        } elseif ($roleData['isPetugas']) {
            return 'petugas.dashboard';
        }
        
        return 'dashboard';
    }
@endphp

@php
    // Dapatkan data role user
    $roleData = getUserRoleData();
    $isWarga = $roleData['isWarga'];
    $isPetugas = $roleData['isPetugas'];
    $isAdmin = $roleData['isAdmin'];
    $roleName = $roleData['roleName'];
    $roleClass = $roleData['roleClass'];
@endphp

    <!-- Navigation -->
    <nav class="bg-gradient-to-r from-blue-600 to-blue-700 border-b border-blue-500 fixed w-full top-0 shadow-md" style="z-index: 9999;">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route(auth()->check() ? getDashboardRoute() : 'home') }}" class="flex items-center group">
                            @if(file_exists(public_path('storage/logo.png')))
                                <img src="{{ asset('storage/logo.png') }}" alt="Logo" class="block h-9 w-auto group-hover:scale-105 transition-transform">
                            @else
                                <div class="bg-gradient-to-br from-blue-400 to-purple-600 p-2.5 rounded-xl group-hover:scale-105 transition-transform">
                                    <i class="fas fa-landmark text-white text-lg"></i>
                                </div>
                            @endif
                            <span class="ml-3 text-white font-bold text-lg tracking-tight">Kelurahan<span class="text-yellow-300">Digital</span></span>
                        </a>
                    </div>

                    <!-- Navigation Links -->
                    @auth
                    <div class="hidden space-x-1 sm:-my-px sm:ms-8 sm:flex items-center">
                        <!-- Dashboard Button -->
                        <a href="{{ route(getDashboardRoute()) }}" 
                           class="nav-item text-sm font-medium rounded-lg text-white hover:bg-blue-500/30 transition-all duration-200 nav-hover-effect {{ 
                               request()->routeIs('dashboard') || 
                               request()->routeIs('admin.dashboard') || 
                               request()->routeIs('petugas.dashboard') ? 'nav-link-active' : '' }}">
                            <i class="fas fa-tachometer-alt mr-2.5 text-sm"></i>Dashboard
                        </a>
                        
                        @if($isWarga)
                            <!-- Warga Menu Items -->
                            <a href="{{ route('warga.pengaduan.index') }}" 
                               class="nav-item text-sm font-medium rounded-lg text-white hover:bg-blue-500/30 transition-all duration-200 nav-hover-effect {{ request()->routeIs('warga.pengaduan.*') ? 'nav-link-active' : '' }}">
                                <i class="fas fa-comments mr-2.5 text-sm"></i>Pengaduan
                            </a>
                            <a href="{{ route('warga.surat.index') }}" 
                               class="nav-item text-sm font-medium rounded-lg text-white hover:bg-blue-500/30 transition-all duration-200 nav-hover-effect {{ request()->routeIs('warga.surat.*') ? 'nav-link-active' : '' }}">
                                <i class="fas fa-envelope mr-2.5 text-sm"></i>Surat Online
                            </a>
                        @endif
                        
                        @if($isPetugas || $isAdmin)
                            <!-- Kelola Dropdown (Petugas & Admin) -->
                            <div class="dropdown-container">
                                <button class="nav-item text-sm font-medium rounded-lg text-white hover:bg-blue-500/30 transition-all duration-200 nav-hover-effect flex items-center {{ 
                                    request()->routeIs('petugas.pengaduan.*', 'petugas.surat.*', 'pengaduan.*', 'surat.*') ? 'nav-link-active' : '' }}">
                                    <i class="fas fa-cog mr-2.5 text-sm"></i>Kelola
                                    <i class="fas fa-chevron-down ml-1 text-xs chevron-rotate"></i>
                                </button>
                                
                                <div class="dropdown-content">
                                    <div class="dropdown-section">
                                        <i class="fas fa-tasks mr-2"></i>Manajemen
                                    </div>
                                    <a href="{{ route('petugas.pengaduan.index') }}" 
                                       class="dropdown-item {{ request()->routeIs('petugas.pengaduan.*') ? 'active' : '' }}">
                                        <i class="fas fa-exclamation-circle dropdown-icon"></i>
                                        <span>Pengaduan</span>
                                    </a>
                                    <a href="{{ route('petugas.surat.index') }}" 
                                       class="dropdown-item {{ request()->routeIs('petugas.surat.*') ? 'active' : '' }}">
                                        <i class="fas fa-file-alt dropdown-icon"></i>
                                        <span>Surat Online</span>
                                    </a>
                                    
                                    @if($isAdmin)
                                    <div class="dropdown-section">
                                        <i class="fas fa-eye mr-2"></i>Administrasi
                                    </div>
                                    <a href="{{ route('admin.pengaduan.index') }}" 
                                       class="dropdown-item {{ request()->routeIs('admin.pengaduan.*') ? 'active' : '' }}">
                                        <i class="fas fa-list-alt dropdown-icon"></i>
                                        <span>Semua Pengaduan</span>
                                    </a>
                                    @endif
                                </div>
                            </div>
                        @endif
                        
                        @if($isAdmin)
                            <!-- Admin Dropdown -->
                            <div class="dropdown-container">
                                <button class="nav-item text-sm font-medium rounded-lg text-white hover:bg-blue-500/30 transition-all duration-200 nav-hover-effect flex items-center {{ request()->routeIs('admin.users.*', 'admin.kategori_pengaduan.*', 'admin.jenis_surat.*') ? 'nav-link-active' : '' }}">
                                    <i class="fas fa-database mr-2.5 text-sm"></i>Admin
                                    <i class="fas fa-chevron-down ml-1 text-xs chevron-rotate"></i>
                                </button>
                                
                                <div class="dropdown-content user-dropdown">
                                    <!-- Header -->
                                    <div class="px-4 py-3 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-purple-50 rounded-t-xl">
                                        <p class="text-xs font-semibold text-blue-700 uppercase tracking-wider flex items-center">
                                            <i class="fas fa-cogs mr-2"></i>Sistem Administrasi
                                        </p>
                                    </div>
                                    
                                    <!-- User Management -->
                                    @if(Route::has('admin.users.index'))
                                    <div class="dropdown-section">
                                        <i class="fas fa-users mr-2"></i>Pengguna
                                    </div>
                                    <a href="{{ route('admin.users.index') }}" 
                                       class="dropdown-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                        <i class="fas fa-user-friends dropdown-icon"></i>
                                        <span class="flex-1">Kelola Pengguna</span>
                                        @php
                                            $userCount = 0;
                                            try {
                                                $userCount = \App\Models\User::count();
                                            } catch(Exception $e) {}
                                        @endphp
                                        @if($userCount > 0)
                                        <span class="nav-badge bg-blue-100 text-blue-700">
                                            {{ $userCount }}
                                        </span>
                                        @endif
                                    </a>
                                    @endif
                                    
                                    <!-- Master Data -->
                                    <div class="dropdown-section">
                                        <i class="fas fa-layer-group mr-2"></i>Data Master
                                    </div>
                                    
                                    @if(Route::has('admin.kategori_pengaduan.index'))
                                    <a href="{{ route('admin.kategori_pengaduan.index') }}" 
                                       class="dropdown-item {{ request()->routeIs('admin.kategori_pengaduan.*') ? 'active' : '' }}">
                                        <i class="fas fa-tags dropdown-icon"></i>
                                        <span class="flex-1">Kategori Pengaduan</span>
                                        @php
                                            $kategoriCount = 0;
                                            try {
                                                $kategoriCount = \App\Models\KategoriPengaduan::count();
                                            } catch(Exception $e) {}
                                        @endphp
                                        @if($kategoriCount > 0)
                                        <span class="nav-badge bg-green-100 text-green-700">
                                            {{ $kategoriCount }}
                                        </span>
                                        @endif
                                    </a>
                                    @endif
                                    
                                    @if(Route::has('admin.jenis_surat.index'))
                                    <a href="{{ route('admin.jenis_surat.index') }}" 
                                       class="dropdown-item {{ request()->routeIs('admin.jenis_surat.*') ? 'active' : '' }}">
                                        <i class="fas fa-file-contract dropdown-icon"></i>
                                        <span class="flex-1">Jenis Surat</span>
                                        @php
                                            $jenisSuratCount = 0;
                                            try {
                                                $jenisSuratCount = \App\Models\JenisSurat::count();
                                            } catch(Exception $e) {}
                                        @endphp
                                        @if($jenisSuratCount > 0)
                                        <span class="nav-badge bg-orange-100 text-orange-700">
                                            {{ $jenisSuratCount }}
                                        </span>
                                        @endif
                                    </a>
                                    @endif
                                    
                                    <!-- System -->
                                    <div class="dropdown-section">
                                        <i class="fas fa-chart-line mr-2"></i>Sistem
                                    </div>
                                    
                                    @if(Route::has('admin.reports.index'))
                                    <a href="{{ route('admin.reports.index') }}" 
                                       class="dropdown-item">
                                        <i class="fas fa-chart-bar dropdown-icon"></i>
                                        <span>Laporan & Statistik</span>
                                    </a>
                                    @endif
                                    
                                    @if(Route::has('admin.settings.index'))
                                    <a href="{{ route('admin.settings.index') }}" 
                                       class="dropdown-item">
                                        <i class="fas fa-sliders-h dropdown-icon"></i>
                                        <span>Pengaturan</span>
                                    </a>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                    @endauth
                </div>

                <!-- Settings Dropdown -->
                @auth
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <div class="dropdown-container">
                        <button class="nav-item text-white hover:bg-blue-500/30 transition-all duration-200 nav-hover-effect flex items-center">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center mr-2.5 shadow-sm">
                                    <i class="fas fa-user text-white text-xs"></i>
                                </div>
                                <span class="truncate max-w-[120px]">{{ Str::limit(Auth::user()->name, 15) }}</span>
                            </div>
                            <i class="fas fa-chevron-down ml-2 text-xs chevron-rotate"></i>
                        </button>
                        
                        <div class="dropdown-content user-dropdown">
                            <!-- User Info -->
                            <div class="px-4 py-3 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-purple-50">
                                <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate mt-1">{{ Auth::user()->email }}</p>
                                <p class="text-xs mt-2">
                                    <span class="px-2 py-1 rounded-full {{ $roleClass }}">
                                        <i class="fas fa-user-tag mr-1"></i>{{ ucfirst($roleName) ?: 'User' }}
                                    </span>
                                </p>
                            </div>
                            
                            <!-- Menu Items -->
                            <a href="{{ route('profile.edit') }}" 
                               class="dropdown-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                                <i class="fas fa-user-circle dropdown-icon"></i>
                                <span>Profil Saya</span>
                            </a>
                            
                            @if(Route::has('notifications.index'))
                            <a href="{{ route('notifications.index') }}" 
                               class="dropdown-item">
                                <i class="fas fa-bell dropdown-icon"></i>
                                <span class="flex-1">Notifikasi</span>
                                @php
                                    $notificationCount = 0;
                                    try {
                                        if (method_exists(auth()->user(), 'unreadNotifications')) {
                                            $notificationCount = auth()->user()->unreadNotifications()->count();
                                        }
                                    } catch(Exception $e) {}
                                @endphp
                                @if($notificationCount > 0)
                                <span class="nav-badge bg-yellow-100 text-yellow-700">
                                    {{ $notificationCount }}
                                </span>
                                @endif
                            </a>
                            @endif
                            
                            <!-- Logout -->
                            <div class="border-t border-gray-100 mt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item w-full text-left hover:bg-red-50 hover:text-red-600">
                                        <i class="fas fa-sign-out-alt dropdown-icon"></i>
                                        <span>Keluar</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-3">
                    <a href="{{ route('login') }}" class="nav-item text-white hover:bg-blue-500/30 transition-all duration-200 font-medium rounded-lg nav-hover-effect">
                        <i class="fas fa-sign-in-alt mr-2.5"></i>Masuk
                    </a>
                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-blue-500 to-purple-600 text-white hover:shadow-lg px-5 py-2.5 rounded-lg font-semibold transition-all duration-200 hover:scale-105 shadow-md nav-hover-effect">
                        <i class="fas fa-user-plus mr-2.5"></i>Daftar
                    </a>
                </div>
                @endauth

                <!-- Hamburger Menu for Mobile -->
                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="nav-item text-white hover:bg-blue-500/30 transition-all duration-200">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div x-show="open" x-cloak class="sm:hidden bg-gradient-to-r from-blue-600 to-blue-700 border-t border-blue-500">
            @auth
            @php
                $mobileRoleData = getUserRoleData();
                $mobileIsWarga = $mobileRoleData['isWarga'];
                $mobileIsPetugas = $mobileRoleData['isPetugas'];
                $mobileIsAdmin = $mobileRoleData['isAdmin'];
                $mobileRoleClass = $mobileRoleData['roleClass'];
                $mobileRoleName = $mobileRoleData['roleName'];
            @endphp
            
            <div class="pt-2 pb-3 space-y-1">
                <!-- Dashboard -->
                <a href="{{ route(getDashboardRoute()) }}" 
                   class="mobile-menu-item text-white {{ 
                       request()->routeIs('dashboard') || 
                       request()->routeIs('admin.dashboard') || 
                       request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt mr-3 w-5"></i>Dashboard
                </a>
                
                @if($mobileIsWarga)
                    <!-- Warga Menu Items -->
                    <a href="{{ route('warga.pengaduan.index') }}" 
                       class="mobile-menu-item text-white {{ request()->routeIs('warga.pengaduan.*') ? 'active' : '' }}">
                        <i class="fas fa-comments mr-3 w-5"></i>Pengaduan
                    </a>
                    <a href="{{ route('warga.surat.index') }}" 
                       class="mobile-menu-item text-white {{ request()->routeIs('warga.surat.*') ? 'active' : '' }}">
                        <i class="fas fa-envelope mr-3 w-5"></i>Surat Online
                    </a>
                @endif
                
                @if($mobileIsPetugas || $mobileIsAdmin)
                    <!-- Kelola Section -->
                    <div class="border-t border-blue-500/50 pt-2 mx-4">
                        <div class="px-4 py-2 text-sm font-medium text-blue-200">
                            <i class="fas fa-cog mr-3"></i>Kelola
                        </div>
                        <a href="{{ route('petugas.pengaduan.index') }}" 
                           class="mobile-menu-item text-white ml-8 {{ request()->routeIs('petugas.pengaduan.*') ? 'active' : '' }}">
                            <i class="fas fa-tasks mr-3"></i>Pengaduan
                        </a>
                        <a href="{{ route('petugas.surat.index') }}" 
                           class="mobile-menu-item text-white ml-8 {{ request()->routeIs('petugas.surat.*') ? 'active' : '' }}">
                            <i class="fas fa-file-alt mr-3"></i>Surat Online
                        </a>
                    </div>
                @endif
                
                @if($mobileIsAdmin)
                    <!-- Admin Section -->
                    <div class="border-t border-blue-500/50 pt-2 mx-4">
                        <div class="px-4 py-2 text-sm font-medium text-blue-200">
                            <i class="fas fa-database mr-3"></i>Admin
                        </div>
                        @if(Route::has('admin.users.index'))
                        <a href="{{ route('admin.users.index') }}" 
                           class="mobile-menu-item text-white ml-8 {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="fas fa-users mr-3"></i>Kelola Pengguna
                        </a>
                        @endif
                        
                        @if(Route::has('admin.kategori_pengaduan.index'))
                        <a href="{{ route('admin.kategori_pengaduan.index') }}" 
                           class="mobile-menu-item text-white ml-8 {{ request()->routeIs('admin.kategori_pengaduan.*') ? 'active' : '' }}">
                            <i class="fas fa-tags mr-3"></i>Kategori Pengaduan
                        </a>
                        @endif
                        
                        @if(Route::has('admin.jenis_surat.index'))
                        <a href="{{ route('admin.jenis_surat.index') }}" 
                           class="mobile-menu-item text-white ml-8 {{ request()->routeIs('admin.jenis_surat.*') ? 'active' : '' }}">
                            <i class="fas fa-file-signature mr-3"></i>Jenis Surat
                        </a>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-blue-500/50">
                <div class="px-4 py-3">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center mr-3">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div>
                            <div class="font-bold text-base text-white">{{ Auth::user()->name }}</div>
                            <div class="font-medium text-sm text-blue-200">{{ Auth::user()->email }}</div>
                            <div class="text-xs mt-1">
                                <span class="px-2 py-0.5 rounded-full {{ $mobileRoleClass }}">
                                    {{ ucfirst($mobileRoleName) ?: 'User' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <a href="{{ route('profile.edit') }}" 
                       class="mobile-menu-item text-white {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                        <i class="fas fa-user mr-3 w-5"></i>Profil
                    </a>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="mobile-menu-item w-full text-left text-white hover:bg-red-600/20">
                            <i class="fas fa-sign-out-alt mr-3 w-5"></i>Keluar
                        </button>
                    </form>
                </div>
            </div>
            @else
            <div class="pt-2 pb-3 space-y-1">
                <a href="{{ route('login') }}" class="mobile-menu-item text-white">
                    <i class="fas fa-sign-in-alt mr-3"></i>Masuk
                </a>
                <a href="{{ route('register') }}" class="mobile-menu-item text-white bg-blue-500/30">
                    <i class="fas fa-user-plus mr-3"></i>Daftar
                </a>
            </div>
            @endauth
        </div>
    </nav>

    <!-- Rest of the layout remains the same -->
    <div class="min-h-screen bg-gray-100 pt-16">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert-auto-hide max-w-7xl mx-auto py-2 px-4 sm:px-6 lg:px-8">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <strong class="font-bold">Sukses!</strong>
                        <span class="block sm:inline ml-2">{{ session('success') }}</span>
                    </div>
                    <button class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="alert-auto-hide max-w-7xl mx-auto py-2 px-4 sm:px-6 lg:px-8">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <strong class="font-bold">Error!</strong>
                        <span class="block sm:inline ml-2">{{ session('error') }}</span>
                    </div>
                    <button class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        @endif

        @if(session('warning'))
            <div class="alert-auto-hide max-w-7xl mx-auto py-2 px-4 sm:px-6 lg:px-8">
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded-lg relative" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong class="font-bold">Peringatan!</strong>
                        <span class="block sm:inline ml-2">{{ session('warning') }}</span>
                    </div>
                    <button class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        @endif

        @if(session('info'))
            <div class="alert-auto-hide max-w-7xl mx-auto py-2 px-4 sm:px-6 lg:px-8">
                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded-lg relative" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-info-circle mr-2"></i>
                        <strong class="font-bold">Info!</strong>
                        <span class="block sm:inline ml-2">{{ session('info') }}</span>
                    </div>
                    <button class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        @endif

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow-sm">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            {{ $header }}
                        </div>
                        @if (isset($action))
                            <div class="flex-shrink-0">
                                {{ $action }}
                            </div>
                        @endif
                    </div>
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main class="flex-1">
            {{ $slot }}
        </main>
    </div>

    <!-- Footer -->
    @include('layouts.footer')

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <!-- Custom Scripts -->
    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto hide success/error messages after 5 seconds
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert-auto-hide');
                alerts.forEach(alert => {
                    alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    setTimeout(() => alert.remove(), 500);
                });
            }, 5000);
            
            // Improved dropdown behavior
            const dropdowns = document.querySelectorAll('.dropdown-container');
            
            dropdowns.forEach(dropdown => {
                dropdown.addEventListener('mouseenter', function() {
                    const content = this.querySelector('.dropdown-content');
                    if (content) {
                        content.style.opacity = '1';
                        content.style.visibility = 'visible';
                        content.style.transform = 'translateX(-50%) translateY(5px)';
                    }
                });
                
                dropdown.addEventListener('mouseleave', function() {
                    const content = this.querySelector('.dropdown-content');
                    if (content) {
                        content.style.opacity = '0';
                        content.style.visibility = 'hidden';
                        content.style.transform = 'translateX(-50%) translateY(-10px)';
                    }
                });
            });
            
            // Close mobile menu when clicking outside
            document.addEventListener('click', function(event) {
                const nav = document.querySelector('nav');
                const mobileMenu = nav.querySelector('[x-show="open"]');
                const hamburger = nav.querySelector('[x-on\\:click*="open"]');
                
                if (window.innerWidth < 640 && mobileMenu && hamburger) {
                    const isClickInsideNav = nav.contains(event.target);
                    
                    if (!isClickInsideNav && Alpine.$data(nav).open) {
                        Alpine.$data(nav).open = false;
                    }
                }
            });
        });
    </script>
</body>
</html>