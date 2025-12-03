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
                transform: translateY(-5px);
                box-shadow: 0 20px 40px rgba(102, 126, 234, 0.1);
            }
            
            .form-input-custom {
                transition: all 0.3s ease;
            }
            
            .form-input-custom:focus {
                border-color: #667eea;
                box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            }
            
            .social-login-btn {
                transition: all 0.3s ease;
            }
            
            .social-login-btn:hover {
                transform: translateY(-2px);
            }
        </style>
    </head>
    <body class="font-poppins antialiased bg-gray-50">
        <!-- Navigation -->
        <nav class="fixed w-full z-50 bg-white/90 backdrop-blur-md shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
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

                    <!-- Navigation Links -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="#home" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Beranda</a>
                        <a href="#layanan" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Layanan</a>
                        <a href="#fitur" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Fitur</a>
                        <a href="#kontak" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Kontak</a>
                    </div>

                    <!-- Auth Buttons -->
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-full font-semibold hover:shadow-lg transition-all duration-300 hover:scale-105">
                            <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                        </a>
                        <a href="{{ route('register') }}" class="text-gray-700 hover:text-blue-600 font-medium px-4 py-2 transition-colors">
                            <i class="fas fa-user-plus mr-2"></i>Daftar
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="min-h-screen pt-24 pb-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <!-- Left Column - Illustration & Info -->
                    <div class="hidden lg:block">
                        <div class="bg-gradient-to-br from-blue-600 to-purple-600 rounded-3xl p-8 text-white relative overflow-hidden">
                            <!-- Background Elements -->
                            <div class="absolute inset-0 overflow-hidden">
                                <div class="absolute -top-20 -right-20 w-60 h-60 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
                                <div class="absolute -bottom-20 -left-20 w-60 h-60 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
                            </div>
                            
                            <div class="relative z-10">
                                <div class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full mb-6">
                                    <span class="text-sm font-semibold"><i class="fas fa-rocket mr-2"></i>Akses Cepat & Aman</span>
                                </div>
                                
                                <h2 class="text-3xl font-bold mb-6 leading-tight">
                                    Selamat Datang Kembali di
                                    <span class="text-yellow-300">KelurahanDigital</span>
                                </h2>
                                
                                <p class="text-lg text-blue-100 mb-8 leading-relaxed">
                                    Akses semua layanan digital kelurahan dengan satu akun. Kelola pengaduan, urus surat, dan pantau perkembangan dengan mudah.
                                </p>
                                
                                <!-- Features List -->
                                <div class="space-y-6 mb-8">
                                    <div class="flex items-start">
                                        <div class="bg-white/20 p-3 rounded-xl mr-4">
                                            <i class="fas fa-history text-green-300"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-lg">Riwayat Lengkap</h4>
                                            <p class="text-blue-100">Akses semua pengaduan dan surat yang pernah Anda ajukan</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-start">
                                        <div class="bg-white/20 p-3 rounded-xl mr-4">
                                            <i class="fas fa-bell text-yellow-300"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-lg">Notifikasi Real-time</h4>
                                            <p class="text-blue-100">Dapatkan update instan untuk semua layanan Anda</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-start">
                                        <div class="bg-white/20 p-3 rounded-xl mr-4">
                                            <i class="fas fa-shield-alt text-red-300"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-lg">Keamanan Premium</h4>
                                            <p class="text-blue-100">Data Anda dilindungi dengan enkripsi tingkat tinggi</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Testimonial -->
                                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6">
                                    <div class="flex items-center mb-4">
                                        <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=667eea&color=fff" 
                                             alt="User" class="w-12 h-12 rounded-full border-2 border-white">
                                        <div class="ml-4">
                                            <h4 class="font-bold">Budi Santoso</h4>
                                            <p class="text-sm text-blue-200">Warga Kelurahan Digital</p>
                                        </div>
                                    </div>
                                    <p class="text-blue-100 italic">
                                        "Dengan sistem ini, mengurus surat keterangan hanya butuh 2 hari. Sangat efisien!"
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Login Form -->
                    <div class="bg-white rounded-3xl shadow-xl overflow-hidden card-hover">
                        <div class="p-8">
                            <!-- Header -->
                            <div class="text-center mb-8">
                                <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-sign-in-alt text-white text-2xl"></i>
                                </div>
                                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                                    Masuk ke <span class="gradient-text">Akun Anda</span>
                                </h1>
                                <p class="text-gray-600">
                                    Akses layanan digital kelurahan dengan akun terdaftar
                                </p>
                            </div>

                            <!-- Session Status -->
                            @if (session('status'))
                                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
                                    <div class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                        <span class="text-green-700 font-medium">{{ session('status') }}</span>
                                    </div>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                                    <div class="flex items-center">
                                        <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                                        <div>
                                            <span class="text-red-700 font-medium">Terjadi kesalahan:</span>
                                            <ul class="mt-1 text-sm text-red-600">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Form -->
                            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                                @csrf

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-envelope mr-2"></i>Email atau NIK
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-user text-gray-400"></i>
                                        </div>
                                        <input type="text" id="email" name="email" value="{{ old('email') }}" 
                                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg form-input-custom focus:outline-none focus:ring-2 focus:ring-blue-500"
                                               required autofocus autocomplete="username"
                                               placeholder="Masukkan email atau NIK">
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Anda bisa login menggunakan email atau NIK yang terdaftar</p>
                                </div>

                                <!-- Password -->
                                <div>
                                    <div class="flex items-center justify-between mb-2">
                                        <label for="password" class="block text-sm font-medium text-gray-700">
                                            <i class="fas fa-lock mr-2"></i>Password
                                        </label>
                                        @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                                <i class="fas fa-key mr-1"></i>Lupa Password?
                                            </a>
                                        @endif
                                    </div>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-lock text-gray-400"></i>
                                        </div>
                                        <input type="password" id="password" name="password"
                                               class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg form-input-custom focus:outline-none focus:ring-2 focus:ring-blue-500"
                                               required autocomplete="current-password"
                                               placeholder="Masukkan password">
                                        <button type="button" onclick="togglePassword()" 
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                            <i class="fas fa-eye" id="toggle-icon"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Remember Me & Additional Options -->
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <input id="remember_me" name="remember" type="checkbox" 
                                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        <label for="remember_me" class="ml-2 text-sm text-gray-700">
                                            Ingat saya di perangkat ini
                                        </label>
                                    </div>
                                    
                                    <!-- Quick Login Demo -->
                                    <button type="button" onclick="fillDemoCredentials()"
                                            class="text-sm text-purple-600 hover:text-purple-800 font-medium">
                                        <i class="fas fa-magic mr-1"></i>Coba Demo
                                    </button>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit"
                                        class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-4 px-6 rounded-lg font-bold text-lg hover:shadow-lg transition-all duration-300 hover:scale-[1.02]">
                                    <i class="fas fa-sign-in-alt mr-3"></i>Masuk Sekarang
                                </button>

                                <!-- Divider -->
                                <div class="relative my-6">
                                    <div class="absolute inset-0 flex items-center">
                                        <div class="w-full border-t border-gray-300"></div>
                                    </div>
                                    <div class="relative flex justify-center text-sm">
                                        <span class="px-4 bg-white text-gray-500">atau masuk dengan</span>
                                    </div>
                                </div>

                                <!-- Social Login (Optional) -->
                                <div class="grid grid-cols-2 gap-4">
                                    <button type="button"
                                            class="flex items-center justify-center gap-3 p-3 border border-gray-300 rounded-lg social-login-btn hover:border-blue-500 hover:bg-blue-50">
                                        <i class="fab fa-google text-red-500"></i>
                                        <span class="font-medium text-gray-700">Google</span>
                                    </button>
                                    <button type="button"
                                            class="flex items-center justify-center gap-3 p-3 border border-gray-300 rounded-lg social-login-btn hover:border-blue-600 hover:bg-blue-50">
                                        <i class="fab fa-facebook text-blue-600"></i>
                                        <span class="font-medium text-gray-700">Facebook</span>
                                    </button>
                                </div>

                                <!-- Register Link -->
                                <div class="text-center mt-8 pt-6 border-t border-gray-200">
                                    <p class="text-gray-600">
                                        Belum punya akun?
                                        <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-semibold ml-1">
                                            <i class="fas fa-user-plus mr-1"></i>Daftar di sini
                                        </a>
                                    </p>
                                    <p class="mt-2 text-sm text-gray-500">
                                        Butuh bantuan? 
                                        <a href="#" class="text-purple-600 hover:text-purple-800">
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

        <!-- Footer (Included from Layout) -->
        @include('layouts.footer')

        <!-- JavaScript -->
        <script>
            // Navbar background on scroll
            window.addEventListener('scroll', function() {
                const nav = document.querySelector('nav');
                if (window.scrollY > 50) {
                    nav.classList.add('bg-white', 'shadow-lg');
                    nav.classList.remove('bg-white/90');
                } else {
                    nav.classList.remove('bg-white', 'shadow-lg');
                    nav.classList.add('bg-white/90');
                }
            });

            // Toggle password visibility
            function togglePassword() {
                const passwordInput = document.getElementById('password');
                const toggleIcon = document.getElementById('toggle-icon');
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    toggleIcon.classList.remove('fa-eye');
                    toggleIcon.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    toggleIcon.classList.remove('fa-eye-slash');
                    toggleIcon.classList.add('fa-eye');
                }
            }

            // Fill demo credentials (for testing/demo purposes)
            function fillDemoCredentials() {
                document.getElementById('email').value = 'demo@kelurahandigital.id';
                document.getElementById('password').value = 'demopassword123';
                
                // Show success message
                const demoAlert = document.createElement('div');
                demoAlert.className = 'mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg text-sm text-blue-700';
                demoAlert.innerHTML = `
                    <div class="flex items-center">
                        <i class="fas fa-info-circle mr-2"></i>
                        <span>Kredensial demo telah diisi. Anda bisa login untuk mencoba fitur demo.</span>
                    </div>
                `;
                
                const form = document.querySelector('form');
                form.insertBefore(demoAlert, form.querySelector('button[type="submit"]'));
                
                // Auto remove after 5 seconds
                setTimeout(() => {
                    demoAlert.remove();
                }, 5000);
            }

            // Auto detect if input is email or NIK
            document.getElementById('email').addEventListener('input', function(e) {
                const value = e.target.value;
                const isEmail = value.includes('@');
                const icon = this.parentNode.querySelector('.fa-user');
                
                if (isEmail) {
                    icon.classList.remove('fa-user', 'fa-id-card');
                    icon.classList.add('fa-envelope');
                    this.type = 'email';
                } else if (/^\d+$/.test(value)) {
                    icon.classList.remove('fa-user', 'fa-envelope');
                    icon.classList.add('fa-id-card');
                    this.type = 'text';
                } else {
                    icon.classList.remove('fa-id-card', 'fa-envelope');
                    icon.classList.add('fa-user');
                    this.type = 'text';
                }
            });

            // Enter key to submit
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && !e.target.matches('textarea, button, a')) {
                    e.preventDefault();
                    document.querySelector('button[type="submit"]').click();
                }
            });

            // Show welcome back message if returning from registration
            if (window.location.search.includes('registered=true')) {
                const welcomeAlert = document.createElement('div');
                welcomeAlert.className = 'mb-6 p-4 bg-green-50 border border-green-200 rounded-xl animate-pulse';
                welcomeAlert.innerHTML = `
                    <div class="flex items-center">
                        <i class="fas fa-party-horn text-green-500 mr-3"></i>
                        <div>
                            <span class="font-bold text-green-700">Selamat! Akun Anda berhasil dibuat.</span>
                            <p class="text-green-600 text-sm mt-1">Silakan login dengan email dan password yang telah Anda buat.</p>
                        </div>
                    </div>
                `;
                
                const form = document.querySelector('form');
                form.insertBefore(welcomeAlert, form.firstChild);
            }
        </script>
    </body>
</html>