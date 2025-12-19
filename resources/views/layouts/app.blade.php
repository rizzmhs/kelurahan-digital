<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistem Layanan Kelurahan') }}</title>

    <!-- Fonts & Icons -->
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom Styles for Consistency -->
    <style>
        :root {
            --primary-color: #3b82f6;
            --primary-dark: #2563eb;
            --secondary-color: #8b5cf6;
        }
        
        body {
            font-family: 'Figtree', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
        }
        
        /* ===== NAVIGATION ===== */
        .nav-container {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        }
        
        .nav-item {
            position: relative;
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            margin: 0 0.125rem;
        }
        
        .nav-item:hover {
            background: rgba(255, 255, 255, 0.15);
        }
        
        .nav-item.active {
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        /* ===== DROPDOWN ===== */
        .dropdown-wrapper {
            position: relative;
        }
        
        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%) translateY(-10px);
            min-width: 200px;
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border: 1px solid #e5e7eb;
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 50;
            pointer-events: none;
        }
        
        .dropdown-wrapper:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(5px);
            pointer-events: auto;
        }
        
        .dropdown-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: #374151;
            text-decoration: none;
            transition: all 0.15s ease;
        }
        
        .dropdown-item:hover {
            background: #f9fafb;
            color: var(--primary-color);
        }
        
        .dropdown-item.active {
            background: #eff6ff;
            color: #1d4ed8;
            font-weight: 500;
        }
        
        .dropdown-icon {
            width: 20px;
            margin-right: 0.75rem;
            color: #9ca3af;
        }
        
        .dropdown-item:hover .dropdown-icon {
            color: var(--primary-color);
        }
        
        /* ===== BADGES ===== */
        .badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        .badge-admin {
            background: #ede9fe;
            color: #7c3aed;
        }
        
        .badge-petugas {
            background: #dbeafe;
            color: #1d4ed8;
        }
        
        .badge-warga {
            background: #dcfce7;
            color: #059669;
        }
        
        .badge-draft {
            background: #f3f4f6;
            color: #6b7280;
        }
        
        .badge-diajukan {
            background: #fef3c7;
            color: #d97706;
        }
        
        .badge-diproses {
            background: #dbeafe;
            color: #1d4ed8;
        }
        
        .badge-siap_ambil {
            background: #dcfce7;
            color: #059669;
        }
        
        .badge-selesai {
            background: #dcfce7;
            color: #059669;
        }
        
        .badge-ditolak {
            background: #fee2e2;
            color: #dc2626;
        }
        
        .badge-menunggu {
            background: #fef3c7;
            color: #d97706;
        }
        
        /* ===== CARDS ===== */
        .card {
            background: white;
            border-radius: 0.75rem;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        }
        
        .card-hover:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
            transition: all 0.2s ease;
        }
        
        .card-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .card-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid #e5e7eb;
            background: #f9fafb;
        }
        
        /* ===== STATS CARDS ===== */
        .stats-card {
            background: white;
            border-radius: 0.75rem;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .stats-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .stats-icon {
            padding: 0.75rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .stats-icon-blue {
            background: #eff6ff;
            color: #3b82f6;
        }
        
        .stats-icon-green {
            background: #f0fdf4;
            color: #22c55e;
        }
        
        .stats-icon-purple {
            background: #faf5ff;
            color: #a855f7;
        }
        
        .stats-icon-orange {
            background: #fff7ed;
            color: #f97316;
        }
        
        .stats-icon-yellow {
            background: #fefce8;
            color: #eab308;
        }
        
        /* ===== MOBILE MENU ===== */
        .mobile-menu {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        }
        
        .mobile-menu-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            margin: 0.25rem 0.5rem;
            border-radius: 0.5rem;
            color: white;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        
        .mobile-menu-item:hover {
            background: rgba(255, 255, 255, 0.15);
        }
        
        .mobile-menu-item.active {
            background: rgba(255, 255, 255, 0.2);
        }
        
        /* ===== BUTTONS ===== */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.2s ease;
            gap: 0.5rem;
        }
        
        .btn-primary {
            background: var(--primary-color);
            color: white;
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
        }
        
        .btn-secondary {
            background: #6b7280;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #4b5563;
        }
        
        /* ===== UTILITIES ===== */
        [x-cloak] { 
            display: none !important; 
        }
        
        .page-header {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }
        
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
        }
        
        .empty-state-icon {
            width: 48px;
            height: 48px;
            margin: 0 auto 1rem;
            border-radius: 9999px;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
        }
    </style>
    
    @stack('styles')
