<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
                    <i class="fas fa-file-signature mr-2 text-green-600"></i>Ajukan {{ $jenisSurat->nama }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Lengkapi formulir pengajuan surat</p>
            </div>
            <div class="text-sm text-gray-500">
                {{ now()->format('d/m/Y') }}
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <!-- Progress Steps -->
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                    <div class="max-w-3xl mx-auto">
                        <div class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
                            <!-- Step 1 -->
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center text-white font-semibold">
                                        <i class="fas fa-check"></i>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-xs font-medium text-gray-500">Langkah 1</p>
                                    <p class="text-sm font-semibold text-gray-900">Pilih Jenis</p>
                                </div>
                            </div>
                            
                            <!-- Step Connector -->
                            <div class="hidden md:block flex-1">
                                <div class="h-0.5 bg-green-600"></div>
                            </div>
                            
                            <!-- Step 2 -->
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center text-white font-semibold">
                                        2
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-xs font-medium text-gray-500">Langkah 2</p>
                                    <p class="text-sm font-semibold text-gray-900">Isi Formulir</p>
                                </div>
                            </div>
                            
                            <!-- Step Connector -->
                            <div class="hidden md:block flex-1">
                                <div class="h-0.5 bg-gray-300"></div>
                            </div>
                            
                            <!-- Step 3 -->
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-gray-500 font-semibold">
                                        3
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-xs font-medium text-gray-500">Langkah 3</p>
                                    <p class="text-sm font-semibold text-gray-500">Preview</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="p-6">
                    <!-- Jenis Surat Info -->
                    <div class="mb-8 bg-gradient-to-r from-green-50 to-green-100 border border-green-200 rounded-xl p-5">
                        <div class="flex flex-col md:flex-row items-start md:items-center justify-between">
                            <div class="mb-4 md:mb-0">
                                <div class="flex items-center mb-2">
                                    <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-file-contract text-green-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900">{{ $jenisSurat->nama }}</h3>
                                        <p class="text-green-700">{{ $jenisSurat->deskripsi }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-wrap gap-4">
                                <div class="bg-white rounded-lg px-4 py-2 border border-green-200">
                                    <div class="flex items-center">
                                        <i class="fas fa-clock text-green-600 mr-2"></i>
                                        <div>
                                            <p class="text-xs text-gray-500">Estimasi</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ $jenisSurat->estimasi_hari }} hari</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-white rounded-lg px-4 py-2 border border-green-200">
                                    <div class="flex items-center">
                                        <i class="fas fa-money-bill-wave text-green-600 mr-2"></i>
                                        <div>
                                            <p class="text-xs text-gray-500">Biaya</p>
                                            <p class="text-sm font-semibold text-gray-900">Rp {{ number_format($jenisSurat->biaya, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Section -->
                    <form action="{{ route('warga.surat.draft.store', $jenisSurat) }}" method="POST" enctype="multipart/form-data" id="suratForm">
                        @csrf

                        <div class="space-y-8">
                            @php
                                $persyaratan = json_decode($jenisSurat->persyaratan, true);
                            @endphp

                            @if(is_array($persyaratan) && count($persyaratan) > 0)
                                @foreach($persyaratan as $index => $syarat)
                                <div class="border border-gray-200 rounded-lg p-5">
                                    <div class="flex items-start mb-4">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                                <i class="fas {{ $syarat['type'] === 'file' ? 'fa-file-upload' : 'fa-edit' }} text-blue-600"></i>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between">
                                                <h3 class="text-lg font-semibold text-gray-900">{{ $syarat['label'] }}</h3>
                                                @if($syarat['required'])
                                                <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-700 rounded-full">
                                                    Wajib
                                                </span>
                                                @else
                                                <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-700 rounded-full">
                                                    Opsional
                                                </span>
                                                @endif
                                            </div>
                                            @if(!empty($syarat['description']))
                                            <p class="text-sm text-gray-500 mt-1">{{ $syarat['description'] }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    @if($syarat['type'] === 'file')
                                    <!-- File Upload Field -->
                                    <div class="mt-4">
                                        <label for="{{ $syarat['field'] }}" class="cursor-pointer">
                                            <div id="drop-area-{{ $index }}" 
                                                 class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center transition duration-200 hover:border-blue-400 hover:bg-blue-50">
                                                <div class="mx-auto w-16 h-16 mb-4">
                                                    <div class="w-full h-full bg-blue-100 rounded-full flex items-center justify-center">
                                                        <i class="fas fa-cloud-upload-alt text-blue-500 text-2xl"></i>
                                                    </div>
                                                </div>
                                                <p class="text-lg font-medium text-gray-700 mb-2">Upload {{ $syarat['label'] }}</p>
                                                <p class="text-sm text-gray-500 mb-4">Format: PDF, JPG, PNG • Maksimal 5MB</p>
                                                <div class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                                                    <i class="fas fa-folder-open mr-2"></i>
                                                    Pilih File
                                                </div>
                                            </div>
                                        </label>
                                        <input type="file" 
                                               name="file_{{ $syarat['field'] }}" 
                                               id="{{ $syarat['field'] }}"
                                               {{ $syarat['required'] ? 'required' : '' }}
                                               accept=".pdf,.jpg,.jpeg,.png"
                                               class="sr-only"
                                               onchange="handleFileUpload(this, {{ $index }})"
                                               data-max-size="5242880">
                                        
                                        <!-- File Preview -->
                                        <div id="file-preview-{{ $index }}" class="mt-4 hidden">
                                            <div class="flex items-center justify-between mb-3">
                                                <h4 class="text-sm font-medium text-gray-900">File Terpilih</h4>
                                                <button type="button" onclick="clearFilePreview({{ $index }})" 
                                                        class="text-sm text-red-600 hover:text-red-800 flex items-center">
                                                    <i class="fas fa-trash-alt mr-1"></i>Hapus
                                                </button>
                                            </div>
                                            <div id="preview-content-{{ $index }}" class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                                                <!-- Preview will be inserted here -->
                                            </div>
                                        </div>
                                        
                                        @error("file_{$syarat['field']}")
                                            <div class="mt-2 flex items-center text-red-600 text-sm">
                                                <i class="fas fa-exclamation-circle mr-2"></i>
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    @else
                                    <!-- Text/Date/Number Field -->
                                    <div class="mt-4">
                                        @if($syarat['type'] === 'textarea')
                                        <textarea name="{{ $syarat['field'] }}" 
                                                  id="{{ $syarat['field'] }}"
                                                  {{ $syarat['required'] ? 'required' : '' }}
                                                  rows="4"
                                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200"
                                                  placeholder="Isi {{ strtolower($syarat['label']) }}">{{ old($syarat['field']) }}</textarea>
                                        @else
                                        <input type="{{ $syarat['type'] }}" 
                                               name="{{ $syarat['field'] }}" 
                                               id="{{ $syarat['field'] }}"
                                               {{ $syarat['required'] ? 'required' : '' }}
                                               value="{{ old($syarat['field']) }}"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200"
                                               placeholder="{{ $syarat['type'] === 'date' ? 'Pilih tanggal' : 'Isi ' . strtolower($syarat['label']) }}">
                                        @endif
                                        
                                        @error($syarat['field'])
                                            <div class="mt-2 flex items-center text-red-600 text-sm">
                                                <i class="fas fa-exclamation-circle mr-2"></i>
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    @endif
                                </div>
                                @endforeach
                            @else
                            <!-- No Requirements Message -->
                            <div class="border border-gray-200 rounded-lg p-8 text-center">
                                <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-info-circle text-gray-400 text-2xl"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Tidak Ada Persyaratan Khusus</h3>
                                <p class="text-gray-600">
                                    Jenis surat ini tidak memerlukan data tambahan. Anda dapat langsung mengajukan.
                                </p>
                            </div>
                            @endif

                            <!-- Information Panel -->
                            <div class="border border-blue-200 rounded-lg p-5 bg-gradient-to-r from-blue-50 to-blue-100">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-lightbulb text-blue-600"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Tips Pengisian</h3>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                            <div class="flex items-start">
                                                <i class="fas fa-check-circle text-green-500 mt-0.5 mr-3"></i>
                                                <span class="text-sm text-gray-700">Isi semua data dengan benar dan sesuai dokumen asli</span>
                                            </div>
                                            <div class="flex items-start">
                                                <i class="fas fa-check-circle text-green-500 mt-0.5 mr-3"></i>
                                                <span class="text-sm text-gray-700">Pastikan foto/scan dokumen jelas dan terbaca</span>
                                            </div>
                                            <div class="flex items-start">
                                                <i class="fas fa-check-circle text-green-500 mt-0.5 mr-3"></i>
                                                <span class="text-sm text-gray-700">Periksa kembali data sebelum mengirimkan</span>
                                            </div>
                                            <div class="flex items-start">
                                                <i class="fas fa-check-circle text-green-500 mt-0.5 mr-3"></i>
                                                <span class="text-sm text-gray-700">Simpan draft jika ingin melanjutkan nanti</span>
                                            </div>
                                        </div>
                                        <div class="mt-4 p-3 bg-white rounded-lg border border-blue-200">
                                            <div class="flex items-center">
                                                <i class="fas fa-clock text-blue-600 mr-3"></i>
                                                <p class="text-sm text-blue-700">
                                                    <span class="font-semibold">Estimasi proses:</span> {{ $jenisSurat->estimasi_hari }} hari kerja setelah dokumen lengkap
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="border-t border-gray-200 pt-6">
                                <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                                    <div class="text-sm text-gray-500">
                                        <i class="fas fa-asterisk text-red-400 mr-1"></i> Menandakan bidang wajib diisi
                                    </div>
                                    <div class="flex flex-wrap gap-3">
                                        <a href="{{ route('warga.surat.create') }}" 
                                           class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2.5 px-5 rounded-lg transition duration-200 flex items-center card-hover">
                                            <i class="fas fa-arrow-left mr-2.5"></i>
                                            Kembali
                                        </a>
                                        
                                        <button type="submit" name="action" value="draft" 
                                                class="bg-yellow-100 hover:bg-yellow-200 text-yellow-700 font-medium py-2.5 px-5 rounded-lg transition duration-200 flex items-center card-hover">
                                            <i class="fas fa-save mr-2.5"></i>
                                            Simpan Draft
                                        </button>
                                        
                                        <button type="submit" name="action" value="submit" 
                                                class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-medium py-2.5 px-5 rounded-lg transition-all duration-200 flex items-center hover:shadow-lg card-hover">
                                            <i class="fas fa-paper-plane mr-2.5"></i>
                                            Ajukan Sekarang
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
        
        /* Progress step connector for mobile */
        @media (max-width: 768px) {
            .progress-connector {
                position: relative;
            }
            
            .progress-connector::after {
                content: '';
                position: absolute;
                top: 50%;
                right: -50%;
                width: 100%;
                height: 2px;
                background-color: #e5e7eb;
                transform: translateY(-50%);
                z-index: -1;
            }
            
            .progress-connector.active::after {
                background-color: #10b981;
            }
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize date fields
            const dateFields = document.querySelectorAll('input[type="date"]');
            dateFields.forEach(field => {
                // Set min date to today for future dates, max to today for past dates
                const today = new Date().toISOString().split('T')[0];
                
                // For birth dates, set max to today
                if (field.id.includes('tanggal') || field.id.includes('lahir')) {
                    field.max = today;
                }
            });
            
            // Character counters for textareas
            const textareas = document.querySelectorAll('textarea');
            textareas.forEach(textarea => {
                const updateCounter = () => {
                    const counter = textarea.nextElementSibling?.querySelector('.char-counter');
                    if (counter) {
                        const length = textarea.value.length;
                        counter.textContent = `${length} karakter`;
                        
                        // Color coding
                        if (length < 10) {
                            counter.classList.add('text-red-500');
                            counter.classList.remove('text-yellow-500', 'text-green-500');
                        } else if (length < 100) {
                            counter.classList.add('text-yellow-500');
                            counter.classList.remove('text-red-500', 'text-green-500');
                        } else {
                            counter.classList.add('text-green-500');
                            counter.classList.remove('text-red-500', 'text-yellow-500');
                        }
                    }
                };
                
                textarea.addEventListener('input', updateCounter);
                updateCounter();
            });
        });

        // File upload handling
        function handleFileUpload(input, index) {
            const file = input.files[0];
            if (!file) return;
            
            // Check file size
            const maxSize = parseInt(input.dataset.maxSize) || 5242880; // 5MB default
            if (file.size > maxSize) {
                showAlert('error', 'File terlalu besar. Maksimal 5MB');
                input.value = '';
                return;
            }
            
            // Check file type
            const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
            if (!allowedTypes.includes(file.type)) {
                showAlert('error', 'Format file tidak didukung. Gunakan PDF, JPG, atau PNG');
                input.value = '';
                return;
            }
            
            // Show preview
            const previewContainer = document.getElementById(`file-preview-${index}`);
            const previewContent = document.getElementById(`preview-content-${index}`);
            
            const reader = new FileReader();
            reader.onload = function(e) {
                previewContent.innerHTML = `
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-file text-blue-600"></i>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium text-gray-900 truncate">${file.name}</p>
                            <div class="flex items-center text-xs text-gray-500 mt-1">
                                <span class="mr-4">${formatFileSize(file.size)}</span>
                                <span>${file.type.split('/')[1].toUpperCase()}</span>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="${e.target.result}" target="_blank" 
                               class="text-blue-600 hover:text-blue-800 ml-2">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                `;
                previewContainer.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }

        function clearFilePreview(index) {
            const input = document.querySelector(`input[onchange*="handleFileUpload(this, ${index})"]`);
            const previewContainer = document.getElementById(`file-preview-${index}`);
            
            if (input) input.value = '';
            if (previewContainer) previewContainer.classList.add('hidden');
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        function showAlert(type, message) {
            // Remove existing alerts
            const existingAlerts = document.querySelectorAll('.custom-alert');
            existingAlerts.forEach(alert => alert.remove());
            
            // Create alert element
            const alert = document.createElement('div');
            alert.className = `custom-alert fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg flex items-center animate-slide-in ${
                type === 'error' ? 'bg-red-100 border border-red-300 text-red-700' : 
                'bg-green-100 border border-green-300 text-green-700'
            }`;
            alert.innerHTML = `
                <i class="fas fa-${type === 'error' ? 'exclamation-triangle' : 'check-circle'} mr-3"></i>
                <span class="flex-1">${message}</span>
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

        // Form validation
        document.getElementById('suratForm').addEventListener('submit', function(e) {
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;
            let firstInvalidField = null;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    if (!firstInvalidField) {
                        firstInvalidField = field;
                    }
                    
                    // Highlight error
                    field.classList.add('border-red-300', 'bg-red-50');
                    const parent = field.closest('.border-gray-200');
                    if (parent) {
                        parent.classList.add('border-red-300');
                    }
                    
                    // Remove error on input
                    field.addEventListener('input', function() {
                        this.classList.remove('border-red-300', 'bg-red-50');
                        const parent = this.closest('.border-gray-200');
                        if (parent) {
                            parent.classList.remove('border-red-300');
                        }
                    });
                }
            });

            if (!isValid && firstInvalidField) {
                e.preventDefault();
                firstInvalidField.focus();
                
                // Show error message
                showAlert('error', 'Harap lengkapi semua bidang yang wajib diisi');
                
                // Scroll to error
                firstInvalidField.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'center' 
                });
            }
        });

        // Add drag and drop for file uploads
        @if(is_array($persyaratan))
            @foreach($persyaratan as $index => $syarat)
                @if($syarat['type'] === 'file')
        const dropArea{{ $index }} = document.getElementById('drop-area-{{ $index }}');
        if (dropArea{{ $index }}) {
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea{{ $index }}.addEventListener(eventName, preventDefaults, false);
            });
            
            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea{{ $index }}.addEventListener(eventName, () => {
                    dropArea{{ $index }}.classList.add('border-blue-500', 'bg-blue-50');
                }, false);
            });
            
            ['dragleave', 'drop'].forEach(eventName => {
                dropArea{{ $index }}.addEventListener(eventName, () => {
                    dropArea{{ $index }}.classList.remove('border-blue-500', 'bg-blue-50');
                }, false);
            });
            
            dropArea{{ $index }}.addEventListener('drop', function(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                const input = document.getElementById('{{ $syarat["field"] }}');
                if (input && files.length > 0) {
                    // Create a new DataTransfer object
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(files[0]);
                    input.files = dataTransfer.files;
                    
                    // Trigger change event
                    const event = new Event('change', { bubbles: true });
                    input.dispatchEvent(event);
                }
            });
        }
                @endif
            @endforeach
        @endif
    </script>
    @endpush
</x-app-layout>