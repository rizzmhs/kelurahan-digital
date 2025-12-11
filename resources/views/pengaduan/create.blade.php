<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
                    <i class="fas fa-plus-circle mr-2 text-blue-600"></i>Buat Pengaduan Baru
                </h2>
                <p class="text-sm text-gray-500 mt-1">Laporkan masalah atau keluhan Anda</p>
            </div>
            <div class="text-sm text-gray-500">
                {{ now()->format('d/m/Y') }}
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <!-- Header Section -->
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-blue-100">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
                        <div class="flex-1">
                            <h1 class="text-2xl font-bold text-gray-900">Formulir Pengaduan</h1>
                            <p class="text-gray-600 mt-1 max-w-2xl">
                                Isi formulir dengan data yang akurat untuk mempercepat proses penanganan
                            </p>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('warga.pengaduan.index') }}" 
                               class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg transition duration-200 flex items-center card-hover">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Kembali
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Main Form -->
                <div class="p-6">
                    <form action="{{ route('warga.pengaduan.store') }}" method="POST" enctype="multipart/form-data" id="pengaduanForm">
                        @csrf

                        <div class="space-y-8">
                            <!-- Kategori Pengaduan -->
                            <div class="border border-gray-200 rounded-lg p-5">
                                <div class="flex items-center mb-4">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-tag text-blue-600"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Kategori Pengaduan</h3>
                                        <p class="text-sm text-gray-500">Pilih kategori yang sesuai dengan masalah Anda</p>
                                    </div>
                                </div>
                                <div>
                                    <select id="kategori_pengaduan_id" name="kategori_pengaduan_id" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 appearance-none bg-white">
                                        <option value="" disabled selected>-- Pilih Kategori Pengaduan --</option>
                                        @foreach($kategories as $kategori)
                                            <option value="{{ $kategori->id }}" {{ old('kategori_pengaduan_id') == $kategori->id ? 'selected' : '' }}>
                                                {{ $kategori->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kategori_pengaduan_id')
                                        <div class="mt-2 flex items-center text-red-600 text-sm">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Judul Pengaduan -->
                            <div class="border border-gray-200 rounded-lg p-5">
                                <div class="flex items-center mb-4">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-heading text-blue-600"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Judul Pengaduan</h3>
                                        <p class="text-sm text-gray-500">Judul singkat dan jelas tentang masalah Anda</p>
                                    </div>
                                </div>
                                <div>
                                    <input type="text" name="judul" id="judul" required
                                        value="{{ old('judul') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                        placeholder="Contoh: Jalan Berlubang di RW 05 atau Lampu Jalan Mati di RT 03">
                                    @error('judul')
                                        <div class="mt-2 flex items-center text-red-600 text-sm">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Deskripsi Pengaduan -->
                            <div class="border border-gray-200 rounded-lg p-5">
                                <div class="flex items-center mb-4">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-align-left text-blue-600"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Deskripsi Lengkap</h3>
                                        <p class="text-sm text-gray-500">Jelaskan masalah secara detail agar mudah dipahami</p>
                                    </div>
                                </div>
                                <div>
                                    <textarea name="deskripsi" id="deskripsi" rows="6" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 resize-none"
                                        placeholder="Contoh: 
• Lokasi tepatnya di mana?
• Kapan kejadiannya?
• Apa dampaknya?
• Bagaimana kondisi saat ini?
• Apa harapan Anda?

Jelaskan dengan jelas...">{{ old('deskripsi') }}</textarea>
                                    <div class="mt-2 flex justify-between items-center">
                                        <div class="text-xs text-gray-500">
                                            <i class="fas fa-lightbulb mr-1"></i>Gunakan poin-poin untuk penjelasan yang lebih jelas
                                        </div>
                                        <div id="charCounter" class="text-xs text-gray-500">0 karakter</div>
                                    </div>
                                    @error('deskripsi')
                                        <div class="mt-2 flex items-center text-red-600 text-sm">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Lokasi Kejadian -->
                            <div class="border border-gray-200 rounded-lg p-5">
                                <div class="flex items-center mb-4">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-map-marker-alt text-blue-600"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Lokasi Kejadian</h3>
                                        <p class="text-sm text-gray-500">Sebutkan lokasi dengan detail (RT/RW, nama jalan, patokan)</p>
                                    </div>
                                </div>
                                <div>
                                    <input type="text" name="lokasi" id="lokasi" required
                                        value="{{ old('lokasi') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                        placeholder="Contoh: Jalan Merdeka No. 15, RT 01/RW 05, dekat Pos Kamling">
                                    @error('lokasi')
                                        <div class="mt-2 flex items-center text-red-600 text-sm">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Tanggal Kejadian -->
                            <div class="border border-gray-200 rounded-lg p-5">
                                <div class="flex items-center mb-4">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-calendar-alt text-blue-600"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Tanggal Kejadian</h3>
                                        <p class="text-sm text-gray-500">Pilih tanggal saat kejadian berlangsung</p>
                                    </div>
                                </div>
                                <div>
                                    <div class="relative">
                                        <input type="date" name="tanggal_kejadian" id="tanggal_kejadian" required
                                            value="{{ old('tanggal_kejadian', date('Y-m-d')) }}"
                                            max="{{ date('Y-m-d') }}"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <i class="fas fa-calendar text-gray-400"></i>
                                        </div>
                                    </div>
                                    @error('tanggal_kejadian')
                                        <div class="mt-2 flex items-center text-red-600 text-sm">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Upload Foto Bukti -->
                            <div class="border border-gray-200 rounded-lg p-5">
                                <div class="flex items-center mb-4">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-camera text-green-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900">Foto Bukti</h3>
                                        <p class="text-sm text-gray-500">Foto akan membantu petugas memahami kondisi sebenarnya</p>
                                    </div>
                                    <span class="px-3 py-1 text-xs font-medium bg-gray-100 text-gray-700 rounded-full">
                                        Opsional
                                    </span>
                                </div>
                                
                                <!-- Upload Area -->
                                <div class="mt-2">
                                    <label for="foto_bukti" class="cursor-pointer">
                                        <div id="drop-area" 
                                             class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center transition duration-200 hover:border-blue-400 hover:bg-blue-50">
                                            <div class="mx-auto w-16 h-16 mb-4">
                                                <div class="w-full h-full bg-blue-100 rounded-full flex items-center justify-center">
                                                    <i class="fas fa-cloud-upload-alt text-blue-500 text-2xl"></i>
                                                </div>
                                            </div>
                                            <p class="text-lg font-medium text-gray-700 mb-2">Drag & Drop atau Klik untuk Upload</p>
                                            <p class="text-sm text-gray-500 mb-4">Format: JPG, PNG, GIF • Maksimal 5MB per file • Maksimal 5 file</p>
                                            <div class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                                                <i class="fas fa-folder-open mr-2"></i>
                                                Pilih File
                                            </div>
                                            <input id="foto_bukti" name="foto_bukti[]" type="file" multiple 
                                                   class="sr-only" accept="image/*" onchange="handleFiles(this.files)">
                                        </div>
                                    </label>
                                    
                                    <!-- File Preview -->
                                    <div id="file-preview-container" class="mt-6 hidden">
                                        <div class="flex justify-between items-center mb-3">
                                            <h4 class="text-sm font-medium text-gray-900">File Terpilih</h4>
                                            <button type="button" onclick="clearAllFiles()" class="text-sm text-red-600 hover:text-red-800">
                                                <i class="fas fa-trash-alt mr-1"></i>Hapus Semua
                                            </button>
                                        </div>
                                        <div id="file-preview" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"></div>
                                        <div id="file-info" class="mt-3 text-sm text-gray-600"></div>
                                    </div>
                                    
                                    @error('foto_bukti.*')
                                        <div class="mt-2 flex items-center text-red-600 text-sm">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Information Section -->
                            <div class="border border-blue-200 rounded-lg p-5 bg-gradient-to-r from-blue-50 to-blue-100">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-info-circle text-blue-600"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Tips Pengisian yang Baik</h3>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                            <div class="flex items-start">
                                                <i class="fas fa-check-circle text-green-500 mt-0.5 mr-3"></i>
                                                <span class="text-sm text-gray-700">Isi dengan data yang akurat dan dapat dipertanggungjawabkan</span>
                                            </div>
                                            <div class="flex items-start">
                                                <i class="fas fa-check-circle text-green-500 mt-0.5 mr-3"></i>
                                                <span class="text-sm text-gray-700">Foto bukti yang jelas akan mempercepat proses penanganan</span>
                                            </div>
                                            <div class="flex items-start">
                                                <i class="fas fa-check-circle text-green-500 mt-0.5 mr-3"></i>
                                                <span class="text-sm text-gray-700">Pengaduan akan diverifikasi terlebih dahulu oleh admin</span>
                                            </div>
                                            <div class="flex items-start">
                                                <i class="fas fa-check-circle text-green-500 mt-0.5 mr-3"></i>
                                                <span class="text-sm text-gray-700">Anda dapat melacak status pengaduan melalui dashboard</span>
                                            </div>
                                        </div>
                                        <div class="mt-4 p-3 bg-blue-100 rounded-lg">
                                            <div class="flex items-center">
                                                <i class="fas fa-clock text-blue-600 mr-3"></i>
                                                <p class="text-sm text-blue-700">
                                                    Pengaduan biasanya diproses dalam 1-3 hari kerja setelah diverifikasi
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="border-t border-gray-200 pt-6">
                                <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                                    <div class="text-sm text-gray-500">
                                        <i class="fas fa-asterisk text-red-400 mr-1"></i> Menandakan bidang wajib diisi
                                    </div>
                                    <div class="flex space-x-3">
                                        <a href="{{ route('warga.pengaduan.index') }}" 
                                           class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2.5 px-5 rounded-lg transition duration-200 flex items-center card-hover">
                                            <i class="fas fa-times mr-2.5"></i>
                                            Batal
                                        </a>
                                        <button type="submit" 
                                                class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium py-2.5 px-5 rounded-lg transition-all duration-200 flex items-center hover:shadow-lg card-hover">
                                            <i class="fas fa-paper-plane mr-2.5"></i>
                                            Kirim Pengaduan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-2px);
        }
        
        /* Custom scrollbar for textarea */
        textarea::-webkit-scrollbar {
            width: 8px;
        }
        
        textarea::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        
        textarea::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }
        
        textarea::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }
        
        /* File preview styling */
        .file-preview-item {
            transition: all 0.3s ease;
        }
        
        .file-preview-item:hover {
            transform: scale(1.02);
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        // Character counter for textarea
        document.addEventListener('DOMContentLoaded', function() {
            const textarea = document.getElementById('deskripsi');
            const counter = document.getElementById('charCounter');
            
            if (textarea && counter) {
                const updateCounter = () => {
                    const length = textarea.value.length;
                    counter.textContent = `${length} karakter`;
                    
                    // Color coding
                    if (length < 50) {
                        counter.classList.add('text-red-500');
                        counter.classList.remove('text-yellow-500', 'text-green-500');
                    } else if (length < 200) {
                        counter.classList.add('text-yellow-500');
                        counter.classList.remove('text-red-500', 'text-green-500');
                    } else {
                        counter.classList.add('text-green-500');
                        counter.classList.remove('text-red-500', 'text-yellow-500');
                    }
                };
                
                textarea.addEventListener('input', updateCounter);
                updateCounter();
            }
            
            // Set max date to today
            const dateField = document.getElementById('tanggal_kejadian');
            if (dateField) {
                const today = new Date().toISOString().split('T')[0];
                dateField.max = today;
            }
        });

        // File handling functions
        let uploadedFiles = [];
        const MAX_FILES = 5;
        const MAX_SIZE = 5 * 1024 * 1024; // 5MB

        function handleFiles(files) {
            const previewContainer = document.getElementById('file-preview-container');
            const previewElement = document.getElementById('file-preview');
            const fileInfoElement = document.getElementById('file-info');
            
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                
                // Check file count
                if (uploadedFiles.length >= MAX_FILES) {
                    showAlert('error', `Maksimal ${MAX_FILES} file yang dapat diupload`);
                    break;
                }
                
                // Check file type
                if (!file.type.startsWith('image/')) {
                    showAlert('error', 'Hanya file gambar yang diperbolehkan');
                    continue;
                }
                
                // Check file size
                if (file.size > MAX_SIZE) {
                    showAlert('error', `File ${file.name} terlalu besar (maksimal 5MB)`);
                    continue;
                }
                
                // Add to uploaded files
                uploadedFiles.push(file);
                
                // Create preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'file-preview-item relative border border-gray-200 rounded-lg overflow-hidden';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-32 object-cover" alt="${file.name}">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 hover:opacity-100 transition-opacity duration-200">
                            <div class="absolute bottom-2 left-2 right-2">
                                <p class="text-white text-xs truncate">${file.name}</p>
                                <p class="text-white text-xs">${formatFileSize(file.size)}</p>
                            </div>
                            <button type="button" 
                                    onclick="removeFile(${uploadedFiles.length - 1})"
                                    class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 transition duration-200">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;
                    previewElement.appendChild(div);
                };
                reader.readAsDataURL(file);
            }
            
            // Update file info
            updateFileInfo();
            
            // Show preview container
            if (uploadedFiles.length > 0) {
                previewContainer.classList.remove('hidden');
            }
            
            // Reset file input
            document.getElementById('foto_bukti').value = '';
        }

        function removeFile(index) {
            uploadedFiles.splice(index, 1);
            updatePreview();
            updateFileInfo();
        }

        function clearAllFiles() {
            uploadedFiles = [];
            updatePreview();
            updateFileInfo();
        }

        function updatePreview() {
            const previewElement = document.getElementById('file-preview');
            const previewContainer = document.getElementById('file-preview-container');
            previewElement.innerHTML = '';
            
            uploadedFiles.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'file-preview-item relative border border-gray-200 rounded-lg overflow-hidden';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-32 object-cover" alt="${file.name}">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 hover:opacity-100 transition-opacity duration-200">
                            <div class="absolute bottom-2 left-2 right-2">
                                <p class="text-white text-xs truncate">${file.name}</p>
                                <p class="text-white text-xs">${formatFileSize(file.size)}</p>
                            </div>
                            <button type="button" 
                                    onclick="removeFile(${index})"
                                    class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 transition duration-200">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;
                    previewElement.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
            
            if (uploadedFiles.length === 0) {
                previewContainer.classList.add('hidden');
            }
        }

        function updateFileInfo() {
            const fileInfoElement = document.getElementById('file-info');
            if (!fileInfoElement) return;
            
            const totalSize = uploadedFiles.reduce((sum, file) => sum + file.size, 0);
            fileInfoElement.innerHTML = `
                <div class="flex items-center justify-between">
                    <span>
                        <i class="fas fa-file-image mr-1"></i>
                        ${uploadedFiles.length} file terpilih
                    </span>
                    <span>
                        <i class="fas fa-database mr-1"></i>
                        ${formatFileSize(totalSize)}
                    </span>
                </div>
                <div class="mt-1 text-xs ${uploadedFiles.length >= MAX_FILES ? 'text-red-500' : 'text-gray-500'}">
                    ${uploadedFiles.length}/${MAX_FILES} file • Maksimal 5MB per file
                </div>
            `;
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        function showAlert(type, message) {
            // Create alert element
            const alert = document.createElement('div');
            alert.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg flex items-center ${
                type === 'error' ? 'bg-red-100 border border-red-300 text-red-700' : 
                'bg-green-100 border border-green-300 text-green-700'
            }`;
            alert.innerHTML = `
                <i class="fas fa-${type === 'error' ? 'exclamation-triangle' : 'check-circle'} mr-2"></i>
                <span>${message}</span>
                <button class="ml-4 text-gray-500 hover:text-gray-700" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            // Add to body
            document.body.appendChild(alert);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                if (alert.parentElement) {
                    alert.remove();
                }
            }, 5000);
        }

        // Drag and drop functionality
        const dropArea = document.getElementById('drop-area');
        
        if (dropArea) {
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, preventDefaults, false);
            });
            
            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, highlight, false);
            });
            
            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, unhighlight, false);
            });
            
            function highlight() {
                dropArea.classList.add('border-blue-500', 'bg-blue-50');
            }
            
            function unhighlight() {
                dropArea.classList.remove('border-blue-500', 'bg-blue-50');
            }
            
            dropArea.addEventListener('drop', function(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                handleFiles(files);
            });
        }

        // Form validation
        document.getElementById('pengaduanForm').addEventListener('submit', function(e) {
            // Add files to form data if any
            if (uploadedFiles.length > 0) {
                const formData = new FormData(this);
                
                // Remove existing file inputs
                const existingFiles = formData.getAll('foto_bukti[]');
                existingFiles.forEach(() => {
                    formData.delete('foto_bukti[]');
                });
                
                // Add new files
                uploadedFiles.forEach(file => {
                    formData.append('foto_bukti[]', file);
                });
                
                // Submit with new form data
                e.preventDefault();
                
                // Show loading
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...';
                submitBtn.disabled = true;
                
                fetch(this.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                });
            }
        });
    </script>
    @endpush
</x-app-layout>