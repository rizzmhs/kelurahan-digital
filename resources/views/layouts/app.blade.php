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
        
        /* Dropdown Hover Effects */
        .dropdown-container {
            position: relative;
        }
        
        .dropdown-content {
            visibility: hidden;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.2s ease-out;
        }
        
        .dropdown-container:hover .dropdown-content,
        .dropdown-container:focus-within .dropdown-content {
            visibility: visible;
            opacity: 1;
            transform: translateY(0);
        }
        
        .dropdown-content a {
            transform: translateX(-5px);
            transition: transform 0.2s ease;
        }
        
        .dropdown-content a:hover {
            transform: translateX(0);
        }
        
        /* Active State Highlight */
        .nav-link-active {
            background-color: rgba(255, 255, 255, 0.2);
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        /* Chevron Animation */
        .chevron-rotate {
            transition: transform 0.2s ease;
        }
        
        .dropdown-container:hover .chevron-rotate {
            transform: rotate(180deg);
        }
    </style>
    
    <!-- Additional Styles -->
    @stack('styles')
</head>
<body class="font-poppins antialiased" x-data="{ open: false, profileOpen: false }">
    <!-- Navigation -->
    <nav class="bg-blue-600 border-b border-blue-500 fixed w-full top-0 z-50 shadow-md">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route(auth()->check() ? 'dashboard' : 'home') }}" class="flex items-center group">
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
                    <div class="hidden space-x-1 sm:-my-px sm:ms-8 sm:flex">
                        <!-- Dashboard Button -->
                        <a href="{{ route('dashboard') }}" 
                           class="inline-flex items-center px-4 py-2.5 text-sm font-medium rounded-lg text-white hover:bg-blue-700/80 transition-all duration-200 ease-in-out {{ request()->routeIs('dashboard') ? 'nav-link-active' : '' }}">
                            <i class="fas fa-tachometer-alt mr-2.5 text-sm"></i>Dashboard
                        </a>
                        
                        @php
                            // Helper function untuk cek role user
                            $user = auth()->user();
                            $roleName = '';
                            
                            // Mendapatkan nama role dengan berbagai cara
                            if (is_object($user->role)) {
                                $roleName = $user->role->name ?? '';
                            } elseif (is_string($user->role)) {
                                $roleName = $user->role;
                            } elseif (method_exists($user, 'getRoleNames') && $user->getRoleNames()->isNotEmpty()) {
                                $roleName = $user->getRoleNames()->first();
                            } elseif (property_exists($user, 'role_id')) {
                                // Jika menggunakan role_id, coba ambil dari database
                                if (class_exists('App\Models\Role')) {
                                    try {
                                        $role = \App\Models\Role::find($user->role_id);
                                        $roleName = $role->name ?? 'User';
                                    } catch (Exception $e) {
                                        $roleName = 'User';
                                    }
                                }
                            }
                            
                            // Tentukan tipe user
                            $isWarga = false;
                            $isPetugas = false;
                            $isAdmin = false;
                            
                            if (method_exists($user, 'isWarga')) {
                                $isWarga = $user->isWarga();
                            } else {
                                $isWarga = in_array(strtolower($roleName), ['warga', 'masyarakat', 'user']);
                            }
                            
                            if (method_exists($user, 'isPetugas')) {
                                $isPetugas = $user->isPetugas();
                            } else {
                                $isPetugas = in_array(strtolower($roleName), ['petugas', 'staff', 'officer']);
                            }
                            
                            if (method_exists($user, 'isAdmin')) {
                                $isAdmin = $user->isAdmin();
                            } else {
                                $isAdmin = in_array(strtolower($roleName), ['admin', 'administrator', 'superadmin']);
                            }
                        @endphp
                        
                        @if($isWarga)
                            <!-- Warga Menu Items -->
                            <a href="{{ route('warga.pengaduan.index') }}" 
                               class="inline-flex items-center px-4 py-2.5 text-sm font-medium rounded-lg text-white hover:bg-blue-700/80 transition-all duration-200 ease-in-out {{ request()->routeIs('warga.pengaduan.*') ? 'nav-link-active' : '' }}">
                                <i class="fas fa-comments mr-2.5 text-sm"></i>Pengaduan
                            </a>
                            <a href="{{ route('warga.surat.index') }}" 
                               class="inline-flex items-center px-4 py-2.5 text-sm font-medium rounded-lg text-white hover:bg-blue-700/80 transition-all duration-200 ease-in-out {{ request()->routeIs('warga.surat.*') ? 'nav-link-active' : '' }}">
                                <i class="fas fa-envelope mr-2.5 text-sm"></i>Surat Online
                            </a>
                        @endif
                        
                        @if($isPetugas || $isAdmin)
                            <!-- Kelola Dropdown (Petugas & Admin) -->
                            <div class="dropdown-container">
                                <button class="inline-flex items-center px-4 py-2.5 text-sm font-medium rounded-lg text-white hover:bg-blue-700/80 transition-all duration-200 ease-in-out {{ request()->routeIs('petugas.pengaduan.*', 'petugas.surat.*') ? 'nav-link-active' : '' }}">
                                    <i class="fas fa-cog mr-2.5 text-sm"></i>Kelola
                                    <i class="fas fa-chevron-down ml-2 text-xs chevron-rotate"></i>
                                </button>
                                
                                <div class="dropdown-content absolute left-0 mt-1 w-56 bg-white rounded-xl shadow-2xl py-2.5 z-50 border border-gray-200 overflow-hidden">
                                    <a href="{{ route('petugas.pengaduan.index') }}" 
                                       class="block px-5 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition-all duration-150 {{ request()->routeIs('petugas.pengaduan.*') ? 'bg-blue-50 text-blue-600 font-medium' : '' }}">
                                        <i class="fas fa-tasks mr-3 text-blue-500"></i>Kelola Pengaduan
                                    </a>
                                    <a href="{{ route('petugas.surat.index') }}" 
                                       class="block px-5 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition-all duration-150 {{ request()->routeIs('petugas.surat.*') ? 'bg-blue-50 text-blue-600 font-medium' : '' }}">
                                        <i class="fas fa-file-alt mr-3 text-blue-500"></i>Kelola Surat
                                    </a>
                                    @if(Route::has('pengaduan.create'))
                                    <div class="border-t border-gray-100 mt-1 pt-1">
                                        <a href="{{ route('pengaduan.create') }}" 
                                           class="block px-5 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition-all duration-150">
                                            <i class="fas fa-plus-circle mr-3 text-green-500"></i>Pengaduan Baru
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                        
                        @if($isAdmin)
                            <!-- Admin Dropdown -->
                            <div class="dropdown-container">
                                <button class="inline-flex items-center px-4 py-2.5 text-sm font-medium rounded-lg text-white hover:bg-blue-700/80 transition-all duration-200 ease-in-out {{ request()->routeIs('admin.*') ? 'nav-link-active' : '' }}">
                                    <i class="fas fa-database mr-2.5 text-sm"></i>Admin
                                    <i class="fas fa-chevron-down ml-2 text-xs chevron-rotate"></i>
                                </button>
                                
                                <div class="dropdown-content absolute left-0 mt-1 w-64 bg-white rounded-xl shadow-2xl py-2.5 z-50 border border-gray-200 overflow-hidden">
                                    <div class="px-5 py-2.5 border-b border-gray-100">
                                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Administrasi Sistem</p>
                                    </div>
                                    
                                    @if(Route::has('admin.users.index'))
                                    <a href="{{ route('admin.users.index') }}" 
                                       class="block px-5 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition-all duration-150 {{ request()->routeIs('admin.users.*') ? 'bg-blue-50 text-blue-600 font-medium' : '' }}">
                                        <i class="fas fa-users mr-3 text-purple-500"></i>Kelola User
                                        @php
                                            $userCount = 0;
                                            if(class_exists('App\\Models\\User')) {
                                                try {
                                                    $userCount = \App\Models\User::count();
                                                } catch(Exception $e) {
                                                    $userCount = 0;
                                                }
                                            }
                                        @endphp
                                        @if($userCount > 0)
                                        <span class="float-right text-xs bg-purple-100 text-purple-600 px-2 py-0.5 rounded-full">
                                            {{ $userCount }}
                                        </span>
                                        @endif
                                    </a>
                                    @endif
                                    
                                    @if(Route::has('admin.kategori_pengaduan.index'))
                                    <a href="{{ route('admin.kategori_pengaduan.index') }}" 
                                       class="block px-5 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition-all duration-150 {{ request()->routeIs('admin.kategori_pengaduan.*') ? 'bg-blue-50 text-blue-600 font-medium' : '' }}">
                                        <i class="fas fa-tags mr-3 text-green-500"></i>Kategori Pengaduan
                                        @php
                                            $kategoriCount = 0;
                                            if(class_exists('App\\Models\\KategoriPengaduan')) {
                                                try {
                                                    $kategoriCount = \App\Models\KategoriPengaduan::count();
                                                } catch(Exception $e) {
                                                    $kategoriCount = 0;
                                                }
                                            }
                                        @endphp
                                        @if($kategoriCount > 0)
                                        <span class="float-right text-xs bg-green-100 text-green-600 px-2 py-0.5 rounded-full">
                                            {{ $kategoriCount }}
                                        </span>
                                        @endif
                                    </a>
                                    @endif
                                    
                                    @if(Route::has('admin.jenis_surat.index'))
                                    <a href="{{ route('admin.jenis_surat.index') }}" 
                                       class="block px-5 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition-all duration-150 {{ request()->routeIs('admin.jenis_surat.*') ? 'bg-blue-50 text-blue-600 font-medium' : '' }}">
                                        <i class="fas fa-file-signature mr-3 text-orange-500"></i>Jenis Surat
                                        @php
                                            $jenisSuratCount = 0;
                                            if(class_exists('App\\Models\\JenisSurat')) {
                                                try {
                                                    $jenisSuratCount = \App\Models\JenisSurat::count();
                                                } catch(Exception $e) {
                                                    $jenisSuratCount = 0;
                                                }
                                            }
                                        @endphp
                                        @if($jenisSuratCount > 0)
                                        <span class="float-right text-xs bg-orange-100 text-orange-600 px-2 py-0.5 rounded-full">
                                            {{ $jenisSuratCount }}
                                        </span>
                                        @endif
                                    </a>
                                    @endif
                                    
                                    <div class="border-t border-gray-100 mt-1 pt-1">
                                        @if(Route::has('admin.reports.index'))
                                        <a href="{{ route('admin.reports.index') }}" 
                                           class="block px-5 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition-all duration-150">
                                            <i class="fas fa-chart-bar mr-3 text-red-500"></i>Laporan & Statistik
                                        </a>
                                        @endif
                                        
                                        @if(Route::has('admin.settings.index'))
                                        <a href="{{ route('admin.settings.index') }}" 
                                           class="block px-5 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition-all duration-150">
                                            <i class="fas fa-cogs mr-3 text-gray-500"></i>Pengaturan Sistem
                                        </a>
                                        @endif
                                    </div>
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
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-lg text-white hover:bg-blue-700/80 focus:outline-none transition-all duration-200">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center mr-2.5 shadow-sm">
                                    <i class="fas fa-user text-white text-xs"></i>
                                </div>
                                <span class="truncate max-w-[120px]">{{ Str::limit(Auth::user()->name, 15) }}</span>
                            </div>
                            <i class="fas fa-chevron-down ml-2 text-xs chevron-rotate"></i>
                        </button>
                        
                        <div class="dropdown-content absolute right-0 mt-1 w-56 bg-white rounded-xl shadow-2xl py-2 z-50 border border-gray-200">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                                <p class="text-xs mt-1">
                                    @php
                                        // Tentukan warna badge berdasarkan role
                                        $roleClass = 'bg-gray-100 text-gray-800';
                                        if ($isAdmin) {
                                            $roleClass = 'bg-purple-100 text-purple-800';
                                        } elseif ($isPetugas) {
                                            $roleClass = 'bg-blue-100 text-blue-800';
                                        } elseif ($isWarga) {
                                            $roleClass = 'bg-green-100 text-green-800';
                                        }
                                    @endphp
                                    <span class="px-2 py-0.5 rounded-full {{ $roleClass }}">
                                        {{ ucfirst($roleName) ?: 'User' }}
                                    </span>
                                </p>
                            </div>
                            <a href="{{ route('profile.edit') }}" 
                               class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition-all duration-150 {{ request()->routeIs('profile.*') ? 'bg-blue-50 text-blue-600 font-medium' : '' }}">
                                <i class="fas fa-user mr-3 text-blue-500"></i>Profile
                            </a>
                            
                            @if(Route::has('notifications.index'))
                            <a href="{{ route('notifications.index') }}" 
                               class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition-all duration-150">
                                <i class="fas fa-bell mr-3 text-yellow-500"></i>Notifikasi
                                @php
                                    $notificationCount = 0;
                                    if(auth()->check()) {
                                        try {
                                            if (method_exists(auth()->user(), 'unreadNotifications')) {
                                                $notificationCount = auth()->user()->unreadNotifications()->count();
                                            }
                                        } catch(Exception $e) {
                                            $notificationCount = 0;
                                        }
                                    }
                                @endphp
                                @if($notificationCount > 0)
                                <span class="float-right text-xs bg-yellow-100 text-yellow-600 px-2 py-0.5 rounded-full">
                                    {{ $notificationCount }}
                                </span>
                                @endif
                            </a>
                            @endif
                            
                            <div class="border-t border-gray-100 mt-1 pt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-red-50 transition-all duration-150">
                                        <i class="fas fa-sign-out-alt mr-3 text-red-500"></i>Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-3">
                    <a href="{{ route('login') }}" class="text-white hover:text-blue-200 px-4 py-2.5 transition-all duration-200 font-medium rounded-lg hover:bg-blue-700/80">
                        <i class="fas fa-sign-in-alt mr-2.5"></i>Login
                    </a>
                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-blue-500 to-purple-600 text-white hover:shadow-lg px-5 py-2.5 rounded-lg font-semibold transition-all duration-200 hover:scale-105 shadow-md">
                        <i class="fas fa-user-plus mr-2.5"></i>Daftar Gratis
                    </a>
                </div>
                @endauth

                <!-- Hamburger Menu for Mobile -->
                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2.5 rounded-lg text-white hover:text-blue-200 hover:bg-blue-700/80 focus:outline-none transition-all duration-200">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div x-show="open" x-cloak class="sm:hidden bg-blue-600 border-t border-blue-500">
            @auth
            <div class="pt-2 pb-3 space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}" 
                   class="block pl-4 pr-4 py-3 text-base font-medium text-white hover:bg-blue-700 transition-all duration-200 rounded-lg mx-2 {{ request()->routeIs('dashboard') ? 'nav-link-active' : '' }}">
                    <i class="fas fa-tachometer-alt mr-3"></i>Dashboard
                </a>
                
                @if($isWarga)
                    <!-- Warga Menu Items -->
                    <a href="{{ route('warga.pengaduan.index') }}" 
                       class="block pl-4 pr-4 py-3 text-base font-medium text-white hover:bg-blue-700 transition-all duration-200 rounded-lg mx-2 {{ request()->routeIs('warga.pengaduan.*') ? 'nav-link-active' : '' }}">
                        <i class="fas fa-comments mr-3"></i>Pengaduan
                    </a>
                    <a href="{{ route('warga.surat.index') }}" 
                       class="block pl-4 pr-4 py-3 text-base font-medium text-white hover:bg-blue-700 transition-all duration-200 rounded-lg mx-2 {{ request()->routeIs('warga.surat.*') ? 'nav-link-active' : '' }}">
                        <i class="fas fa-envelope mr-3"></i>Surat Online
                    </a>
                @endif
                
                @if($isPetugas || $isAdmin)
                    <!-- Kelola Section -->
                    <div class="border-t border-blue-500 pt-3 mx-2">
                        <div class="pl-4 pr-4 py-2 text-base font-medium text-blue-200">
                            <i class="fas fa-cog mr-3"></i>Kelola
                        </div>
                        <a href="{{ route('petugas.pengaduan.index') }}" 
                           class="block pl-8 pr-4 py-3 text-base font-medium text-white hover:bg-blue-700 transition-all duration-200 rounded-lg {{ request()->routeIs('petugas.pengaduan.*') ? 'nav-link-active' : '' }}">
                            <i class="fas fa-tasks mr-3"></i>Kelola Pengaduan
                        </a>
                        <a href="{{ route('petugas.surat.index') }}" 
                           class="block pl-8 pr-4 py-3 text-base font-medium text-white hover:bg-blue-700 transition-all duration-200 rounded-lg {{ request()->routeIs('petugas.surat.*') ? 'nav-link-active' : '' }}">
                            <i class="fas fa-file-alt mr-3"></i>Kelola Surat
                        </a>
                    </div>
                @endif
                
                @if($isAdmin)
                    <!-- Admin Section -->
                    <div class="border-t border-blue-500 pt-3 mx-2">
                        <div class="pl-4 pr-4 py-2 text-base font-medium text-blue-200">
                            <i class="fas fa-database mr-3"></i>Admin
                        </div>
                        @if(Route::has('admin.users.index'))
                        <a href="{{ route('admin.users.index') }}" 
                           class="block pl-8 pr-4 py-3 text-base font-medium text-white hover:bg-blue-700 transition-all duration-200 rounded-lg {{ request()->routeIs('admin.users.*') ? 'nav-link-active' : '' }}">
                            <i class="fas fa-users mr-3"></i>Kelola User
                        </a>
                        @endif
                        
                        @if(Route::has('admin.kategori_pengaduan.index'))
                        <a href="{{ route('admin.kategori_pengaduan.index') }}" 
                           class="block pl-8 pr-4 py-3 text-base font-medium text-white hover:bg-blue-700 transition-all duration-200 rounded-lg {{ request()->routeIs('admin.kategori_pengaduan.*') ? 'nav-link-active' : '' }}">
                            <i class="fas fa-tags mr-3"></i>Kategori Pengaduan
                        </a>
                        @endif
                        
                        @if(Route::has('admin.jenis_surat.index'))
                        <a href="{{ route('admin.jenis_surat.index') }}" 
                           class="block pl-8 pr-4 py-3 text-base font-medium text-white hover:bg-blue-700 transition-all duration-200 rounded-lg {{ request()->routeIs('admin.jenis_surat.*') ? 'nav-link-active' : '' }}">
                            <i class="fas fa-file-signature mr-3"></i>Jenis Surat
                        </a>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-blue-500">
                <div class="px-4 py-3">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center mr-3 shadow-sm">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div>
                            <div class="font-bold text-base text-white">{{ Auth::user()->name }}</div>
                            <div class="font-medium text-sm text-blue-200">{{ Auth::user()->email }}</div>
                            <div class="text-xs mt-1">
                                <span class="px-2 py-0.5 rounded-full {{ $roleClass }}">
                                    {{ ucfirst($roleName) ?: 'User' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <a href="{{ route('profile.edit') }}" 
                       class="block pl-4 pr-4 py-3 text-base font-medium text-white hover:bg-blue-700 transition-all duration-200 rounded-lg mx-2 {{ request()->routeIs('profile.*') ? 'nav-link-active' : '' }}">
                        <i class="fas fa-user mr-3"></i>Profile
                    </a>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left pl-4 pr-4 py-3 text-base font-medium text-white hover:bg-blue-700 transition-all duration-200 rounded-lg mx-2">
                            <i class="fas fa-sign-out-alt mr-3"></i>Log Out
                        </button>
                    </form>
                </div>
            </div>
            @else
            <div class="pt-2 pb-3 space-y-1">
                <a href="{{ route('login') }}" class="block pl-4 pr-4 py-3 text-base font-medium text-white hover:bg-blue-700 transition-all duration-200 rounded-lg mx-2">
                    <i class="fas fa-sign-in-alt mr-3"></i>Login
                </a>
                <a href="{{ route('register') }}" class="block pl-4 pr-4 py-3 text-base font-medium text-white hover:bg-blue-700 transition-all duration-200 rounded-lg mx-2">
                    <i class="fas fa-user-plus mr-3"></i>Daftar Gratis
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
            <header class="bg-white shadow-lg">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
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
        // Auto hide success/error messages after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert-auto-hide');
                alerts.forEach(alert => {
                    alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    setTimeout(() => alert.remove(), 500);
                });
            }, 5000);
            
            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    if(targetId === '#') return;
                    
                    const targetElement = document.querySelector(targetId);
                    if(targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 80,
                            behavior: 'smooth'
                        });
                    }
                });
            });
            
            // Navbar background on scroll
            window.addEventListener('scroll', function() {
                const nav = document.querySelector('nav');
                if (window.scrollY > 50) {
                    nav.classList.add('shadow-xl');
                } else {
                    nav.classList.remove('shadow-xl');
                }
            });
            
            // Close dropdowns when clicking outside on mobile
            document.addEventListener('click', function(event) {
                if (window.innerWidth < 640) {
                    const dropdowns = document.querySelectorAll('.dropdown-container');
                    dropdowns.forEach(dropdown => {
                        if (!dropdown.contains(event.target)) {
                            const content = dropdown.querySelector('.dropdown-content');
                            if (content) {
                                content.style.visibility = 'hidden';
                                content.style.opacity = '0';
                            }
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>