</head>
<body class="min-h-screen bg-gray-50 antialiased"
      x-data="{ mobileMenuOpen: false }"
      x-on:keydown.escape.window="mobileMenuOpen = false">

@php
    // Helper sederhana untuk mendapatkan role
    function getUserRole() {
        if (!auth()->check()) {
            return null;
        }
        
        $user = auth()->user();
        $role = strtolower($user->role ?? 'warga');
        
        // Pastikan hanya 3 role yang valid
        if (!in_array($role, ['admin', 'petugas', 'warga'])) {
            $role = 'warga';
        }
        
        return $role;
    }
    
    $userRole = getUserRole();
    $isAdmin = $userRole === 'admin';
    $isPetugas = $userRole === 'petugas';
    $isWarga = $userRole === 'warga';
    
    // Badge class berdasarkan role
    $roleBadgeClass = 'badge-warga';
    $roleDisplayName = 'Warga';
    
    if ($isAdmin) {
        $roleBadgeClass = 'badge-admin';
        $roleDisplayName = 'Admin';
    } elseif ($isPetugas) {
        $roleBadgeClass = 'badge-petugas';
        $roleDisplayName = 'Petugas';
    }
    
    // Route dashboard berdasarkan role
    $dashboardRoute = 'home';
    if (auth()->check()) {
        if ($isAdmin) {
            $dashboardRoute = 'admin.dashboard';
        } elseif ($isPetugas) {
            $dashboardRoute = 'petugas.dashboard';
        } else {
            $dashboardRoute = 'dashboard';
        }
    }
