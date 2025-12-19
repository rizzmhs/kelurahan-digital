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
            
            .font-poppins { font-family: 'Poppins', sans-serif; }
            .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
            .gradient-text { 
                background: linear-gradient(90deg, #667eea, #764ba2);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
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
                outline: none;
            }
            
            /* Checkmark Animation */
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
                100% { stroke-dashoffset: 0; }
            }
            
            @keyframes scale {
                0%, 100% { transform: none; }
                50% { transform: scale3d(1.1, 1.1, 1); }
            }
            
            @keyframes fill {
                100% { box-shadow: inset 0px 0px 0px 30px #10b981; }
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
            
            /* Animation for fade in */
            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            .animate-fadeIn {
                animation: fadeIn 0.3s ease-out;
            }
            
            [x-cloak] { 
                display: none !important; 
            }
        </style>
    </head>
    <body class="font-poppins antialiased bg-gradient-to-br from-blue-50 to-purple-50 min-h-screen" 
          x-data="registerPage()" 
          x-init="init()">
        
        <!-- Navigation -->
        <nav class="fixed w-full z-40 bg-white/95 backdrop-blur-md shadow-sm" 
             :class="{ 'shadow-md': scrolled }"
             x-data="{ scrolled: false }" 
             @scroll.window="scrolled = window.scrollY > 20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16 md:h-20">
                    <!-- Logo -->
                    <div class="flex items-center space-x-3">
                        <a href="{{ url('/') }}" class="flex items-center space-x-3 no-underline">
                            <div class="bg-gradient-to-br from-blue-600 to-purple-600 p-2 md:p-3 rounded-xl shadow-sm">
                                <i class="fas fa-landmark text-white text-xl md:text-2xl"></i>
                            </div>
                            <div>
                                <h1 class="text-lg md:text-xl font-bold text-gray-900">Kelurahan<span class="text-yellow-300">Digital</span></h1>
                                <p class="text-xs text-gray-500 hidden md:block">Sistem Layanan Terpadu</p>
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
                           class="text-gray-700 hover:text-blue-600 font-medium px-3 md:px-4 py-2 text-sm md:text-base transition-colors duration-200">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            <span class="hidden md:inline">Masuk</span>
                        </a>
                        <a href="{{ route('register') }}" 
                           class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-4 md:px-6 py-2 md:py-3 rounded-full font-semibold text-sm md:text-base hover:shadow-lg transition-all duration-200 hover:scale-105">
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
                <div class="grid lg:grid-cols-2 gap-8 md:gap-12 items-start">
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
                                        <i class="fas fa-shield-alt mr-2"></i>Keamanan Terjamin
                                    </span>
                                </div>
                                
                                <h2 class="text-2xl md:text-3xl font-bold mb-6 leading-tight">
                                    Bergabung dengan
                                    <span class="text-yellow-300">1.250+</span>
                                    Warga Terdaftar
                                </h2>
                                
                                <p class="text-base md:text-lg text-blue-100 mb-8 leading-relaxed">
                                    Daftarkan diri Anda untuk mengakses semua layanan digital kelurahan secara lengkap dan terintegrasi.
                                </p>
                                
                                <!-- Features List -->
                                <div class="space-y-4 md:space-y-6 mb-8">
                                    <div class="flex items-start">
                                        <div class="bg-white/20 p-3 rounded-xl mr-3 md:mr-4 flex-shrink-0">
                                            <i class="fas fa-bolt text-yellow-300 text-lg"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-base md:text-lg">Proses Cepat</h4>
                                            <p class="text-blue-100 text-sm md:text-base">Pengurusan surat 2x lebih cepat dari cara konvensional</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-start">
                                        <div class="bg-white/20 p-3 rounded-xl mr-3 md:mr-4 flex-shrink-0">
                                            <i class="fas fa-chart-line text-green-300 text-lg"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-base md:text-lg">Tracking Real-time</h4>
                                            <p class="text-blue-100 text-sm md:text-base">Pantau perkembangan layanan kapan saja, di mana saja</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-start">
                                        <div class="bg-white/20 p-3 rounded-xl mr-3 md:mr-4 flex-shrink-0">
                                            <i class="fas fa-bell text-red-300 text-lg"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-base md:text-lg">Notifikasi Otomatis</h4>
                                            <p class="text-blue-100 text-sm md:text-base">Dapatkan pemberitahuan via WhatsApp & Email</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Stats -->
                                <div class="grid grid-cols-3 gap-4 text-center">
                                    <div class="bg-white/10 rounded-xl p-4">
                                        <div class="text-2xl font-bold">98%</div>
                                        <div class="text-sm text-blue-200">Kepuasan</div>
                                    </div>
                                    <div class="bg-white/10 rounded-xl p-4">
                                        <div class="text-2xl font-bold">24/7</div>
                                        <div class="text-sm text-blue-200">Akses</div>
                                    </div>
                                    <div class="bg-white/10 rounded-xl p-4">
                                        <div class="text-2xl font-bold">0</div>
                                        <div class="text-sm text-blue-200">Biaya</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Registration Form -->
                    <div class="bg-white rounded-2xl md:rounded-3xl shadow-xl overflow-hidden card-hover">
                        <div class="p-6 md:p-8">
                            <!-- Header -->
                            <div class="text-center mb-6 md:mb-8">
                                <div class="w-14 h-14 md:w-16 md:h-16 bg-gradient-to-br from-blue-600 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-3 md:mb-4">
                                    <i class="fas fa-user-plus text-white text-xl md:text-2xl"></i>
                                </div>
                                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">
                                    Buat Akun <span class="gradient-text">Baru</span>
                                </h1>
                                <p class="text-gray-600 text-sm md:text-base">
                                    Isi data diri dengan lengkap untuk proses verifikasi
                                </p>
                            </div>

                            <!-- Error Messages -->
                            @if ($errors->any())
                                <div class="mb-4 md:mb-6 p-3 md:p-4 bg-red-50 border border-red-200 rounded-xl animate-fadeIn">
                                    <div class="flex items-start">
                                        <i class="fas fa-exclamation-circle text-red-500 mr-2 md:mr-3 mt-0.5"></i>
                                        <div class="flex-1">
                                            <span class="text-red-700 font-medium">Terjadi kesalahan:</span>
                                            <ul class="mt-1 text-sm text-red-600 space-y-0.5">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Form -->
                            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" 
                                  id="registerForm" class="space-y-4 md:space-y-6" @submit.prevent="submitForm">
                                @csrf

                                <!-- Name & NIK -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                                    <div class="space-y-2">
                                        <label for="name" class="block text-sm font-medium text-gray-700">
                                            <i class="fas fa-user mr-2 text-gray-500"></i>Nama Lengkap *
                                        </label>
                                        <input type="text" id="name" name="name" value="{{ old('name') }}" 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input-custom text-sm md:text-base"
                                               required autofocus autocomplete="name"
                                               placeholder="Masukkan nama lengkap">
                                    </div>

                                    <div class="space-y-2">
                                        <label for="nik" class="block text-sm font-medium text-gray-700">
                                            <i class="fas fa-id-card mr-2 text-gray-500"></i>NIK *
                                        </label>
                                        <input type="text" id="nik" name="nik" value="{{ old('nik') }}"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input-custom text-sm md:text-base"
                                               required maxlength="16" minlength="16" pattern="[0-9]{16}"
                                               placeholder="Masukkan 16 digit NIK"
                                               x-on:input="$event.target.value = $event.target.value.replace(/[^0-9]/g, '')">
                                        <p class="text-xs text-gray-500 mt-1">16 digit angka tanpa huruf dan spasi</p>
                                    </div>
                                </div>

                                <!-- Email & Telepon -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                                    <div class="space-y-2">
                                        <label for="email" class="block text-sm font-medium text-gray-700">
                                            <i class="fas fa-envelope mr-2 text-gray-500"></i>Email *
                                        </label>
                                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input-custom text-sm md:text-base"
                                               required autocomplete="email"
                                               placeholder="Masukkan alamat email">
                                    </div>

                                    <div class="space-y-2">
                                        <label for="telepon" class="block text-sm font-medium text-gray-700">
                                            <i class="fas fa-phone mr-2 text-gray-500"></i>Nomor Telepon *
                                        </label>
                                        <input type="tel" id="telepon" name="telepon" value="{{ old('telepon') }}"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input-custom text-sm md:text-base"
                                               required pattern="[0-9]{10,13}"
                                               placeholder="Masukkan nomor telepon"
                                               x-on:input="$event.target.value = $event.target.value.replace(/[^0-9]/g, '')">
                                        <p class="text-xs text-gray-500 mt-1">10-13 digit angka</p>
                                    </div>
                                </div>

                                <!-- Date of Birth & Gender -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                                    <div class="space-y-2">
                                        <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">
                                            <i class="fas fa-calendar-alt mr-2 text-gray-500"></i>Tanggal Lahir *
                                        </label>
                                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input-custom text-sm md:text-base"
                                               required :max="maxDate">
                                        <p class="text-xs text-gray-500 mt-1">Minimal usia 17 tahun</p>
                                    </div>

                                    <div class="space-y-2">
                                        <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">
                                            <i class="fas fa-venus-mars mr-2 text-gray-500"></i>Jenis Kelamin *
                                        </label>
                                        <select id="jenis_kelamin" name="jenis_kelamin"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input-custom text-sm md:text-base bg-white"
                                                required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Address -->
                                <div class="space-y-2">
                                    <label for="alamat" class="block text-sm font-medium text-gray-700">
                                        <i class="fas fa-map-marker-alt mr-2 text-gray-500"></i>Alamat Lengkap *
                                    </label>
                                    <textarea id="alamat" name="alamat" rows="3"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input-custom text-sm md:text-base resize-y min-h-[100px]"
                                            required
                                            placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                                </div>

                                <!-- KTP Photo Upload -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">
                                        <i class="fas fa-camera mr-2 text-gray-500"></i>Foto KTP *
                                    </label>
                                    
                                    <!-- Upload States -->
                                    <div x-show="uploadState === 'default'" x-cloak
                                         x-on:click="$refs.fileInput.click()"
                                         x-on:dragenter.prevent="handleDragEnter"
                                         x-on:dragover.prevent="handleDragEnter" 
                                         x-on:dragleave.prevent="handleDragLeave"
                                         x-on:drop.prevent="handleDrop($event)"
                                         class="flex justify-center px-6 pt-6 pb-6 md:pt-8 md:pb-8 border-2 border-dashed border-gray-300 rounded-xl hover:border-blue-500 transition-all duration-300 cursor-pointer bg-white"
                                         :class="{ 'border-blue-500 bg-blue-50': isDragging }">
                                        <div class="space-y-3 text-center">
                                            <div class="flex justify-center">
                                                <div class="w-14 h-14 md:w-16 md:h-16 bg-gradient-to-br from-blue-100 to-blue-50 rounded-full flex items-center justify-center">
                                                    <i class="fas fa-cloud-upload-alt text-blue-400 text-xl md:text-2xl"></i>
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
                                        </div>
                                    </div>

                                    <!-- Success State -->
                                    <div x-show="uploadState === 'success'" x-cloak
                                         class="flex justify-center px-6 pt-6 pb-6 md:pt-8 md:pb-8 border-2 border-dashed border-green-500 rounded-xl bg-green-50 animate-fadeIn">
                                        <div class="space-y-4 text-center">
                                            <div class="flex justify-center">
                                                <div class="relative">
                                                    <div class="w-16 h-16 md:w-20 md:h-20 bg-green-100 rounded-full flex items-center justify-center">
                                                        <i class="fas fa-check text-green-600 text-xl md:text-2xl"></i>
                                                    </div>
                                                    <div class="absolute -top-1 -right-1 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                                        <i class="fas fa-check text-white text-xs"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="space-y-1">
                                                <p class="text-sm font-medium text-green-700">File berhasil diupload!</p>
                                                <p class="text-xs text-green-600" x-text="uploadedFileName"></p>
                                                <p class="text-xs text-green-500" x-text="uploadedFileSize"></p>
                                            </div>
                                            <div>
                                                <button type="button" x-on:click="removeFile()" 
                                                        class="text-xs text-red-600 hover:text-red-800 font-medium">
                                                    <i class="fas fa-trash-alt mr-1"></i> Hapus file
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Error State -->
                                    <div x-show="uploadState === 'error'" x-cloak
                                         class="flex justify-center px-6 pt-6 pb-6 md:pt-8 md:pb-8 border-2 border-dashed border-red-300 rounded-xl bg-red-50 animate-fadeIn">
                                        <div class="space-y-3 text-center">
                                            <div class="flex justify-center">
                                                <div class="w-14 h-14 md:w-16 md:h-16 bg-gradient-to-br from-red-100 to-red-50 rounded-full flex items-center justify-center">
                                                    <i class="fas fa-exclamation-triangle text-red-400 text-xl md:text-2xl"></i>
                                                </div>
                                            </div>
                                            <div class="space-y-1">
                                                <p class="text-sm font-medium text-red-700" x-text="uploadError"></p>
                                                <p class="text-xs text-red-500">Silakan upload file yang sesuai</p>
                                            </div>
                                            <button type="button" x-on:click="retryUpload()" 
                                                    class="text-xs text-blue-600 hover:text-blue-800 font-medium">
                                                <i class="fas fa-redo mr-1"></i> Coba lagi
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Hidden File Input -->
                                    <input type="file" id="foto_ktp" name="foto_ktp" x-ref="fileInput" 
                                           accept=".jpg,.jpeg,.png,.pdf" class="hidden" required
                                           x-on:change="handleFileSelect($event)">
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Pastikan foto KTP jelas dan dapat dibaca</p>

                                <!-- Password -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                                    <div class="space-y-2">
                                        <label for="password" class="block text-sm font-medium text-gray-700">
                                            <i class="fas fa-lock mr-2 text-gray-500"></i>Password *
                                        </label>
                                        <div class="relative">
                                            <input :type="showPassword ? 'text' : 'password'" id="password" name="password"
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input-custom text-sm md:text-base pr-10"
                                                   required autocomplete="new-password"
                                                   placeholder="Masukkan password"
                                                   x-on:input="checkPasswordStrength($event.target.value)">
                                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600"
                                                    x-on:click="showPassword = !showPassword">
                                                <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                                            </button>
                                        </div>
                                        <div id="password-strength" class="text-sm" x-html="passwordStrengthText"></div>
                                    </div>

                                    <div class="space-y-2">
                                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                                            <i class="fas fa-lock mr-2 text-gray-500"></i>Konfirmasi Password *
                                        </label>
                                        <div class="relative">
                                            <input :type="showConfirmPassword ? 'text' : 'password'" id="password_confirmation" name="password_confirmation"
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input-custom text-sm md:text-base pr-10"
                                                   required autocomplete="new-password"
                                                   placeholder="Konfirmasi password"
                                                   :class="{ 'border-red-500': passwordMismatch && passwordConfirmInput }"
                                                   x-on:input="checkPasswordMatch()">
                                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600"
                                                    x-on:click="showConfirmPassword = !showConfirmPassword">
                                                <i class="fas" :class="showConfirmPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                                            </button>
                                        </div>
                                        <p x-show="passwordMismatch && passwordConfirmInput" x-cloak 
                                           class="text-sm text-red-600 animate-fadeIn">Password tidak cocok</p>
                                    </div>
                                </div>

                                <!-- Terms -->
                                <div class="flex items-start">
                                    <div class="flex items-center h-5 mt-0.5">
                                        <input id="terms" name="terms" type="checkbox" 
                                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 focus:ring-offset-0"
                                               required {{ old('terms') ? 'checked' : '' }}>
                                    </div>
                                    <label for="terms" class="ml-2 text-sm text-gray-700 select-none">
                                        Saya menyetujui 
                                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Syarat & Ketentuan</a> 
                                        dan 
                                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Kebijakan Privasi</a>
                                    </label>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" id="submitBtn"
                                        class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 md:py-4 px-6 rounded-lg font-semibold text-base md:text-lg hover:shadow-lg transition-all duration-200 hover:scale-[1.02] active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed"
                                        :disabled="!formValid || isSubmitting">
                                    <i class="fas mr-3" :class="isSubmitting ? 'fa-spinner fa-spin' : 'fa-user-plus'"></i>
                                    <span x-text="isSubmitting ? 'Memproses...' : 'Daftar Akun'"></span>
                                </button>

                                <!-- Login Link -->
                                <div class="text-center mt-6 md:mt-8 pt-4 md:pt-6 border-t border-gray-200">
                                    <p class="text-gray-600 text-sm md:text-base mb-2">
                                        Sudah punya akun?
                                        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-semibold ml-1 transition-colors">
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

        <!-- Footer -->
        @include('partials.footer-with-modals')

        <!-- JavaScript -->
        <script>
            function registerPage() {
                return {
                    // States
                    showPassword: false,
                    showConfirmPassword: false,
                    uploadState: 'default',
                    isDragging: false,
                    showPulse: false,
                    uploadedFileName: '',
                    uploadedFileSize: '',
                    uploadError: '',
                    passwordStrength: 0,
                    passwordStrengthText: '',
                    passwordMismatch: false,
                    passwordConfirmInput: false,
                    isSubmitting: false,
                    formValid: false,
                    
                    // Computed properties
                    maxDate: new Date(new Date().setFullYear(new Date().getFullYear() - 17)).toISOString().split('T')[0],
                    
                    // Initialize
                    init() {
                        this.initScrollHandler();
                        this.watchFormValidity();
                        
                        // Check if there's a previously uploaded file (on form error)
                        const fileInput = this.$refs.fileInput;
                        if (fileInput && fileInput.files.length > 0) {
                            this.handleFiles(fileInput.files);
                        }
                    },
                    
                    initScrollHandler() {
                        window.addEventListener('scroll', () => {
                            const scrolled = window.scrollY > 20;
                            // Update scrolled state in the Alpine.js component for nav
                            if (window.Alpine) {
                                const navComponent = window.Alpine.evaluate(document.querySelector('nav'), '$data');
                                if (navComponent) {
                                    navComponent.scrolled = scrolled;
                                }
                            }
                        });
                    },
                    
                    // Upload handlers
                    handleDragEnter() {
                        this.isDragging = true;
                    },
                    
                    handleDragLeave() {
                        this.isDragging = false;
                    },
                    
                    handleDrop(e) {
                        this.isDragging = false;
                        const files = e.dataTransfer.files;
                        this.handleFiles(files);
                    },
                    
                    handleFileSelect(e) {
                        this.handleFiles(e.target.files);
                    },
                    
                    handleFiles(files) {
                        const file = files[0];
                        if (!file) return;
                        
                        const maxSize = 2 * 1024 * 1024; // 2MB
                        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
                        
                        // Validate file
                        if (!allowedTypes.includes(file.type)) {
                            this.uploadState = 'error';
                            this.uploadError = 'Format file tidak didukung. Harap upload JPG, JPEG, PNG, atau PDF.';
                            this.$refs.fileInput.value = '';
                            return;
                        }
                        
                        if (file.size > maxSize) {
                            this.uploadState = 'error';
                            this.uploadError = 'Ukuran file terlalu besar. Maksimal 2MB.';
                            this.$refs.fileInput.value = '';
                            return;
                        }
                        
                        // Show success state
                        this.uploadState = 'success';
                        this.uploadedFileName = file.name;
                        this.uploadedFileSize = `(${(file.size / 1024 / 1024).toFixed(2)} MB)`;
                        
                        // Add pulse animation
                        this.showPulse = true;
                        setTimeout(() => {
                            this.showPulse = false;
                        }, 4000);
                        
                        // Re-check form validity
                        this.watchFormValidity();
                    },
                    
                    removeFile() {
                        this.$refs.fileInput.value = '';
                        this.uploadState = 'default';
                        this.showPulse = false;
                        this.watchFormValidity();
                    },
                    
                    retryUpload() {
                        this.uploadState = 'default';
                        this.$refs.fileInput.click();
                    },
                    
                    // Password handlers
                    checkPasswordStrength(password) {
                        let strength = 0;
                        const messages = ['Sangat lemah', 'Lemah', 'Cukup', 'Kuat', 'Sangat kuat'];
                        const colors = ['text-red-600', 'text-orange-600', 'text-yellow-600', 'text-blue-600', 'text-green-600'];
                        const icons = ['fas fa-times-circle', 'fas fa-exclamation-triangle', 'fas fa-check-circle', 'fas fa-thumbs-up', 'fas fa-shield-alt'];
                        
                        if (password.length >= 8) strength++;
                        if (/[A-Z]/.test(password)) strength++;
                        if (/[0-9]/.test(password)) strength++;
                        if (/[^A-Za-z0-9]/.test(password)) strength++;
                        
                        this.passwordStrength = strength;
                        this.passwordStrengthText = `
                            <i class="${icons[strength]} mr-2"></i>
                            <span class="${colors[strength]}">Kekuatan password: ${messages[strength]}</span>
                        `;
                        
                        this.checkPasswordMatch();
                        this.watchFormValidity();
                    },
                    
                    checkPasswordMatch() {
                        const password = document.getElementById('password')?.value || '';
                        const confirmPassword = document.getElementById('password_confirmation')?.value || '';
                        
                        this.passwordConfirmInput = !!confirmPassword;
                        this.passwordMismatch = confirmPassword && password !== confirmPassword;
                        this.watchFormValidity();
                    },
                    
                    // Form validation
                    watchFormValidity() {
                        const password = document.getElementById('password')?.value || '';
                        const confirmPassword = document.getElementById('password_confirmation')?.value || '';
                        const hasFile = this.$refs.fileInput?.files?.length > 0;
                        const termsChecked = document.getElementById('terms')?.checked;
                        
                        this.formValid = password && 
                                         !this.passwordMismatch && 
                                         hasFile && 
                                         termsChecked &&
                                         this.passwordStrength >= 2; // At least "Cukup"
                    },
                    
                    submitForm(e) {
                        e.preventDefault();
                        
                        const password = document.getElementById('password')?.value || '';
                        const confirmPassword = document.getElementById('password_confirmation')?.value || '';
                        const hasFile = this.$refs.fileInput?.files?.length > 0;
                        
                        // Check password match
                        if (password !== confirmPassword) {
                            this.showErrorAlert('Password dan konfirmasi password tidak cocok');
                            return;
                        }
                        
                        // Check if file is uploaded
                        if (!hasFile) {
                            this.showErrorAlert('Silakan upload foto KTP terlebih dahulu');
                            return;
                        }
                        
                        // Check password strength
                        if (this.passwordStrength < 2) {
                            this.showErrorAlert('Password terlalu lemah. Gunakan minimal 8 karakter dengan kombinasi huruf besar, angka, dan simbol.');
                            return;
                        }
                        
                        // Check terms
                        const terms = document.getElementById('terms');
                        if (!terms.checked) {
                            this.showErrorAlert('Harap setujui Syarat & Ketentuan dan Kebijakan Privasi');
                            return;
                        }
                        
                        // Prevent double submission
                        this.isSubmitting = true;
                        
                        // Submit the form
                        setTimeout(() => {
                            document.getElementById('registerForm').submit();
                        }, 300);
                    },
                    
                    // Alert utilities
                    showErrorAlert(message) {
                        const alertDiv = document.createElement('div');
                        alertDiv.className = 'fixed top-4 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-md px-4 animate-fadeIn';
                        alertDiv.innerHTML = `
                            <div class="bg-red-50 border border-red-200 rounded-xl p-4 shadow-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-exclamation-circle text-red-500 text-lg mr-3"></i>
                                    <p class="text-sm font-medium text-red-800 flex-1">${message}</p>
                                    <button onclick="this.parentElement.parentElement.remove()" 
                                            class="text-red-400 hover:text-red-600 ml-3">
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