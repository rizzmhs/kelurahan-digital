<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Daftar Akun - Sistem Layanan Kelurahan Terpadu</title>

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
            
            /* Animation for checkmark */
            .checkmark-circle {
                stroke-dasharray: 166;
                stroke-dashoffset: 166;
                stroke-width: 2;
                stroke-miterlimit: 10;
                stroke: #10b981;
                fill: none;
                animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
            }
            
            .checkmark {
                width: 56px;
                height: 56px;
                border-radius: 50%;
                display: block;
                stroke-width: 2;
                stroke: #fff;
                stroke-miterlimit: 10;
                margin: 10% auto;
                box-shadow: inset 0px 0px 0px #10b981;
                animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
            }
            
            .checkmark-check {
                transform-origin: 50% 50%;
                stroke-dasharray: 48;
                stroke-dashoffset: 48;
                animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
            }
            
            @keyframes stroke {
                100% {
                    stroke-dashoffset: 0;
                }
            }
            
            @keyframes scale {
                0%, 100% {
                    transform: none;
                }
                50% {
                    transform: scale3d(1.1, 1.1, 1);
                }
            }
            
            @keyframes fill {
                100% {
                    box-shadow: inset 0px 0px 0px 30px #10b981;
                }
            }
            
            /* Upload area animations */
            .upload-success {
                animation: successPulse 2s infinite;
            }
            
            @keyframes successPulse {
                0% {
                    box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4);
                }
                70% {
                    box-shadow: 0 0 0 10px rgba(16, 185, 129, 0);
                }
                100% {
                    box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
                }
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
                        <a href="{{ url('/') }}" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">
                            <i class="fas fa-home mr-2"></i>Beranda
                        </a>
                        <a href="{{ url('/#layanan') }}" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">
                            <i class="fas fa-concierge-bell mr-2"></i>Layanan
                        </a>
                    </div>

                    <!-- Auth Buttons -->
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 font-medium px-4 py-2 transition-colors">
                            <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                        </a>
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-full font-semibold hover:shadow-lg transition-all duration-300 hover:scale-105">
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
                                    <span class="text-sm font-semibold"><i class="fas fa-shield-alt mr-2"></i>Keamanan Terjamin</span>
                                </div>
                                
                                <h2 class="text-3xl font-bold mb-6 leading-tight">
                                    Bergabung dengan
                                    <span class="text-yellow-300">1.250+</span>
                                    Warga Terdaftar
                                </h2>
                                
                                <p class="text-lg text-blue-100 mb-8 leading-relaxed">
                                    Daftarkan diri Anda untuk mengakses semua layanan digital kelurahan secara lengkap dan terintegrasi.
                                </p>
                                
                                <!-- Features List -->
                                <div class="space-y-6 mb-8">
                                    <div class="flex items-start">
                                        <div class="bg-white/20 p-3 rounded-xl mr-4">
                                            <i class="fas fa-bolt text-yellow-300"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-lg">Proses Cepat</h4>
                                            <p class="text-blue-100">Pengurusan surat 2x lebih cepat dari cara konvensional</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-start">
                                        <div class="bg-white/20 p-3 rounded-xl mr-4">
                                            <i class="fas fa-chart-line text-green-300"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-lg">Tracking Real-time</h4>
                                            <p class="text-blue-100">Pantau perkembangan layanan kapan saja, di mana saja</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-start">
                                        <div class="bg-white/20 p-3 rounded-xl mr-4">
                                            <i class="fas fa-bell text-red-300"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-lg">Notifikasi Otomatis</h4>
                                            <p class="text-blue-100">Dapatkan pemberitahuan via WhatsApp & Email</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Stats -->
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold">98%</div>
                                        <div class="text-sm text-blue-200">Kepuasan</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold">24/7</div>
                                        <div class="text-sm text-blue-200">Akses</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold">0</div>
                                        <div class="text-sm text-blue-200">Biaya</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Registration Form -->
                    <div class="bg-white rounded-3xl shadow-xl overflow-hidden card-hover">
                        <div class="p-8">
                            <!-- Header -->
                            <div class="text-center mb-8">
                                <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-user-plus text-white text-2xl"></i>
                                </div>
                                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                                    Buat Akun <span class="gradient-text">Baru</span>
                                </h1>
                                <p class="text-gray-600">
                                    Isi data diri dengan lengkap untuk proses verifikasi
                                </p>
                            </div>

                            <!-- Error Messages -->
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
                            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" id="registerForm" class="space-y-6">
                                @csrf

                                <!-- Name & NIK -->
                                <div class="grid md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-user mr-2"></i>Nama Lengkap *
                                        </label>
                                        <input type="text" id="name" name="name" value="{{ old('name') }}" 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input-custom focus:outline-none focus:ring-2 focus:ring-blue-500"
                                               required autofocus autocomplete="name">
                                        @error('name')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-id-card mr-2"></i>NIK *
                                        </label>
                                        <input type="text" id="nik" name="nik" value="{{ old('nik') }}"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input-custom focus:outline-none focus:ring-2 focus:ring-blue-500"
                                               required maxlength="16" minlength="16" pattern="[0-9]{16}"
                                               oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                        <p class="mt-1 text-xs text-gray-500">16 digit angka (tanpa huruf dan spasi)</p>
                                        @error('nik')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Email & Telepon -->
                                <div class="grid md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-envelope mr-2"></i>Email *
                                        </label>
                                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input-custom focus:outline-none focus:ring-2 focus:ring-blue-500"
                                               required autocomplete="email">
                                        @error('email')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="telepon" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-phone mr-2"></i>Nomor Telepon *
                                        </label>
                                        <input type="tel" id="telepon" name="telepon" value="{{ old('telepon') }}"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input-custom focus:outline-none focus:ring-2 focus:ring-blue-500"
                                               required pattern="[0-9]{10,13}"
                                               oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                        <p class="mt-1 text-xs text-gray-500">10-13 digit angka</p>
                                        @error('telepon')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Date of Birth & Gender -->
                                <div class="grid md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-calendar-alt mr-2"></i>Tanggal Lahir *
                                        </label>
                                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input-custom focus:outline-none focus:ring-2 focus:ring-blue-500"
                                               required max="{{ date('Y-m-d', strtotime('-17 years')) }}">
                                        @error('tanggal_lahir')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        <p class="mt-1 text-xs text-gray-500">Minimal usia 17 tahun</p>
                                    </div>

                                    <div>
                                        <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-venus-mars mr-2"></i>Jenis Kelamin *
                                        </label>
                                        <select id="jenis_kelamin" name="jenis_kelamin"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input-custom focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                        @error('jenis_kelamin')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Address -->
                                <div>
                                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-map-marker-alt mr-2"></i>Alamat Lengkap *
                                    </label>
                                    <textarea id="alamat" name="alamat" rows="3"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input-custom focus:outline-none focus:ring-2 focus:ring-blue-500"
                                              required>{{ old('alamat') }}</textarea>
                                    @error('alamat')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- KTP Photo Upload - MODIFIED SECTION -->
                                <div>
                                    <label for="foto_ktp" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-camera mr-2"></i>Foto KTP *
                                    </label>
                                    <div id="upload-container" class="mt-1">
                                        <!-- Default Upload State -->
                                        <div id="upload-default" class="flex justify-center px-6 pt-8 pb-8 border-2 border-dashed border-gray-300 rounded-xl hover:border-blue-500 transition-all duration-300 cursor-pointer bg-white">
                                            <div class="space-y-3 text-center">
                                                <div class="flex justify-center">
                                                    <div class="w-16 h-16 bg-gradient-to-br from-blue-100 to-blue-50 rounded-full flex items-center justify-center">
                                                        <i class="fas fa-cloud-upload-alt text-blue-400 text-2xl"></i>
                                                    </div>
                                                </div>
                                                <div class="space-y-1">
                                                    <p class="text-sm font-medium text-gray-700">Klik untuk upload file</p>
                                                    <p class="text-xs text-gray-500">atau drag & drop</p>
                                                </div>
                                                <div class="text-xs text-gray-400">
                                                    <p>Format: JPG, JPEG, PNG, PDF</p>
                                                    <p>Maksimal: 2MB</p>
                                                </div>
                                                <input id="foto_ktp" name="foto_ktp" type="file" accept=".jpg,.jpeg,.png,.pdf" class="hidden" required>
                                            </div>
                                        </div>

                                        <!-- Success State (Hidden by default) -->
                                        <div id="upload-success" class="hidden flex justify-center px-6 pt-8 pb-8 border-2 border-dashed border-green-500 rounded-xl bg-green-50 upload-success">
                                            <div class="space-y-4 text-center">
                                                <!-- Animated Checkmark -->
                                                <div class="flex justify-center">
                                                    <div class="relative">
                                                        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center">
                                                            <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                                                                <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none"/>
                                                                <path class="checkmark-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                                                            </svg>
                                                        </div>
                                                        <div class="absolute -top-1 -right-1 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                                            <i class="fas fa-check text-white text-xs"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="space-y-1">
                                                    <p class="text-sm font-medium text-green-700">File berhasil diupload!</p>
                                                    <p id="file-name" class="text-xs text-green-600"></p>
                                                    <p id="file-size" class="text-xs text-green-500"></p>
                                                </div>
                                                <div>
                                                    <button type="button" onclick="removeFile()" class="text-xs text-red-600 hover:text-red-800 font-medium">
                                                        <i class="fas fa-trash-alt mr-1"></i> Hapus file
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Error State (Hidden by default) -->
                                        <div id="upload-error" class="hidden flex justify-center px-6 pt-8 pb-8 border-2 border-dashed border-red-300 rounded-xl bg-red-50">
                                            <div class="space-y-3 text-center">
                                                <div class="flex justify-center">
                                                    <div class="w-16 h-16 bg-gradient-to-br from-red-100 to-red-50 rounded-full flex items-center justify-center">
                                                        <i class="fas fa-exclamation-triangle text-red-400 text-2xl"></i>
                                                    </div>
                                                </div>
                                                <div class="space-y-1">
                                                    <p id="error-message" class="text-sm font-medium text-red-700"></p>
                                                    <p class="text-xs text-red-500">Silakan upload file yang sesuai</p>
                                                </div>
                                                <button type="button" onclick="retryUpload()" class="text-xs text-blue-600 hover:text-blue-800 font-medium">
                                                    <i class="fas fa-redo mr-1"></i> Coba lagi
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @error('foto_ktp')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">Pastikan foto KTP jelas dan dapat dibaca</p>
                                </div>

                                <!-- Password -->
                                <div class="grid md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-lock mr-2"></i>Password *
                                        </label>
                                        <div class="relative">
                                            <input type="password" id="password" name="password"
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input-custom focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                   required autocomplete="new-password">
                                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePassword('password')">
                                                <i class="fas fa-eye text-gray-400"></i>
                                            </button>
                                        </div>
                                        <div id="password-strength" class="mt-2 text-sm"></div>
                                        @error('password')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-lock mr-2"></i>Konfirmasi Password *
                                        </label>
                                        <div class="relative">
                                            <input type="password" id="password_confirmation" name="password_confirmation"
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input-custom focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                   required autocomplete="new-password">
                                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePassword('password_confirmation')">
                                                <i class="fas fa-eye text-gray-400"></i>
                                            </button>
                                        </div>
                                        @error('password_confirmation')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Terms -->
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="terms" name="terms" type="checkbox" 
                                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                               required {{ old('terms') ? 'checked' : '' }}>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="terms" class="text-gray-700">
                                            Saya menyetujui 
                                            <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Syarat & Ketentuan</a> 
                                            dan 
                                            <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Kebijakan Privasi</a>
                                        </label>
                                    </div>
                                </div>
                                @error('terms')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror

                                <!-- Submit Button -->
                                <button type="submit" id="submitBtn"
                                        class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-4 px-6 rounded-lg font-bold text-lg hover:shadow-lg transition-all duration-300 hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed">
                                    <i class="fas fa-user-plus mr-3"></i>Daftar Akun
                                </button>

                                <!-- Login Link -->
                                <div class="text-center mt-6">
                                    <p class="text-gray-600">
                                        Sudah punya akun?
                                        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-semibold ml-1">
                                            <i class="fas fa-sign-in-alt mr-1"></i>Masuk di sini
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

            // Upload file functionality
            const uploadDefault = document.getElementById('upload-default');
            const uploadSuccess = document.getElementById('upload-success');
            const uploadError = document.getElementById('upload-error');
            const fileInput = document.getElementById('foto_ktp');
            const fileNameDisplay = document.getElementById('file-name');
            const fileSizeDisplay = document.getElementById('file-size');
            const errorMessageDisplay = document.getElementById('error-message');

            // Click to upload
            uploadDefault.addEventListener('click', function() {
                fileInput.click();
            });

            // Drag and drop functionality
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                uploadDefault.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                uploadDefault.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                uploadDefault.addEventListener(eventName, unhighlight, false);
            });

            function highlight() {
                uploadDefault.classList.add('border-blue-500', 'bg-blue-50');
            }

            function unhighlight() {
                uploadDefault.classList.remove('border-blue-500', 'bg-blue-50');
            }

            // Handle file drop
            uploadDefault.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                handleFiles(files);
            }

            // Handle file input change
            fileInput.addEventListener('change', function(e) {
                handleFiles(this.files);
            });

            function handleFiles(files) {
                const file = files[0];
                if (!file) return;

                const maxSize = 2 * 1024 * 1024; // 2MB
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];

                // Reset all states first
                uploadDefault.classList.add('hidden');
                uploadSuccess.classList.add('hidden');
                uploadError.classList.add('hidden');

                // Validate file
                if (!allowedTypes.includes(file.type)) {
                    errorMessageDisplay.textContent = 'Format file tidak didukung. Harap upload JPG, JPEG, PNG, atau PDF.';
                    uploadError.classList.remove('hidden');
                    fileInput.value = '';
                    return;
                }

                if (file.size > maxSize) {
                    errorMessageDisplay.textContent = 'Ukuran file terlalu besar. Maksimal 2MB.';
                    uploadError.classList.remove('hidden');
                    fileInput.value = '';
                    return;
                }

                // Show success state
                fileNameDisplay.textContent = file.name;
                fileSizeDisplay.textContent = `(${(file.size / 1024 / 1024).toFixed(2)} MB)`;
                uploadSuccess.classList.remove('hidden');

                // Add pulse animation
                setTimeout(() => {
                    uploadSuccess.classList.add('upload-success');
                }, 100);
            }

            // Remove file
            function removeFile() {
                fileInput.value = '';
                uploadSuccess.classList.add('hidden');
                uploadDefault.classList.remove('hidden');
                uploadSuccess.classList.remove('upload-success');
            }

            // Retry upload
            function retryUpload() {
                uploadError.classList.add('hidden');
                uploadDefault.classList.remove('hidden');
                fileInput.click();
            }

            // Toggle password visibility
            function togglePassword(fieldId) {
                const passwordInput = document.getElementById(fieldId);
                const toggleIcon = passwordInput.nextElementSibling.querySelector('i');
                
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

            // Real-time password strength checker
            document.getElementById('password').addEventListener('input', function() {
                const password = this.value;
                const strengthIndicator = document.getElementById('password-strength');
                
                if (!strengthIndicator) {
                    const indicator = document.createElement('div');
                    indicator.id = 'password-strength';
                    indicator.className = 'mt-2 text-sm';
                    this.parentNode.parentNode.appendChild(indicator);
                }
                
                let strength = 0;
                const messages = ['Sangat lemah', 'Lemah', 'Cukup', 'Kuat', 'Sangat kuat'];
                const colors = ['text-red-600', 'text-orange-600', 'text-yellow-600', 'text-blue-600', 'text-green-600'];
                const icons = ['fas fa-times-circle', 'fas fa-exclamation-triangle', 'fas fa-check-circle', 'fas fa-thumbs-up', 'fas fa-shield-alt'];
                
                if (password.length >= 8) strength++;
                if (/[A-Z]/.test(password)) strength++;
                if (/[0-9]/.test(password)) strength++;
                if (/[^A-Za-z0-9]/.test(password)) strength++;
                
                strengthIndicator.innerHTML = `
                    <i class="${icons[strength]} mr-2"></i>
                    <span class="${colors[strength]}">Kekuatan password: ${messages[strength]}</span>
                `;
                
                // Check password match
                const confirmPassword = document.getElementById('password_confirmation');
                if (confirmPassword.value) {
                    validatePasswordMatch();
                }
            });

            // Validate password match
            function validatePasswordMatch() {
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('password_confirmation').value;
                const submitBtn = document.getElementById('submitBtn');
                
                if (password && confirmPassword) {
                    if (password !== confirmPassword) {
                        // Add error styling
                        document.getElementById('password_confirmation').classList.add('border-red-500');
                        document.getElementById('password_confirmation').classList.remove('border-gray-300');
                        submitBtn.disabled = true;
                        
                        // Show error message
                        let errorMsg = document.getElementById('password-match-error');
                        if (!errorMsg) {
                            errorMsg = document.createElement('p');
                            errorMsg.id = 'password-match-error';
                            errorMsg.className = 'mt-2 text-sm text-red-600';
                            document.getElementById('password_confirmation').parentNode.appendChild(errorMsg);
                        }
                        errorMsg.textContent = 'Password tidak cocok';
                    } else {
                        // Remove error styling
                        document.getElementById('password_confirmation').classList.remove('border-red-500');
                        document.getElementById('password_confirmation').classList.add('border-gray-300');
                        submitBtn.disabled = false;
                        
                        // Remove error message
                        const errorMsg = document.getElementById('password-match-error');
                        if (errorMsg) {
                            errorMsg.remove();
                        }
                    }
                }
            }

            // Add event listener for confirm password
            document.getElementById('password_confirmation').addEventListener('input', validatePasswordMatch);

            // Set max date for date of birth (17 years ago)
            document.addEventListener('DOMContentLoaded', function() {
                const today = new Date();
                const minDate = new Date(today.getFullYear() - 17, today.getMonth(), today.getDate());
                document.getElementById('tanggal_lahir').max = minDate.toISOString().split('T')[0];

                // Check if there's a previously uploaded file (on form error)
                if (fileInput.files.length > 0) {
                    handleFiles(fileInput.files);
                }
            });

            // Form validation before submit
            document.getElementById('registerForm').addEventListener('submit', function(e) {
                const submitBtn = document.getElementById('submitBtn');
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('password_confirmation').value;
                
                // Check password match
                if (password !== confirmPassword) {
                    e.preventDefault();
                    alert('Password dan konfirmasi password tidak cocok');
                    return;
                }

                // Check if file is uploaded
                if (!fileInput.files.length) {
                    e.preventDefault();
                    alert('Silakan upload foto KTP terlebih dahulu');
                    return;
                }
                
                // Disable submit button to prevent double submission
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-3"></i>Memproses...';
            });
        </script>
    </body>
</html>