@endphp

    <!-- Navigation -->
    <nav class="nav-container shadow-lg fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route(auth()->check() ? $dashboardRoute : 'home') }}" 
                       class="flex items-center space-x-3">
                        <div class="bg-white/20 p-2 rounded-lg">
                            <i class="fas fa-landmark text-white text-lg"></i>
                        </div>
                        <span class="text-white font-bold text-lg">
                            Kelurahan<span class="text-yellow-300">Digital</span>
                        </span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-2">
                    @auth
                        <!-- Dashboard -->
                        <a href="{{ route($dashboardRoute) }}" 
                           class="nav-item text-white {{ 
                               request()->routeIs('dashboard') || 
                               request()->routeIs('admin.dashboard') || 
                               request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-home mr-2"></i>
                            Dashboard
                        </a>

                        <!-- Menu Warga -->
                        @if($isWarga)
                            <a href="{{ route('warga.pengaduan.index') }}" 
                               class="nav-item text-white {{ request()->routeIs('warga.pengaduan.*') ? 'active' : '' }}">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                Pengaduan
                            </a>
                            
                            <a href="{{ route('warga.surat.index') }}" 
                               class="nav-item text-white {{ request()->routeIs('warga.surat.*') ? 'active' : '' }}">
                                <i class="fas fa-envelope mr-2"></i>
                                Surat Online
                            </a>
                        @endif

                        <!-- Dropdown Kelola untuk Petugas dan Admin -->
                        @if($isPetugas || $isAdmin)
                            <div class="dropdown-wrapper">
                                <button class="nav-item text-white flex items-center">
                                    <i class="fas fa-tasks mr-2"></i>
                                    Kelola
                                    <i class="fas fa-chevron-down ml-1 text-xs"></i>
                                </button>
                                
                                <div class="dropdown-menu">
                                    <!-- Untuk Petugas -->
                                    @if($isPetugas)
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
                                    @endif
                                    
                                    <!-- Untuk Admin -->
                                    @if($isAdmin)
                                        <a href="{{ route('admin.pengaduan.index') }}" 
                                           class="dropdown-item {{ request()->routeIs('admin.pengaduan.*') ? 'active' : '' }}">
                                            <i class="fas fa-exclamation-circle dropdown-icon"></i>
                                            <span>Pengaduan</span>
                                        </a>
                                        
                                        <a href="{{ route('admin.surat.index') }}" 
                                           class="dropdown-item {{ request()->routeIs('admin.surat.*') ? 'active' : '' }}">
                                            <i class="fas fa-file-alt dropdown-icon"></i>
                                            <span>Surat Online</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Dropdown Admin Hanya untuk Admin -->
                        @if($isAdmin)
                            <div class="dropdown-wrapper">
                                <button class="nav-item text-white flex items-center">
                                    <i class="fas fa-cogs mr-2"></i>
                                    Admin
                                    <i class="fas fa-chevron-down ml-1 text-xs"></i>
                                </button>
                                
                                <div class="dropdown-menu min-w-64">
                                    @if(Route::has('admin.users.index'))
                                        <a href="{{ route('admin.users.index') }}" 
                                           class="dropdown-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                            <i class="fas fa-users dropdown-icon"></i>
                                            <span>Pengguna</span>
                                        </a>
                                    @endif
                                    
                                    @if(Route::has('admin.kategori_pengaduan.index'))
                                        <a href="{{ route('admin.kategori_pengaduan.index') }}" 
                                           class="dropdown-item {{ request()->routeIs('admin.kategori_pengaduan.*') ? 'active' : '' }}">
                                            <i class="fas fa-tags dropdown-icon"></i>
                                            <span>Kategori Pengaduan</span>
                                        </a>
                                    @endif
                                    
                                    @if(Route::has('admin.jenis_surat.index'))
                                        <a href="{{ route('admin.jenis_surat.index') }}" 
                                           class="dropdown-item {{ request()->routeIs('admin.jenis_surat.*') ? 'active' : '' }}">
                                            <i class="fas fa-file-contract dropdown-icon"></i>
                                            <span>Jenis Surat</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- User Dropdown -->
                        <div class="dropdown-wrapper ml-2">
                            <button class="nav-item text-white flex items-center">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center mr-2">
                                        <i class="fas fa-user text-white text-sm"></i>
                                    </div>
                                    <span class="max-w-[100px] truncate">{{ Str::limit(Auth::user()->name, 12) }}</span>
                                </div>
                                <i class="fas fa-chevron-down ml-2 text-xs"></i>
                            </button>
                            
                            <div class="dropdown-menu min-w-64">
                                <!-- User Info -->
                                <div class="p-4 border-b border-gray-100">
                                    <p class="font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                                    <p class="text-sm text-gray-600 truncate">{{ Auth::user()->email }}</p>
                                    <p class="text-xs mt-2">
                                        <span class="badge {{ $roleBadgeClass }}">
                                            <i class="fas fa-user-tag mr-1"></i>
                                            {{ $roleDisplayName }}
                                        </span>
                                    </p>
                                </div>
                                
                                <a href="{{ route('profile.edit') }}" 
                                   class="dropdown-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                                    <i class="fas fa-user-circle dropdown-icon"></i>
                                    <span>Profil Saya</span>
                                </a>
                                
                                <div class="border-t border-gray-100 mt-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" 
                                                class="dropdown-item w-full text-left hover:bg-red-50 hover:text-red-600">
                                            <i class="fas fa-sign-out-alt dropdown-icon"></i>
                                            <span>Keluar</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Guest Navigation -->
                        <a href="{{ route('login') }}" 
                           class="nav-item text-white">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Masuk
                        </a>
                        
                        <a href="{{ route('register') }}" 
                           class="bg-white text-blue-600 hover:bg-blue-50 px-4 py-2 rounded-lg font-semibold transition-colors">
                            <i class="fas fa-user-plus mr-2"></i>
                            Daftar
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                            class="nav-item text-white"
                            aria-label="Toggle menu">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path x-show="!mobileMenuOpen" 
                                  stroke-linecap="round" 
                                  stroke-linejoin="round" 
                                  stroke-width="2" 
                                  d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="mobileMenuOpen" 
                                  x-cloak
                                  stroke-linecap="round" 
                                  stroke-linejoin="round" 
                                  stroke-width="2" 
                                  d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" 
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform -translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-2"
             class="mobile-menu md:hidden shadow-lg">
            
            @auth
                <!-- User Info -->
                <div class="p-4 border-b border-white/20">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div>
                            <p class="font-bold text-white">{{ Auth::user()->name }}</p>
                            <p class="text-sm text-blue-100">{{ Auth::user()->email }}</p>
                            <p class="text-xs mt-1">
                                <span class="badge {{ $roleBadgeClass }}">
                                    <i class="fas fa-user-tag mr-1"></i>
                                    {{ $roleDisplayName }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Menu Items -->
                <div class="py-2">
                    <a href="{{ route($dashboardRoute) }}" 
                       class="mobile-menu-item {{ 
                           request()->routeIs('dashboard') || 
                           request()->routeIs('admin.dashboard') || 
                           request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home w-5 mr-3"></i>
                        Dashboard
                    </a>

                    @if($isWarga)
                        <a href="{{ route('warga.pengaduan.index') }}" 
                           class="mobile-menu-item {{ request()->routeIs('warga.pengaduan.*') ? 'active' : '' }}">
                            <i class="fas fa-exclamation-circle w-5 mr-3"></i>
                            Pengaduan
                        </a>
                        
                        <a href="{{ route('warga.surat.index') }}" 
                           class="mobile-menu-item {{ request()->routeIs('warga.surat.*') ? 'active' : '' }}">
                            <i class="fas fa-envelope w-5 mr-3"></i>
                            Surat Online
                        </a>
                    @endif

                    @if($isPetugas || $isAdmin)
                        <div class="mt-2">
                            <div class="px-4 py-2 text-sm font-medium text-blue-200">
                                <i class="fas fa-tasks mr-2"></i>Kelola
                            </div>
                            
                            <!-- Untuk Petugas -->
                            @if($isPetugas)
                                <a href="{{ route('petugas.pengaduan.index') }}" 
                                   class="mobile-menu-item ml-8 {{ request()->routeIs('petugas.pengaduan.*') ? 'active' : '' }}">
                                    <i class="fas fa-exclamation-circle mr-3"></i>
                                    Pengaduan
                                </a>
                                
                                <a href="{{ route('petugas.surat.index') }}" 
                                   class="mobile-menu-item ml-8 {{ request()->routeIs('petugas.surat.*') ? 'active' : '' }}">
                                    <i class="fas fa-file-alt mr-3"></i>
                                    Surat Online
                                </a>
                            @endif
                            
                            <!-- Untuk Admin -->
                            @if($isAdmin)
                                <a href="{{ route('admin.pengaduan.index') }}" 
                                   class="mobile-menu-item ml-8 {{ request()->routeIs('admin.pengaduan.*') ? 'active' : '' }}">
                                    <i class="fas fa-exclamation-circle mr-3"></i>
                                    Pengaduan
                                </a>
                                
                                <a href="{{ route('admin.surat.index') }}" 
                                   class="mobile-menu-item ml-8 {{ request()->routeIs('admin.surat.*') ? 'active' : '' }}">
                                    <i class="fas fa-file-alt mr-3"></i>
                                    Surat Online
                                </a>
                            @endif
                        </div>
                    @endif

                    @if($isAdmin)
                        <div class="mt-2 border-t border-white/20 pt-2">
                            <div class="px-4 py-2 text-sm font-medium text-blue-200">
                                <i class="fas fa-cogs mr-2"></i>Admin
                            </div>
                            
                            @if(Route::has('admin.users.index'))
                                <a href="{{ route('admin.users.index') }}" 
                                   class="mobile-menu-item ml-8 {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                    <i class="fas fa-users mr-3"></i>
                                    Pengguna
                                </a>
                            @endif
                        </div>
                    @endif

                    <div class="border-t border-white/20 mt-2 pt-2">
                        <a href="{{ route('profile.edit') }}" 
                           class="mobile-menu-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                            <i class="fas fa-user-circle w-5 mr-3"></i>
                            Profil
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="mobile-menu-item w-full text-left hover:bg-red-600/20">
                                <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <!-- Guest Mobile Menu -->
                <div class="py-4">
                    <a href="{{ route('login') }}" class="mobile-menu-item">
                        <i class="fas fa-sign-in-alt mr-3"></i>
                        Masuk
                    </a>
                    
                    <a href="{{ route('register') }}" class="mobile-menu-item bg-white/20">
                        <i class="fas fa-user-plus mr-3"></i>
                        Daftar
                    </a>
                </div>
            @endauth
        </div>
    </nav>

    <!-- Main Content -->
    <div class="min-h-screen bg-gray-50 pt-16">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
                <div class="card bg-green-50 border-green-200">
                    <div class="card-body">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-600 mr-3"></i>
                                <span class="text-green-800">{{ session('success') }}</span>
                            </div>
                            <button onclick="this.parentElement.parentElement.parentElement.remove()" 
                                    class="text-green-600 hover:text-green-800">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
                <div class="card bg-red-50 border-red-200">
                    <div class="card-body">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle text-red-600 mr-3"></i>
                                <span class="text-red-800">{{ session('error') }}</span>
                            </div>
                            <button onclick="this.parentElement.parentElement.parentElement.remove()" 
                                    class="text-red-600 hover:text-red-800">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if(session('warning'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
                <div class="card bg-yellow-50 border-yellow-200">
                    <div class="card-body">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle text-yellow-600 mr-3"></i>
                                <span class="text-yellow-800">{{ session('warning') }}</span>
                            </div>
                            <button onclick="this.parentElement.parentElement.parentElement.remove()" 
                                    class="text-yellow-600 hover:text-yellow-800">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Page Header -->
        @if (isset($header))
            <header class="page-header">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="flex-1">
                            <h1 class="text-xl sm:text-2xl font-bold text-gray-900">
                                {{ $header }}
                            </h1>
                            @if (isset($subheader))
                                <p class="text-sm text-gray-600 mt-1">{{ $subheader }}</p>
                            @endif
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
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                {{ $slot }}
            </div>
        </main>
    </div>

    <!-- Footer Sederhana untuk App Layout -->
    <footer class="bg-gray-800 text-white border-t border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="bg-white/10 p-2 rounded-lg">
                            <i class="fas fa-landmark text-white"></i>
                        </div>
                        <span class="font-bold text-lg">
                            Kelurahan<span class="text-yellow-300">Digital</span>
                        </span>
                    </div>
                    <p class="text-gray-300 text-sm">
                        Sistem Layanan Kelurahan Digital untuk mempermudah administrasi warga.
                    </p>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Menu Cepat</h4>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li><a href="{{ route('home') }}" class="hover:text-white">Beranda</a></li>
                        @auth
                            <li><a href="{{ route($dashboardRoute) }}" class="hover:text-white">Dashboard</a></li>
                            <li><a href="{{ route('profile.edit') }}" class="hover:text-white">Profil</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="hover:text-white">Masuk</a></li>
                            <li><a href="{{ route('register') }}" class="hover:text-white">Daftar</a></li>
                        @endauth
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-3 text-gray-400"></i>
                            Wonosobo, Mojotengah
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-3 text-gray-400"></i>
                            (+62) 813-3315-4367
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-3 text-gray-400"></i>
                            larangankulon@gmail.com
                        </li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold mb-4">Jam Layanan</h4>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li class="flex justify-between">
                            <span>Senin - Jumat</span>
                            <span>08:00 - 16:00</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Sabtu</span>
                            <span>08:00 - 12:00</span>
                        </li>
                        <li class="flex justify-between text-red-300">
                            <span>Minggu</span>
                            <span>Tutup</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-sm text-gray-400">
                <p>&copy; {{ date('Y') }} Kelurahan Digital. All rights reserved. v2.0.0</p>
                <p class="mt-1">Developed by Rizz Team</p>
            </div>
        </div>
    </footer>

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    @stack('scripts')

    <script>
        // Auto-hide flash messages
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide flash messages setelah 5 detik
            setTimeout(() => {
                document.querySelectorAll('.bg-green-50, .bg-red-50, .bg-yellow-50, .bg-blue-50').forEach(alert => {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    setTimeout(() => alert.remove(), 300);
                });
            }, 5000);
            
            // Close mobile menu when clicking outside
            document.addEventListener('click', function(event) {
                const nav = document.querySelector('nav');
                const mobileMenu = document.querySelector('.mobile-menu');
                const menuButton = document.querySelector('[aria-label="Toggle menu"]');
                
                if (mobileMenu && menuButton && 
                    !mobileMenu.contains(event.target) && 
                    !menuButton.contains(event.target) &&
                    Alpine.$data(nav).mobileMenuOpen) {
                    Alpine.$data(nav).mobileMenuOpen = false;
                }
            });
            
            // Add fade-in animation for page content
            const mainContent = document.querySelector('main');
            if (mainContent) {
                mainContent.style.opacity = '0';
                mainContent.style.transform = 'translateY(10px)';
                
                setTimeout(() => {
                    mainContent.style.transition = 'all 0.5s ease';
                    mainContent.style.opacity = '1';
                    mainContent.style.transform = 'translateY(0)';
                }, 100);
            }
        });
        
        // Helper function for badges
        function getBadgeClass(status) {
            const badgeClasses = {
                'draft': 'badge-draft',
                'diajukan': 'badge-diajukan',
                'diproses': 'badge-diproses',
                'siap_ambil': 'badge-siap_ambil',
                'selesai': 'badge-selesai',
                'ditolak': 'badge-ditolak',
                'menunggu': 'badge-menunggu',
                'admin': 'badge-admin',
                'petugas': 'badge-petugas',
                'warga': 'badge-warga'
            };
            return badgeClasses[status] || 'badge-draft';
        }
    </script>
</body>
</html>