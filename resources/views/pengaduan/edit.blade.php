<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
                    <i class="fas fa-edit mr-2 text-yellow-600"></i>Edit Pengaduan
                </h2>
                <p class="text-sm text-gray-500 mt-1">Kode: {{ $pengaduan->kode_pengaduan }}</p>
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
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
                        <div class="flex-1">
                            <h1 class="text-2xl font-bold text-gray-900">Edit: {{ $pengaduan->judul }}</h1>
                            <div class="flex flex-wrap items-center gap-2 mt-2">
                                <span class="px-3 py-1.5 text-sm font-semibold rounded-full {{ $pengaduan->getStatusBadgeClass() }}">
                                    <i class="fas fa-circle text-xs mr-1.5"></i>
                                    {{ ucfirst($pengaduan->status) }}
                                </span>
                                <span class="px-3 py-1.5 text-sm font-semibold rounded-full {{ $pengaduan->getPrioritasBadgeClass() }}">
                                    <i class="fas fa-exclamation-triangle text-xs mr-1.5"></i>
                                    {{ ucfirst($pengaduan->prioritas) }}
                                </span>
                            </div>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('warga.pengaduan.show', $pengaduan) }}" 
                               class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg transition duration-200 flex items-center card-hover">
                                <i class="fas fa-eye mr-2"></i>
                                Lihat Detail
                            </a>
                            <a href="{{ route('warga.pengaduan.index') }}" 
                               class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg transition duration-200 flex items-center card-hover">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Kembali
                            </a>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    @if($pengaduan->status !== 'menunggu')
                    <!-- Warning Alert -->
                    <div class="mb-8 bg-gradient-to-r from-yellow-50 to-yellow-100 border border-yellow-200 rounded-xl p-5">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-yellow-800">Pengaduan Tidak Dapat Diedit</h3>
                                <div class="mt-2">
                                    <p class="text-yellow-700">
                                        Pengaduan dengan status <span class="font-bold">"{{ ucfirst($pengaduan->status) }}"</span> tidak dapat diedit. 
                                        Hanya pengaduan dengan status "Menunggu" yang dapat diubah.
                                    </p>
                                    <div class="mt-3 flex flex-wrap gap-3">
                                        <a href="{{ route('warga.pengaduan.show', $pengaduan) }}" 
                                           class="bg-yellow-100 hover:bg-yellow-200 text-yellow-800 font-medium py-2 px-4 rounded-lg transition duration-200 flex items-center">
                                            <i class="fas fa-info-circle mr-2"></i>
                                            Lihat Status
                                        </a>
                                        <a href="{{ route('warga.pengaduan.create') }}" 
                                           class="bg-blue-100 hover:bg-blue-200 text-blue-800 font-medium py-2 px-4 rounded-lg transition duration-200 flex items-center">
                                            <i class="fas fa-plus mr-2"></i>
                                            Buat Baru
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Edit Form -->
                    <form action="{{ route('warga.pengaduan.update', $pengaduan) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-8">
                            <!-- Kategori Pengaduan -->
                            <div class="border border-gray-200 rounded-lg p-5">
                                <div class="flex items-center mb-4">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-tag text-blue-600"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Kategori Pengaduan</h3>
                                        <p class="text-sm text-gray-500">Pilih kategori yang sesuai</p>
                                    </div>
                                </div>
                                <div>
                                    <select id="kategori_pengaduan_id" name="kategori_pengaduan_id" required
                                        {{ $pengaduan->status !== 'menunggu' ? 'disabled' : '' }}
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 {{ $pengaduan->status !== 'menunggu' ? 'bg-gray-100 cursor-not-allowed' : '' }}">
                                        @foreach($kategories as $kategori)
                                            <option value="{{ $kategori->id }}" {{ $pengaduan->kategori_pengaduan_id == $kategori->id ? 'selected' : '' }}>
                                                {{ $kategori->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
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
                                        <p class="text-sm text-gray-500">Judul singkat dan jelas</p>
                                    </div>
                                </div>
                                <div>
                                    <input type="text" name="judul" id="judul" required
                                        value="{{ old('judul', $pengaduan->judul) }}"
                                        {{ $pengaduan->status !== 'menunggu' ? 'disabled' : '' }}
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 {{ $pengaduan->status !== 'menunggu' ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                        placeholder="Contoh: Jalan Berlubang di RW 05">
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
                                        <p class="text-sm text-gray-500">Jelaskan secara detail</p>
                                    </div>
                                </div>
                                <div>
                                    <textarea name="deskripsi" id="deskripsi" rows="6" required
                                        {{ $pengaduan->status !== 'menunggu' ? 'disabled' : '' }}
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 {{ $pengaduan->status !== 'menunggu' ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                        placeholder="Deskripsikan pengaduan Anda secara lengkap...">{{ old('deskripsi', $pengaduan->deskripsi) }}</textarea>
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
                                        <p class="text-sm text-gray-500">Tentukan lokasi dengan jelas</p>
                                    </div>
                                </div>
                                <div>
                                    <input type="text" name="lokasi" id="lokasi" required
                                        value="{{ old('lokasi', $pengaduan->lokasi) }}"
                                        {{ $pengaduan->status !== 'menunggu' ? 'disabled' : '' }}
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 {{ $pengaduan->status !== 'menunggu' ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                        placeholder="Contoh: Jalan Merdeka No. 15, RT 01/RW 05">
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
                                        <p class="text-sm text-gray-500">Tanggal saat kejadian berlangsung</p>
                                    </div>
                                </div>
                                <div>
                                    <input type="date" name="tanggal_kejadian" id="tanggal_kejadian" required
                                        value="{{ old('tanggal_kejadian', $pengaduan->tanggal_kejadian->format('Y-m-d')) }}"
                                        {{ $pengaduan->status !== 'menunggu' ? 'disabled' : '' }}
                                        max="{{ date('Y-m-d') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 {{ $pengaduan->status !== 'menunggu' ? 'bg-gray-100 cursor-not-allowed' : '' }}">
                                </div>
                            </div>

                            <!-- Current Photos Section -->
                            @if($pengaduan->foto_bukti && count($pengaduan->foto_bukti) > 0)
                            <div class="border border-gray-200 rounded-lg p-5">
                                <div class="flex items-center mb-4">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-images text-green-600"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Foto Bukti Saat Ini</h3>
                                        <p class="text-sm text-gray-500">{{ count($pengaduan->foto_bukti) }} foto terlampir</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                    @foreach($pengaduan->foto_bukti as $index => $foto)
                                    <div class="relative group border border-gray-200 rounded-lg overflow-hidden card-hover">
                                        <img src="{{ Storage::url($foto) }}" 
                                             alt="Foto bukti {{ $index + 1 }}"
                                             class="w-full h-40 object-cover transition duration-200 group-hover:scale-105">
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition duration-200"></div>
                                        <div class="absolute top-2 right-2">
                                            <a href="{{ Storage::url($foto) }}" target="_blank" 
                                               class="bg-white bg-opacity-90 p-2 rounded-full hover:bg-opacity-100 transition duration-200">
                                                <i class="fas fa-expand text-gray-600 text-sm"></i>
                                            </a>
                                        </div>
                                        <div class="absolute bottom-2 left-2 right-2 bg-black bg-opacity-60 text-white text-xs px-2 py-1 rounded text-center">
                                            Foto {{ $index + 1 }}
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                                    <div class="flex items-start">
                                        <i class="fas fa-info-circle text-gray-400 mt-0.5 mr-3"></i>
                                        <p class="text-sm text-gray-600">
                                            Foto tidak dapat diubah melalui edit. Untuk mengubah foto, silakan hapus pengaduan ini dan buat pengaduan baru dengan foto yang diperbarui.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Form Actions -->
                            <div class="border-t border-gray-200 pt-6">
                                <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                                    <div class="text-sm text-gray-500">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        Pastikan semua data yang diisi sudah benar
                                    </div>
                                    <div class="flex space-x-3">
                                        <a href="{{ route('warga.pengaduan.show', $pengaduan) }}" 
                                           class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2.5 px-5 rounded-lg transition duration-200 flex items-center card-hover">
                                            <i class="fas fa-times mr-2.5"></i>
                                            Batal
                                        </a>
                                        @if($pengaduan->status === 'menunggu')
                                        <button type="submit" 
                                                class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium py-2.5 px-5 rounded-lg transition-all duration-200 flex items-center hover:shadow-lg card-hover">
                                            <i class="fas fa-save mr-2.5"></i>
                                            Update Pengaduan
                                        </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Delete Section -->
                    @if($pengaduan->status === 'menunggu')
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <div class="bg-gradient-to-r from-red-50 to-red-100 border border-red-200 rounded-xl p-5">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-trash-alt text-red-600"></i>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <h3 class="text-lg font-semibold text-red-800">Hapus Pengaduan</h3>
                                    <div class="mt-2">
                                        <p class="text-red-700">
                                            <i class="fas fa-exclamation-triangle mr-2"></i>
                                            Tindakan ini tidak dapat dibatalkan. Setelah dihapus, pengaduan ini akan dihapus permanen dari sistem.
                                        </p>
                                        <div class="mt-4 flex flex-wrap gap-3">
                                            <form action="{{ route('warga.pengaduan.destroy', $pengaduan) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="bg-red-600 hover:bg-red-700 text-white font-medium py-2.5 px-5 rounded-lg transition duration-200 flex items-center"
                                                        onclick="return confirmDelete()">
                                                    <i class="fas fa-trash mr-2.5"></i>
                                                    Ya, Hapus Pengaduan
                                                </button>
                                            </form>
                                            <a href="{{ route('warga.pengaduan.create') }}" 
                                               class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2.5 px-5 rounded-lg transition duration-200 flex items-center">
                                                <i class="fas fa-plus mr-2.5"></i>
                                                Buat Pengaduan Baru
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
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
        
        input:disabled, 
        select:disabled, 
        textarea:disabled {
            cursor: not-allowed;
            background-color: #f9fafb !important;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        // Set max date to today
        document.addEventListener('DOMContentLoaded', function() {
            const dateField = document.getElementById('tanggal_kejadian');
            if (dateField) {
                const today = new Date().toISOString().split('T')[0];
                dateField.max = today;
            }
            
            // Character counter for textarea
            const textarea = document.getElementById('deskripsi');
            if (textarea) {
                const updateCounter = () => {
                    const length = textarea.value.length;
                    const counter = document.getElementById('charCounter') || createCounter();
                    counter.textContent = `${length} karakter`;
                };
                
                const createCounter = () => {
                    const counter = document.createElement('div');
                    counter.id = 'charCounter';
                    counter.className = 'text-xs text-gray-500 mt-1 text-right';
                    textarea.parentNode.appendChild(counter);
                    return counter;
                };
                
                textarea.addEventListener('input', updateCounter);
                updateCounter();
            }
        });

        // Delete confirmation with more details
        function confirmDelete() {
            return confirm('⚠️ PERHATIAN!\n\nApakah Anda yakin ingin menghapus pengaduan ini?\n\n' +
                          'Judul: {{ $pengaduan->judul }}\n' +
                          'Kode: {{ $pengaduan->kode_pengaduan }}\n\n' +
                          'Tindakan ini TIDAK DAPAT DIBATALKAN!');
        }

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;
            let firstInvalidField = null;

            requiredFields.forEach(field => {
                if (!field.disabled && !field.value.trim()) {
                    isValid = false;
                    if (!firstInvalidField) {
                        firstInvalidField = field;
                    }
                    field.classList.add('border-red-300', 'bg-red-50');
                    
                    // Remove red border on input
                    field.addEventListener('input', function() {
                        this.classList.remove('border-red-300', 'bg-red-50');
                    });
                }
            });

            if (!isValid && firstInvalidField) {
                e.preventDefault();
                firstInvalidField.focus();
                
                // Show error message
                const errorDiv = document.createElement('div');
                errorDiv.className = 'mt-3 p-3 bg-red-100 border border-red-300 rounded-lg text-red-700';
                errorDiv.innerHTML = '<i class="fas fa-exclamation-circle mr-2"></i>Harap lengkapi semua bidang yang wajib diisi';
                
                const existingError = this.querySelector('.form-error');
                if (existingError) existingError.remove();
                
                this.insertBefore(errorDiv, this.firstChild);
                errorDiv.classList.add('form-error');
                
                // Scroll to error
                errorDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
    </script>
    @endpush
</x-app-layout>