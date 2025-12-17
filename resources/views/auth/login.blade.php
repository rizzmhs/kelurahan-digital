<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Masuk Akun - Sistem Layanan Kelurahan Terpadu</title>

        <!-- Fonts & Icons -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Additional Styles -->
        <script src="https://cdn.tailwindcss.com"></script>
        
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
            
            .font-poppins { font-family: 'Poppins', sans-serif; }
            .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
            .gradient-text { 
                background: linear-gradient(90deg, #667eea, #764ba2);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }
            .card-hover { 
                transition: all 0.3s ease; 
            }
            .card-hover:hover { 
                transform: translateY(-5px); 
                box-shadow: 0 20px 40px rgba(102, 126, 234, 0.15); 
            }
            .form-input-custom:focus { 
                border-color: #667eea; 
                box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); 
            }
            .social-login-btn { 
                transition: all 0.2s ease; 
            }
            .social-login-btn:hover { 
                transform: translateY(-2px); 
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            }
            [x-cloak] { 
                display: none !important; 
            }
            
            /* Custom scrollbar */
            ::-webkit-scrollbar {
                width: 8px;
            }
            ::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 4px;
            }
            ::-webkit-scrollbar-thumb {
                background: #c1c1c1;
                border-radius: 4px;
            }
            ::-webkit-scrollbar-thumb:hover {
                background: #a1a1a1;
            }
            
            /* Smooth transitions */
            .transition-all {
                transition-property: all;
                transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
                transition-duration: 200ms;
            }
            
            /* Animation for demo alert */
            @keyframes slideIn {
                from {
                    transform: translateY(-20px);
                    opacity: 0;
                }
                to {
                    transform: translateY(0);
                    opacity: 1;
                }
            }
            
            .animate-slideIn {
                animation: slideIn 0.3s ease-out;
            }
        </style>
    </head>
    <body class="font-poppins antialiased bg-gradient-to-br from-blue-50 to-purple-50 min-h-screen" 
          x-data="loginPage()" 
          x-init="init()">
        
        <!-- Demo Alert -->
        <div x-show="showDemoAlert" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-md px-4">
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 shadow-lg">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-500 text-lg"></i>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-medium text-blue-800">
                            Kredensial demo telah diisi. Klik "Masuk Sekarang" untuk mencoba.
                        </p>
                    </div>
                    <button @click="showDemoAlert = false" 
                            class="ml-auto flex-shrink-0 text-blue-400 hover:text-blue-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="fixed w-full z-40 bg-white/95 backdrop-blur-md shadow-sm" 
             :class="{ 'shadow-md': scrolled }"
             x-data="{ scrolled: false }" 
             @scroll.window="scrolled = window.scrollY > 20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16 md:h-20">
                    <!-- Logo -->
                    <div class="flex items-center space-x-3">
                        <a href="{{ url('/') }}" class="flex items-center space-x-3">
                            <div class="bg-gradient-to-br from-blue-600 to-purple-600 p-2 rounded-xl">
                                <i class="fas fa-landmark text-white text-2xl"></i>
                            </div>
                            <div>
                                <h1 class="text-xl font-bold text-gray-900">Kelurahan<span class="text-yellow-300">Digital</span></h1>
                                <p class="text-xs text-gray-500">Sistem Layanan Terpadu</p>
                            </div>
                        </a>
                    </div>

                    <!-- Navigation Links (Desktop) -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="{{ url('/') }}#beranda" 
                           class="text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200">
                            Beranda
                        </a>
                        <a href="{{ url('/') }}#layanan" 
                           class="text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200">
                            Layanan
                        </a>
                        <a href="{{ url('/') }}#fitur" 
                           class="text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200">
                            Fitur
                        </a>
                        <a href="{{ url('/') }}#kontak" 
                           class="text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200">
                            Kontak
                        </a>
                    </div>

                    <!-- Auth Buttons -->
                    <div class="flex items-center space-x-3 md:space-x-4">
                        <a href="{{ route('login') }}" 
                           class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-4 md:px-6 py-2 md:py-3 rounded-full font-semibold text-sm md:text-base hover:shadow-lg transition-all duration-200 hover:scale-105">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            <span class="hidden md:inline">Masuk</span>
                        </a>
                        <a href="{{ route('register') }}" 
                           class="text-gray-700 hover:text-blue-600 font-medium px-3 md:px-4 py-2 text-sm md:text-base transition-colors duration-200">
                            <i class="fas fa-user-plus mr-2"></i>
                            <span class="hidden md:inline">Daftar</span>
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="min-h-screen pt-20 md:pt-24 pb-12 md:pb-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-8 md:gap-12 items-center">
                    <!-- Left Column - Illustration & Info (Desktop only) -->
                    <div class="hidden lg:block">
                        <div class="bg-gradient-to-br from-blue-600 to-purple-600 rounded-3xl p-6 md:p-8 text-white relative overflow-hidden">
                            <!-- Background Elements -->
                            <div class="absolute inset-0 overflow-hidden">
                                <div class="absolute -top-20 -right-20 w-60 h-60 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
                                <div class="absolute -bottom-20 -left-20 w-60 h-60 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
                            </div>
                            
                            <div class="relative z-10">
                                <div class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full mb-6">
                                    <span class="text-sm font-semibold">
                                        <i class="fas fa-rocket mr-2"></i>Akses Cepat & Aman
                                    </span>
                                </div>
                                
                                <h2 class="text-2xl md:text-3xl font-bold mb-6 leading-tight">
                                    Selamat Datang Kembali di Kelurahan<span class="text-yellow-300">Digital</span>
                                </h2>
                                
                                <p class="text-base md:text-lg text-blue-100 mb-8 leading-relaxed">
                                    Akses semua layanan digital kelurahan dengan satu akun. Kelola pengaduan, urus surat, dan pantau perkembangan dengan mudah.
                                </p>
                                
                                <!-- Features List -->
                                <div class="space-y-4 md:space-y-6 mb-8">
                                    <div class="flex items-start">
                                        <div class="bg-white/20 p-3 rounded-xl mr-3 md:mr-4 flex-shrink-0">
                                            <i class="fas fa-history text-green-300 text-lg"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-base md:text-lg">Riwayat Lengkap</h4>
                                            <p class="text-blue-100 text-sm md:text-base">Akses semua pengaduan dan surat yang pernah Anda ajukan</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-start">
                                        <div class="bg-white/20 p-3 rounded-xl mr-3 md:mr-4 flex-shrink-0">
                                            <i class="fas fa-bell text-yellow-300 text-lg"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-base md:text-lg">Notifikasi Real-time</h4>
                                            <p class="text-blue-100 text-sm md:text-base">Dapatkan update instan untuk semua layanan Anda</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-start">
                                        <div class="bg-white/20 p-3 rounded-xl mr-3 md:mr-4 flex-shrink-0">
                                            <i class="fas fa-shield-alt text-red-300 text-lg"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-base md:text-lg">Keamanan Premium</h4>
                                            <p class="text-blue-100 text-sm md:text-base">Data Anda dilindungi dengan enkripsi tingkat tinggi</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Testimonial -->
                                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 md:p-6">
                                    <div class="flex items-center mb-3 md:mb-4">
                                        <div class="w-10 h-10 md:w-12 md:h-12 rounded-full border-2 border-white overflow-hidden flex-shrink-0">
                                            <div class="w-full h-full bg-blue-400 flex items-center justify-center text-white font-bold">
                                                BS
                                            </div>
                                        </div>
                                        <div class="ml-3 md:ml-4">
                                            <h4 class="font-bold text-sm md:text-base">Budi Santoso</h4>
                                            <p class="text-xs md:text-sm text-blue-200">Warga Kelurahan Digital</p>
                                        </div>
                                    </div>
                                    <p class="text-blue-100 text-sm md:text-base italic">
                                        "Dengan sistem ini, mengurus surat keterangan hanya butuh 2 hari. Sangat efisien!"
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Login Form -->
                    <div class="bg-white rounded-2xl md:rounded-3xl shadow-xl overflow-hidden card-hover">
                        <div class="p-6 md:p-8">
                            <!-- Header -->
                            <div class="text-center mb-6 md:mb-8">
                                <div class="w-14 h-14 md:w-16 md:h-16 bg-gradient-to-br from-blue-600 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-3 md:mb-4">
                                    <i class="fas fa-sign-in-alt text-white text-xl md:text-2xl"></i>
                                </div>
                                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">
                                    Masuk ke <span class="gradient-text">Akun Anda</span>
                                </h1>
                                <p class="text-gray-600 text-sm md:text-base">
                                    Akses layanan digital kelurahan dengan akun terdaftar
                                </p>
                            </div>

                            <!-- Session Status -->
                            @if (session('status'))
                                <div class="mb-4 md:mb-6 p-3 md:p-4 bg-green-50 border border-green-200 rounded-xl">
                                    <div class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-2 md:mr-3 text-sm md:text-base"></i>
                                        <span class="text-green-700 font-medium text-sm md:text-base">{{ session('status') }}</span>
                                    </div>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="mb-4 md:mb-6 p-3 md:p-4 bg-red-50 border border-red-200 rounded-xl">
                                    <div class="flex items-start">
                                        <i class="fas fa-exclamation-circle text-red-500 mr-2 md:mr-3 mt-0.5 text-sm md:text-base"></i>
                                        <div class="flex-1">
                                            <span class="text-red-700 font-medium text-sm md:text-base">Terjadi kesalahan:</span>
                                            <ul class="mt-1 text-xs md:text-sm text-red-600 space-y-0.5">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Form -->
                            <form method="POST" action="{{ route('login') }}" class="space-y-4 md:space-y-6">
                                @csrf

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-envelope mr-2 text-gray-500"></i>Email atau NIK
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas text-gray-400" :class="inputIcon"></i>
                                        </div>
                                        <input type="text" 
                                               id="email" 
                                               name="email" 
                                               value="{{ old('email') }}" 
                                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg form-input-custom focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm md:text-base"
                                               required 
                                               autofocus 
                                               autocomplete="username"
                                               placeholder="Masukkan email atau NIK"
                                               x-on:input="detectInputType($event.target.value)">
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">
                                        Anda bisa login menggunakan email atau NIK yang terdaftar
                                    </p>
                                </div>

                                <!-- Password -->
                                <div>
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-2">
                                        <label for="password" class="block text-sm font-medium text-gray-700">
                                            <i class="fas fa-lock mr-2 text-gray-500"></i>Password
                                        </label>
                                        @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}" 
                                               class="text-xs md:text-sm text-blue-600 hover:text-blue-800 font-medium transition-colors">
                                                <i class="fas fa-key mr-1"></i>Lupa Password?
                                            </a>
                                        @endif
                                    </div>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-lock text-gray-400"></i>
                                        </div>
                                        <input :type="showPassword ? 'text' : 'password'" 
                                               id="password" 
                                               name="password"
                                               class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg form-input-custom focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm md:text-base"
                                               required 
                                               autocomplete="current-password"
                                               placeholder="Masukkan password">
                                        <button type="button" 
                                                @click="showPassword = !showPassword" 
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
                                            <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Remember Me & Demo Button -->
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                    <div class="flex items-center">
                                        <input id="remember_me" 
                                               name="remember" 
                                               type="checkbox" 
                                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 focus:ring-offset-0">
                                        <label for="remember_me" class="ml-2 text-sm text-gray-700 select-none">
                                            Ingat saya di perangkat ini
                                        </label>
                                    </div>
                                    
                                    <button type="button" 
                                            @click="fillDemoCredentials()"
                                            class="text-sm text-purple-600 hover:text-purple-800 font-medium transition-colors flex items-center">
                                        <i class="fas fa-magic mr-1.5"></i>
                                        Coba Kredensial Demo
                                    </button>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit"
                                        class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 md:py-4 px-6 rounded-lg font-semibold text-base md:text-lg hover:shadow-lg transition-all duration-200 hover:scale-[1.02] active:scale-[0.98]">
                                    <i class="fas fa-sign-in-alt mr-3"></i>
                                    Masuk Sekarang
                                </button>

                                <!-- Divider -->
                                <div class="relative my-4 md:my-6">
                                    <div class="absolute inset-0 flex items-center">
                                        <div class="w-full border-t border-gray-300"></div>
                                    </div>
                                    <div class="relative flex justify-center text-sm">
                                        <span class="px-4 bg-white text-gray-500">atau masuk dengan</span>
                                    </div>
                                </div>

                                <!-- Google Login -->
                                <div class="space-y-3">
                                    <a href="{{ route('google.redirect') }}"
                                       class="flex items-center justify-center gap-3 p-3 border border-gray-300 rounded-lg social-login-btn hover:border-red-400 hover:bg-red-50 transition-all duration-200">
                                        <i class="fab fa-google text-red-500 text-lg"></i>
                                        <span class="font-medium text-gray-700">Google</span>
                                    </a>
                                </div>

                                <!-- Register Link -->
                                <div class="text-center mt-6 md:mt-8 pt-4 md:pt-6 border-t border-gray-200">
                                    <p class="text-gray-600 text-sm md:text-base mb-2">
                                        Belum punya akun?
                                        <a href="{{ route('register') }}" 
                                           class="text-blue-600 hover:text-blue-800 font-semibold ml-1 transition-colors">
                                            <i class="fas fa-user-plus mr-1"></i>Daftar di sini
                                        </a>
                                    </p>
                                    <p class="text-xs md:text-sm text-gray-500">
                                        Butuh bantuan? 
                                        <a href="mailto:admin@kelurahandigital.id" 
                                           class="text-purple-600 hover:text-purple-800 transition-colors">
                                            <i class="fas fa-headset mr-1"></i>Hubungi Admin
                                        </a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        @include('layouts.footer')

        <!-- JavaScript -->
        <script>
            function loginPage() {
                return {
                    showPassword: false,
                    inputIcon: 'fa-user',
                    showDemoAlert: false,
                    scrolled: false,

                    init() {
                        this.initScrollListener();
                        this.initEnterKey();
                        
                        // Check if user just registered
                        if (window.location.search.includes('registered=true')) {
                            setTimeout(() => {
                                this.showSuccessAlert('Pendaftaran berhasil! Silakan login dengan akun Anda.');
                            }, 500);
                        }
                    },

                    detectInputType(value) {
                        const trimmedValue = value.trim();
                        const isEmail = trimmedValue.includes('@');
                        const isNIK = /^\d+$/.test(trimmedValue);
                        
                        if (isEmail) {
                            this.inputIcon = 'fa-envelope';
                            document.getElementById('email').type = 'email';
                        } else if (isNIK) {
                            this.inputIcon = 'fa-id-card';
                            document.getElementById('email').type = 'text';
                        } else {
                            this.inputIcon = 'fa-user';
                            document.getElementById('email').type = 'text';
                        }
                    },

                    fillDemoCredentials() {
                        document.getElementById('email').value = 'demo@kelurahandigital.id';
                        document.getElementById('password').value = 'demopassword123';
                        
                        this.inputIcon = 'fa-envelope';
                        this.showDemoAlert = true;
                        
                        // Auto focus password field
                        setTimeout(() => {
                            document.getElementById('password').focus();
                        }, 100);
                        
                        // Hide alert after 5 seconds
                        setTimeout(() => {
                            this.showDemoAlert = false;
                        }, 5000);
                    },

                    initScrollListener() {
                        window.addEventListener('scroll', () => {
                            this.scrolled = window.scrollY > 20;
                        });
                    },

                    initEnterKey() {
                        document.addEventListener('keydown', (e) => {
                            if (e.key === 'Enter' && !e.target.matches('textarea, button, a')) {
                                e.preventDefault();
                                const submitBtn = document.querySelector('button[type="submit"]');
                                if (submitBtn) {
                                    submitBtn.focus();
                                    submitBtn.click();
                                }
                            }
                        });
                    },

                    showSuccessAlert(message) {
                        const alertDiv = document.createElement('div');
                        alertDiv.className = 'fixed top-4 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-md px-4 animate-slideIn';
                        alertDiv.innerHTML = `
                            <div class="bg-green-50 border border-green-200 rounded-xl p-4 shadow-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 text-lg mr-3"></i>
                                    <p class="text-sm font-medium text-green-800 flex-1">${message}</p>
                                    <button onclick="this.parentElement.parentElement.remove()" 
                                            class="text-green-400 hover:text-green-600 ml-3">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        `;
                        document.body.appendChild(alertDiv);
                        
                        setTimeout(() => {
                            if (alertDiv.parentNode) {
                                alertDiv.remove();
                            }
                        }, 5000);
                    }
                }
            }
        </script>
    </body>
</html>