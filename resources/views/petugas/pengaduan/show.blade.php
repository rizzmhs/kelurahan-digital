<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('petugas.pengaduan.index') }}" 
                   class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 transition-colors">
                    <i class="fas fa-arrow-left text-sm"></i>
                </a>
                <div>
                    <h2 class="text-xl md:text-2xl font-bold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-tasks text-blue-600"></i>
                        Detail Pengaduan
                    </h2>
                    <p class="text-sm text-gray-600 mt-1">
                        Kode: <span class="font-medium text-gray-900">{{ $pengaduan->kode_pengaduan }}</span>
                    </p>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('petugas.pengaduan.riwayat', $pengaduan) }}" 
                   class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg text-sm transition-colors flex items-center gap-2">
                    <i class="fas fa-history"></i>
                    Riwayat
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4 md:py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column - Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Status & Priority Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                        <div class="px-5 py-4 border-b border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-info-circle text-blue-500"></i>
                                Status & Prioritas
                            </h3>
                        </div>
                        <div class="p-5">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div class="flex flex-wrap items-center gap-3">
                                    @php
                                        $statusClasses = [
                                            'menunggu' => 'bg-yellow-100 text-yellow-800',
                                            'diverifikasi' => 'bg-blue-100 text-blue-800',
                                            'diproses' => 'bg-purple-100 text-purple-800',
                                            'selesai' => 'bg-green-100 text-green-800',
                                            'ditolak' => 'bg-red-100 text-red-800'
                                        ];
                                        
                                        $prioritasClasses = [
                                            'rendah' => 'bg-gray-100 text-gray-800',
                                            'sedang' => 'bg-blue-100 text-blue-800',
                                            'tinggi' => 'bg-orange-100 text-orange-800',
                                            'darurat' => 'bg-red-100 text-red-800'
                                        ];
                                    @endphp
                                    
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold {{ $statusClasses[$pengaduan->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        <i class="fas fa-circle text-xs mr-2"></i>
                                        {{ ucfirst($pengaduan->status) }}
                                    </span>
                                    
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold {{ $prioritasClasses[$pengaduan->prioritas] ?? 'bg-gray-100 text-gray-800' }}">
                                        <i class="fas fa-flag text-xs mr-2"></i>
                                        Prioritas: {{ ucfirst($pengaduan->prioritas) }}
                                    </span>
                                </div>
                                
                                <div class="text-sm text-gray-500">
                                    <i class="fas fa-clock mr-1.5 text-gray-400"></i>
                                    Diperbarui: {{ $pengaduan->updated_at->format('d M Y, H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reporter Information -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                        <div class="px-5 py-4 border-b border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-user text-blue-500"></i>
                                Data Pelapor
                            </h3>
                        </div>
                        <div class="p-5">
                            <div class="flex items-start gap-4 mb-4">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center text-lg font-semibold">
                                        {{ substr($pengaduan->user->name, 0, 1) }}
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-semibold text-gray-900">{{ $pengaduan->user->name }}</h4>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $pengaduan->user->email }}</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">
                                        NIK
                                    </label>
                                    <p class="text-sm font-medium text-gray-900">{{ $pengaduan->user->nik }}</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">
                                        Telepon
                                    </label>
                                    <p class="text-sm font-medium text-gray-900">{{ $pengaduan->user->telepon }}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">
                                        Alamat
                                    </label>
                                    <p class="text-sm text-gray-900">{{ $pengaduan->user->alamat }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Complaint Details -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                        <div class="px-5 py-4 border-b border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-file-alt text-blue-500"></i>
                                Detail Pengaduan
                            </h3>
                        </div>
                        <div class="p-5 space-y-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">
                                    Judul Pengaduan
                                </label>
                                <h4 class="text-sm font-semibold text-gray-900">{{ $pengaduan->judul }}</h4>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">
                                    Deskripsi
                                </label>
                                <p class="text-sm text-gray-700 whitespace-pre-line leading-relaxed bg-gray-50 p-3 rounded-lg">
                                    {{ $pengaduan->deskripsi }}
                                </p>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">
                                        Kategori
                                    </label>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        <i class="fas fa-tag mr-1.5 text-xs text-gray-500"></i>
                                        {{ $pengaduan->kategori->nama ?? 'Tidak ada kategori' }}
                                    </span>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">
                                        Lokasi Kejadian
                                    </label>
                                    <p class="text-sm font-medium text-gray-900">{{ $pengaduan->lokasi ?? 'Tidak disebutkan' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Evidence Photos -->
                    @if($pengaduan->foto_bukti && count($pengaduan->foto_bukti) > 0)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                        <div class="px-5 py-4 border-b border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-images text-green-500"></i>
                                Bukti Foto
                                <span class="text-sm font-normal text-gray-500">
                                    ({{ count($pengaduan->foto_bukti) }} foto)
                                </span>
                            </h3>
                        </div>
                        <div class="p-5">
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                @foreach($pengaduan->foto_bukti as $index => $foto)
                                <div class="relative group cursor-pointer" onclick="openModal('{{ Storage::url($foto) }}')">
                                    <img src="{{ Storage::url($foto) }}" 
                                         alt="Bukti pengaduan {{ $index + 1 }}"
                                         class="w-full h-32 md:h-40 object-cover rounded-lg border border-gray-200 group-hover:border-blue-300 transition-colors">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100">
                                        <i class="fas fa-search-plus text-white text-xl"></i>
                                    </div>
                                    <div class="absolute top-2 left-2 bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded">
                                        {{ $index + 1 }}
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Right Column - Actions -->
                <div class="space-y-6">
                    <!-- Quick Actions -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                        <div class="px-5 py-4 border-b border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-bolt text-yellow-500"></i>
                                Aksi Cepat
                            </h3>
                        </div>
                        <div class="p-5 space-y-3">
                            @if($pengaduan->status == 'diverifikasi')
                            <form action="{{ route('petugas.pengaduan.update.status', $pengaduan) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="diproses">
                                <button type="submit" 
                                        class="w-full px-4 py-3 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg text-sm transition-colors flex items-center justify-center gap-2">
                                    <i class="fas fa-cog"></i>
                                    Proses Pengaduan
                                </button>
                            </form>
                            @endif

                            @if($pengaduan->status == 'diproses')
                            <form action="{{ route('petugas.pengaduan.update.status', $pengaduan) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="selesai">
                                <button type="submit" 
                                        class="w-full px-4 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg text-sm transition-colors flex items-center justify-center gap-2">
                                    <i class="fas fa-check-circle"></i>
                                    Tandai Selesai
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>

                    <!-- Status Update -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                        <div class="px-5 py-4 border-b border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-sync-alt text-blue-500"></i>
                                Update Status
                            </h3>
                        </div>
                        <div class="p-5">
                            <form action="{{ route('petugas.pengaduan.update.status', $pengaduan) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-tag mr-2 text-gray-500 text-sm"></i>
                                            Status
                                        </label>
                                        <select name="status" required
                                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors">
                                            <option value="menunggu" {{ $pengaduan->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                            <option value="diverifikasi" {{ $pengaduan->status == 'diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
                                            <option value="diproses" {{ $pengaduan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                            <option value="selesai" {{ $pengaduan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                            <option value="ditolak" {{ $pengaduan->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-sticky-note mr-2 text-gray-500 text-sm"></i>
                                            Catatan
                                        </label>
                                        <textarea name="catatan" rows="3"
                                                  class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors resize-none"
                                                  placeholder="Tambahkan catatan atau keterangan...">{{ old('catatan') }}</textarea>
                                    </div>
                                    
                                    <button type="submit" 
                                            class="w-full px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm transition-colors flex items-center justify-center gap-2">
                                        <i class="fas fa-save"></i>
                                        Update Status
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Action Form -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                        <div class="px-5 py-4 border-b border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-tools text-green-500"></i>
                                Tindakan & Penanganan
                            </h3>
                        </div>
                        <div class="p-5">
                            <form action="{{ route('petugas.pengaduan.update.tindakan', $pengaduan) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-clipboard-list mr-2 text-gray-500 text-sm"></i>
                                            Deskripsi Tindakan
                                        </label>
                                        <textarea name="tindakan" rows="4" required
                                                  class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors resize-none"
                                                  placeholder="Deskripsikan tindakan yang telah dilakukan...">{{ old('tindakan', $pengaduan->tindakan) }}</textarea>
                                    </div>
                                    
                                    <button type="submit" 
                                            class="w-full px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg text-sm transition-colors flex items-center justify-center gap-2">
                                        <i class="fas fa-check-double"></i>
                                        Simpan Tindakan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                        <div class="px-5 py-4 border-b border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-info-circle text-gray-500"></i>
                                Informasi Tambahan
                            </h3>
                        </div>
                        <div class="p-5">
                            <dl class="space-y-3 text-sm">
                                <div class="flex justify-between py-1.5 border-b border-gray-100">
                                    <dt class="text-gray-600">Tanggal Dibuat</dt>
                                    <dd class="font-medium text-gray-900">{{ $pengaduan->created_at->format('d M Y, H:i') }}</dd>
                                </div>
                                
                                @if($pengaduan->diverifikasi_at)
                                <div class="flex justify-between py-1.5 border-b border-gray-100">
                                    <dt class="text-gray-600">Tanggal Diverifikasi</dt>
                                    <dd class="font-medium text-gray-900">{{ $pengaduan->diverifikasi_at->format('d M Y, H:i') }}</dd>
                                </div>
                                @endif
                                
                                @if($pengaduan->diproses_at)
                                <div class="flex justify-between py-1.5 border-b border-gray-100">
                                    <dt class="text-gray-600">Tanggal Diproses</dt>
                                    <dd class="font-medium text-gray-900">{{ $pengaduan->diproses_at->format('d M Y, H:i') }}</dd>
                                </div>
                                @endif
                                
                                @if($pengaduan->tindakan && $pengaduan->updated_at)
                                <div>
                                    <dt class="text-gray-600 mb-1">Tindakan Terakhir</dt>
                                    <dd class="text-xs text-gray-500 leading-relaxed">{{ Str::limit($pengaduan->tindakan, 100) }}</dd>
                                </div>
                                @endif
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Back Button -->
            <div class="mt-6">
                <a href="{{ route('petugas.pengaduan.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg text-sm transition-colors gap-2">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-75 p-4">
        <div class="relative max-w-4xl max-h-full">
            <button onclick="closeModal()" 
                    class="absolute -top-10 right-0 text-white hover:text-gray-300 text-2xl transition-colors">
                <i class="fas fa-times"></i>
            </button>
            <img id="modalImage" src="" alt="" class="max-w-full max-h-[80vh] rounded-lg shadow-2xl">
        </div>
    </div>

    @push('scripts')
    <script>
        function openModal(src) {
            document.getElementById('modalImage').src = src;
            document.getElementById('imageModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeModal() {
            document.getElementById('imageModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Close modal with Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeModal();
        });

        // Close modal when clicking outside
        document.getElementById('imageModal').addEventListener('click', (e) => {
            if (e.target === document.getElementById('imageModal')) closeModal();
        });
    </script>
    @endpush

    @push('styles')
    <style>
        .overflow-hidden {
            overflow: hidden;
        }
        
        /* Smooth transitions */
        * {
            transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }
        
        /* Scrollbar styling */
        .scrollbar-custom::-webkit-scrollbar {
            width: 6px;
        }
        
        .scrollbar-custom::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }
        
        .scrollbar-custom::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 3px;
        }
        
        .scrollbar-custom::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }
        
        /* Status badge animation */
        .status-badge {
            position: relative;
            overflow: hidden;
        }
        
        .status-badge::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            animation: shimmer 2s infinite;
        }
        
        @keyframes shimmer {
            100% {
                left: 100%;
            }
        }
    </style>
    @endpush
</x-app-layout>