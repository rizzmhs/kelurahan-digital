<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-black-200 leading-tight">
                    <i class="fas fa-user-edit mr-2 text-blue-600"></i>Lengkapi Profil Anda
                </h2>
                @if($user->is_warga)
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Data profil Anda saat ini: <span class="font-medium {{ $isProfileComplete ? 'text-green-600' : 'text-yellow-600' }}">{{ $completionPercentage ?? 0 }}% Lengkap</span>
                    </p>
                @endif
            </div>
            <div class="text-sm text-gray-500 dark:text-gray-400">
                {{ now()->translatedFormat('l, d F Y') }}
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            

            <!-- Google User Alert -->
            @if($user->google_id && !$isProfileComplete)
            <div class="mb-8 bg-gradient-to-r from-blue-400 to-blue-500 rounded-lg shadow-lg text-white overflow-hidden hover:shadow-xl transition duration-300">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-500/30 rounded-full mr-4 backdrop-blur-sm">
                            <i class="fab fa-google text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold mb-2">Anda login dengan Google</h3>
                            <p class="text-blue-100">
                                Silakan lengkapi data profil Anda untuk menggunakan Sistem Layanan Kelurahan secara penuh.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column: Profile Form -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Update Profile Information -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 flex items-center">
                                <i class="fas fa-user-edit text-blue-500 mr-2"></i>
                                Informasi Profil
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Lengkapi data diri Anda untuk dapat mengakses semua fitur sistem.
                            </p>
                        </div>
                        <div class="p-6">
                            <!-- Profile Form -->
                            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                                @csrf
                            </form>

                            <form method="post" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data" id="profile-form">
                                @csrf
                                @method('patch')

                                <!-- Grid for form fields -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Name -->
                                    <div class="md:col-span-2">
                                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 required-field">
                                            Nama Lengkap
                                        </label>
                                        <input id="name" name="name" type="text" 
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                            value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                                        @error('name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="md:col-span-2">
                                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 required-field">
                                            Email
                                        </label>
                                        <input id="email" name="email" type="email" 
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                            value="{{ old('email', $user->email) }}" required autocomplete="username">
                                        @error('email')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- NIK -->
                                    <div>
                                        <label for="nik" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 required-field">
                                            NIK
                                        </label>
                                        @if(empty($user->nik))
                                            <input id="nik" name="nik" type="text" 
                                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                                value="{{ old('nik') }}" required>
                                            @error('nik')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                                <i class="fas fa-info-circle mr-1"></i>NIK 16 digit. Hanya bisa diisi sekali.
                                            </p>
                                        @else
                                            <input id="nik" type="text" 
                                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-600 dark:text-gray-300 rounded-lg cursor-not-allowed"
                                                value="{{ $user->nik }}" readonly disabled>
                                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                                <i class="fas fa-lock mr-1"></i>NIK tidak dapat diubah.
                                            </p>
                                        @endif
                                    </div>

                                    <!-- Telepon -->
                                    <div>
                                        <label for="telepon" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 required-field">
                                            Nomor Telepon
                                        </label>
                                        <input id="telepon" name="telepon" type="tel" 
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                            value="{{ old('telepon', $user->telepon) }}" required>
                                        @error('telepon')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Tanggal Lahir -->
                                    <div>
                                        <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 required-field">
                                            Tanggal Lahir
                                        </label>
                                        <input id="tanggal_lahir" name="tanggal_lahir" type="date" 
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                            value="{{ old('tanggal_lahir', $user->tanggal_lahir?->format('Y-m-d')) }}" required>
                                        @error('tanggal_lahir')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                            <i class="fas fa-birthday-cake mr-1"></i>Minimal usia 17 tahun.
                                        </p>
                                    </div>

                                    <!-- Jenis Kelamin -->
                                    <div>
                                        <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 required-field">
                                            Jenis Kelamin
                                        </label>
                                        <select id="jenis_kelamin" name="jenis_kelamin" 
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="L" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="P" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                        @error('jenis_kelamin')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Alamat -->
                                    <div class="md:col-span-2">
                                        <label for="alamat" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 required-field">
                                            Alamat Lengkap
                                        </label>
                                        <textarea id="alamat" name="alamat" rows="3" 
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" required>{{ old('alamat', $user->alamat) }}</textarea>
                                        @error('alamat')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Foto KTP saat ini -->
                                    @if($user->foto_ktp)
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            <i class="fas fa-id-card mr-2"></i>Foto KTP Saat Ini
                                        </label>
                                        <div class="mt-1 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                                            @if(str_ends_with($user->foto_ktp, '.pdf'))
                                            <div class="flex items-center">
                                                <div class="p-3 bg-red-100 dark:bg-red-900/30 rounded-lg mr-4">
                                                    <i class="fas fa-file-pdf text-red-500 text-xl"></i>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">File KTP (PDF)</p>
                                                    <a href="{{ Storage::url($user->foto_ktp) }}" target="_blank" 
                                                       class="inline-flex items-center text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 mt-1">
                                                        <i class="fas fa-external-link-alt mr-1"></i> Lihat PDF
                                                    </a>
                                                </div>
                                            </div>
                                            @else
                                            <div class="flex items-center">
                                                <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-lg mr-4">
                                                    <i class="fas fa-image text-blue-500 text-xl"></i>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Foto KTP</p>
                                                    <a href="{{ Storage::url($user->foto_ktp) }}" target="_blank" 
                                                       class="inline-flex items-center text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 mt-1">
                                                        <i class="fas fa-external-link-alt mr-1"></i> Lihat Gambar
                                                    </a>
                                                </div>
                                            </div>
                                            @endif
                                            <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">
                                                <i class="fas fa-info-circle mr-1"></i>Unggah file baru hanya jika ingin mengganti.
                                            </p>
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Foto KTP Baru -->
                                    <div class="md:col-span-2">
                                        <label for="foto_ktp" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 {{ !$user->foto_ktp ? 'required-field' : '' }}">
                                            <i class="fas fa-upload mr-2"></i>Foto KTP {{ $user->foto_ktp ? 'Baru (Opsional)' : '' }}
                                        </label>
                                        <div class="mt-1">
                                            <input id="foto_ktp" name="foto_ktp" type="file" 
                                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition duration-200"
                                                accept=".jpg,.jpeg,.png,.pdf" {{ !$user->foto_ktp ? 'required' : '' }}>
                                        </div>
                                        @error('foto_ktp')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        <div class="mt-2 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">
                                                <i class="fas fa-info-circle mr-1"></i>Persyaratan:
                                            </p>
                                            <ul class="text-sm text-gray-500 dark:text-gray-400 space-y-1">
                                                <li class="flex items-start">
                                                    <i class="fas fa-check text-green-500 mr-2 mt-0.5 text-xs"></i>
                                                    Format: JPG, PNG, atau PDF
                                                </li>
                                                <li class="flex items-start">
                                                    <i class="fas fa-check text-green-500 mr-2 mt-0.5 text-xs"></i>
                                                    Ukuran maksimal: 2MB
                                                </li>
                                                <li class="flex items-start">
                                                    <i class="fas fa-check text-green-500 mr-2 mt-0.5 text-xs"></i>
                                                    Pastikan foto jelas dan terbaca
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="flex items-center gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                    <button type="submit" 
                                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200"
                                            id="submit-button">
                                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                                    </button>

                                    @if (session('status') === 'profile-updated')
                                        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)">
                                            <div class="inline-flex items-center px-4 py-2 bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-lg">
                                                <i class="fas fa-check-circle mr-2"></i>
                                                {{ __('Profile berhasil diperbarui.') }}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Profile Summary & Info -->
                <div class="space-y-6">
                    <!-- Profile Completion Status -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 flex items-center">
                                <i class="fas fa-chart-pie text-purple-500 mr-2"></i>
                                Status Profil
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="text-center mb-4">
                                <div class="relative inline-flex items-center justify-center">
                                    <svg class="w-32 h-32">
                                        <circle class="text-gray-200 dark:text-gray-700" stroke-width="10" stroke="currentColor" fill="transparent" r="56" cx="64" cy="64"/>
                                        <circle class="text-{{ $isProfileComplete ? 'green' : 'yellow' }}-500" stroke-width="10" stroke-linecap="round" stroke="currentColor" fill="transparent" r="56" cx="64" cy="64" stroke-dasharray="{{ $completionPercentage * 3.51 }} 351"/>
                                    </svg>
                                    <div class="absolute text-3xl font-bold text-gray-900 dark:text-gray-100">
                                        {{ $completionPercentage }}%
                                    </div>
                                </div>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $isProfileComplete ? 'Profil Lengkap!' : 'Perlu dilengkapi' }}
                                </p>
                            </div>
                            
                            @if($user->is_warga && !$isProfileComplete)
                            <div class="mt-6">
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-bolt text-yellow-500 mr-2"></i>
                                    Manfaat profil lengkap:
                                </p>
                                <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-2 text-xs"></i>
                                        Akses penuh ke dashboard
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-2 text-xs"></i>
                                        Pengajuan surat lebih cepat
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-2 text-xs"></i>
                                        Notifikasi status real-time
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-2 text-xs"></i>
                                        Prioritas penanganan
                                    </li>
                                </ul>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- User Information -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 flex items-center">
                                <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                                Info Akun
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3 text-sm">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Nama:</span>
                                    <span class="font-medium text-gray-900 dark:text-gray-100">{{ $user->name }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Email:</span>
                                    <span class="font-medium text-gray-900 dark:text-gray-100">{{ $user->email }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Role:</span>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ 
                                        $user->role == 'admin' ? 'badge-admin' : 
                                        ($user->role == 'petugas' ? 'badge-petugas' : 'badge-warga') 
                                    }}">
                                        <i class="fas fa-user-tag mr-1"></i>
                                        {{ ucfirst($user->role ?? 'warga') }}
                                    </span>
                                </div>
                                @if($user->google_id)
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Login dengan:</span>
                                    <span class="font-medium text-blue-600">
                                        <i class="fab fa-google mr-1"></i>Google
                                    </span>
                                </div>
                                @endif
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Bergabung:</span>
                                    <span class="font-medium text-gray-900 dark:text-gray-100">
                                        {{ $user->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                @if($user->email_verified_at)
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Verifikasi Email:</span>
                                    <span class="font-medium text-green-600">
                                        <i class="fas fa-check-circle mr-1"></i>Terverifikasi
                                    </span>
                                </div>
                                @endif
                                @if($user->foto_ktp)
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">KTP:</span>
                                    <span class="font-medium text-green-600">
                                        <i class="fas fa-check-circle mr-1"></i>Tersedia
                                    </span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Quick Tips -->
                    @if(!$isProfileComplete)
                    <div class="bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 border border-blue-200 dark:border-blue-800 rounded-lg shadow-sm p-6">
                        <h4 class="font-medium text-blue-800 dark:text-blue-300 mb-3 flex items-center">
                            <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                            Tips Cepat
                        </h4>
                        <ul class="space-y-2 text-sm text-blue-700 dark:text-blue-400">
                            <li class="flex items-start">
                                <i class="fas fa-check text-green-500 mr-2 mt-0.5"></i>
                                Isi semua kolom yang wajib diisi (*)
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check text-green-500 mr-2 mt-0.5"></i>
                                Upload foto KTP untuk verifikasi cepat
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check text-green-500 mr-2 mt-0.5"></i>
                                Pastikan data sesuai dokumen resmi
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check text-green-500 mr-2 mt-0.5"></i>
                                Periksa kembali data sebelum disimpan
                            </li>
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .progress-bar {
            transition: width 0.6s ease;
        }
        
        /* Animation for progress circle */
        @keyframes dash {
            from {
                stroke-dasharray: 0 351;
            }
        }
        
        circle {
            animation: dash 1.5s ease-in-out;
        }
        
        /* Form styling */
        input, select, textarea {
            transition: all 0.2s ease;
        }
        
        input:focus, select:focus, textarea:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        /* Required field indicator */
        .required-field::after {
            content: ' *';
            color: #ef4444;
        }
        
        /* Hover effects for cards */
        .hover-shadow-lg {
            transition: all 0.3s ease;
        }
        
        .hover-shadow-lg:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        /* Badge styles from app layout */
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
        
        /* File input styling */
        input[type="file"]::-webkit-file-upload-button {
            cursor: pointer;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .grid-cols-1 {
                grid-template-columns: 1fr;
            }
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animate progress bar
            const progressBar = document.querySelector('.progress-bar');
            if (progressBar) {
                const width = progressBar.style.width;
                progressBar.style.width = '0';
                setTimeout(() => {
                    progressBar.style.width = width;
                }, 300);
            }
            
            // Real-time validation feedback
            const formInputs = document.querySelectorAll('#profile-form input[required], #profile-form select[required], #profile-form textarea[required]');
            formInputs.forEach(input => {
                input.addEventListener('blur', function() {
                    validateField(this);
                });
                
                input.addEventListener('input', function() {
                    if (this.value.trim() !== '') {
                        this.classList.remove('border-red-300', 'border-red-500');
                        this.classList.add('border-green-300', 'dark:border-green-500');
                    }
                });
            });
            
            // Validate individual field
            function validateField(field) {
                if (field.value.trim() === '') {
                    field.classList.add('border-red-300', 'dark:border-red-500');
                    field.classList.remove('border-green-300', 'dark:border-green-500');
                } else {
                    field.classList.remove('border-red-300', 'dark:border-red-500');
                    field.classList.add('border-green-300', 'dark:border-green-500');
                }
            }
            
            // Form submission feedback
            const form = document.getElementById('profile-form');
            const submitBtn = document.getElementById('submit-button');
            
            if (form && submitBtn) {
                form.addEventListener('submit', function(e) {
                    // Validate required fields
                    let isValid = true;
                    const requiredFields = this.querySelectorAll('[required]');
                    
                    requiredFields.forEach(field => {
                        validateField(field);
                        if (field.value.trim() === '') {
                            isValid = false;
                        }
                    });
                    
                    if (!isValid) {
                        e.preventDefault();
                        
                        // Show error message
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'mt-4 p-4 bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded-lg border border-red-200 dark:border-red-800';
                        errorDiv.innerHTML = `
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle mr-3"></i>
                                <span>Harap lengkapi semua kolom yang wajib diisi.</span>
                            </div>
                        `;
                        
                        // Remove existing error message if any
                        const existingError = document.querySelector('.form-error-message');
                        if (existingError) {
                            existingError.remove();
                        }
                        
                        errorDiv.classList.add('form-error-message');
                        form.insertBefore(errorDiv, form.firstChild);
                        
                        // Scroll to error message
                        errorDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        
                        return;
                    }
                    
                    // Change button state
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
                    submitBtn.disabled = true;
                });
            }
            
            // NIK validation
            const nikInput = document.getElementById('nik');
            if (nikInput && !nikInput.disabled) {
                nikInput.addEventListener('input', function(e) {
                    const value = e.target.value.replace(/\D/g, '');
                    e.target.value = value;
                    
                    // Show validation message
                    if (value.length === 16) {
                        this.classList.remove('border-red-300', 'dark:border-red-500');
                        this.classList.add('border-green-300', 'dark:border-green-500');
                    } else if (value.length > 0 && value.length !== 16) {
                        this.classList.add('border-red-300', 'dark:border-red-500');
                        this.classList.remove('border-green-300', 'dark:border-green-500');
                    }
                });
            }
            
            // Date validation - minimum age 17
            const tanggalLahirInput = document.getElementById('tanggal_lahir');
            if (tanggalLahirInput) {
                tanggalLahirInput.addEventListener('change', function() {
                    const selectedDate = new Date(this.value);
                    const today = new Date();
                    const minDate = new Date();
                    minDate.setFullYear(today.getFullYear() - 17);
                    
                    if (selectedDate > minDate) {
                        this.classList.add('border-red-300', 'dark:border-red-500');
                        this.classList.remove('border-green-300', 'dark:border-green-500');
                        
                        // Show warning
                        let warning = this.nextElementSibling;
                        if (!warning || !warning.classList.contains('age-warning')) {
                            warning = document.createElement('p');
                            warning.className = 'mt-1 text-sm text-red-600 age-warning';
                            this.parentNode.insertBefore(warning, this.nextElementSibling);
                        }
                        warning.innerHTML = '<i class="fas fa-exclamation-triangle mr-1"></i>Usia minimal 17 tahun.';
                    } else {
                        this.classList.remove('border-red-300', 'dark:border-red-500');
                        this.classList.add('border-green-300', 'dark:border-green-500');
                        
                        // Remove warning if exists
                        const warning = this.nextElementSibling;
                        if (warning && warning.classList.contains('age-warning')) {
                            warning.remove();
                        }
                    }
                });
            }
            
            // File size validation for KTP
            const ktpInput = document.getElementById('foto_ktp');
            if (ktpInput) {
                ktpInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const maxSize = 2 * 1024 * 1024; // 2MB
                        
                        if (file.size > maxSize) {
                            // Show error
                            let errorDiv = this.nextElementSibling;
                            if (!errorDiv || !errorDiv.classList.contains('file-error')) {
                                errorDiv = document.createElement('div');
                                errorDiv.className = 'mt-1 text-sm text-red-600 file-error';
                                this.parentNode.insertBefore(errorDiv, this.nextElementSibling);
                            }
                            errorDiv.innerHTML = '<i class="fas fa-exclamation-circle mr-1"></i>Ukuran file melebihi 2MB.';
                            
                            // Clear file input
                            this.value = '';
                        } else {
                            // Remove error if exists
                            const errorDiv = this.nextElementSibling;
                            if (errorDiv && errorDiv.classList.contains('file-error')) {
                                errorDiv.remove();
                            }
                        }
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>