<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-gray-900">
                    Detail Pengaduan
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    {{ $pengaduan->kode_pengaduan }} • {{ $pengaduan->judul }}
                </p>
            </div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $pengaduan->getStatusBadgeClass() }}">
                    {{ ucfirst($pengaduan->status) }}
                </span>
                <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $pengaduan->getPrioritasBadgeClass() }}">
                    {{ ucfirst($pengaduan->prioritas) }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-4 md:py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column - Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Complaint Description -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                        <div class="px-5 py-4 border-b border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-file-alt text-blue-500"></i>
                                Deskripsi Pengaduan
                            </h3>
                        </div>
                        <div class="p-5">
                            <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ $pengaduan->deskripsi }}</p>
                        </div>
                    </div>

                    <!-- Evidence Photos -->
                    @if($pengaduan->foto_bukti && count($pengaduan->foto_bukti) > 0)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                        <div class="px-5 py-4 border-b border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-images text-green-500"></i>
                                Foto Bukti
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
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Management Actions -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                        <div class="px-5 py-4 border-b border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-cogs text-purple-500"></i>
                                Kelola Pengaduan
                            </h3>
                        </div>
                        <div class="p-5 space-y-6">
                            <!-- Status Update Form -->
                            <form action="{{ route('admin.pengaduan.update.status', $pengaduan) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="space-y-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                                                Status Pengaduan
                                            </label>
                                            <select id="status" name="status" required
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors">
                                                <option value="menunggu" {{ $pengaduan->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                                <option value="diverifikasi" {{ $pengaduan->status == 'diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
                                                <option value="diproses" {{ $pengaduan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                                <option value="selesai" {{ $pengaduan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                                <option value="ditolak" {{ $pengaduan->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="prioritas" class="block text-sm font-medium text-gray-700 mb-1">
                                                Tingkat Prioritas
                                            </label>
                                            <select id="prioritas" name="prioritas"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors">
                                                <option value="rendah" {{ $pengaduan->prioritas == 'rendah' ? 'selected' : '' }}>Rendah</option>
                                                <option value="sedang" {{ $pengaduan->prioritas == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                                <option value="tinggi" {{ $pengaduan->prioritas == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                                                <option value="darurat" {{ $pengaduan->prioritas == 'darurat' ? 'selected' : '' }}>Darurat</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label for="catatan_admin" class="block text-sm font-medium text-gray-700 mb-1">
                                            Catatan Admin
                                        </label>
                                        <textarea id="catatan_admin" name="catatan_admin" rows="3"
                                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors resize-none"
                                                  placeholder="Berikan catatan atau instruksi...">{{ old('catatan_admin', $pengaduan->catatan_admin) }}</textarea>
                                    </div>
                                    
                                    <div class="flex justify-end">
                                        <button type="submit" 
                                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm transition-colors flex items-center gap-2">
                                            <i class="fas fa-save"></i>
                                            Perbarui Status
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <!-- Assign Officer -->
                            @if(in_array($pengaduan->status, ['diverifikasi', 'diproses']))
                            <form action="{{ route('admin.pengaduan.assign.petugas', $pengaduan) }}" method="POST" class="border-t border-gray-100 pt-6">
                                @csrf
                                @method('PUT')
                                <div class="space-y-3">
                                    <label class="block text-sm font-medium text-gray-700">
                                        <i class="fas fa-user-tie mr-2 text-gray-500"></i>
                                        Assign Petugas
                                    </label>
                                    <div class="flex gap-2">
                                        <select id="petugas_id" name="petugas_id"
                                                class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors">
                                            <option value="">Pilih Petugas...</option>
                                            @foreach($petugas as $p)
                                            <option value="{{ $p->id }}" {{ $pengaduan->petugas_id == $p->id ? 'selected' : '' }}>
                                                {{ $p->name }} • {{ $p->jabatan ?? 'Petugas' }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <button type="submit" 
                                                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg text-sm transition-colors flex items-center gap-2">
                                            <i class="fas fa-user-check"></i>
                                            Assign
                                        </button>
                                    </div>
                                </div>
                            </form>
                            @endif

                            <!-- Quick Action Buttons -->
                            <div class="border-t border-gray-100 pt-6">
                                <div class="flex flex-wrap gap-2">
                                    @if($pengaduan->status === 'menunggu')
                                    <form action="{{ route('admin.pengaduan.verifikasi', $pengaduan) }}" method="POST" class="flex-1 min-w-[150px]">
                                        @csrf
                                        <button type="submit" 
                                                class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg text-sm transition-colors flex items-center justify-center gap-2">
                                            <i class="fas fa-check-circle"></i>
                                            Verifikasi
                                        </button>
                                    </form>
                                    @endif

                                    @if($pengaduan->status === 'diproses')
                                    <form action="{{ route('admin.pengaduan.selesai', $pengaduan) }}" method="POST" class="flex-1 min-w-[150px]">
                                        @csrf
                                        <button type="submit" 
                                                class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm transition-colors flex items-center justify-center gap-2">
                                            <i class="fas fa-flag-checkered"></i>
                                            Tandai Selesai
                                        </button>
                                    </form>
                                    @endif

                                    <form action="{{ route('admin.pengaduan.tolak', $pengaduan) }}" method="POST" class="flex-1 min-w-full md:min-w-[250px]">
                                        @csrf
                                        <div class="space-y-2">
                                            <input type="text" name="catatan_admin" required
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm transition-colors"
                                                   placeholder="Alasan penolakan...">
                                            <button type="submit" 
                                                    class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg text-sm transition-colors flex items-center justify-center gap-2"
                                                    onclick="return confirm('Yakin menolak pengaduan ini?')">
                                                <i class="fas fa-times-circle"></i>
                                                Tolak Pengaduan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Resolution Section -->
                    @if($pengaduan->tindakan || ($pengaduan->foto_penanganan && count($pengaduan->foto_penanganan) > 0))
                    <div class="bg-white rounded-xl shadow-sm border border-green-200">
                        <div class="px-5 py-4 border-b border-green-100 bg-green-50 rounded-t-xl">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-tasks text-green-600"></i>
                                Penanganan & Tindakan
                            </h3>
                        </div>
                        <div class="p-5 space-y-4">
                            @if($pengaduan->tindakan)
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Tindakan yang Dilakukan</h4>
                                <p class="text-gray-700 whitespace-pre-line bg-green-50 p-3 rounded-lg">{{ $pengaduan->tindakan }}</p>
                            </div>
                            @endif

                            @if($pengaduan->foto_penanganan && count($pengaduan->foto_penanganan) > 0)
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Foto Penanganan</h4>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                    @foreach($pengaduan->foto_penanganan as $index => $foto)
                                    <div class="relative group cursor-pointer" onclick="openModal('{{ Storage::url($foto) }}')">
                                        <img src="{{ Storage::url($foto) }}" 
                                             alt="Penanganan {{ $index + 1 }}"
                                             class="w-full h-32 md:h-40 object-cover rounded-lg border border-green-200 group-hover:border-green-300 transition-colors">
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100">
                                            <i class="fas fa-search-plus text-white text-xl"></i>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Right Column - Sidebar -->
                <div class="space-y-6">
                    <!-- Complaint Information -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                        <div class="px-5 py-4 border-b border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-info-circle text-blue-500"></i>
                                Informasi Pengaduan
                            </h3>
                        </div>
                        <div class="p-5">
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</dt>
                                    <dd class="text-sm font-medium text-gray-900 mt-0.5">{{ $pengaduan->kategori->nama_kategori }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</dt>
                                    <dd class="text-sm font-medium text-gray-900 mt-0.5">{{ $pengaduan->lokasi }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Kejadian</dt>
                                    <dd class="text-sm font-medium text-gray-900 mt-0.5">{{ $pengaduan->tanggal_kejadian->format('d F Y') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat Pada</dt>
                                    <dd class="text-sm font-medium text-gray-900 mt-0.5">{{ $pengaduan->created_at->format('d M Y, H:i') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Reporter Information -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                        <div class="px-5 py-4 border-b border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-user text-blue-500"></i>
                                Informasi Pelapor
                            </h3>
                        </div>
                        <div class="p-5">
                            <div class="flex items-start gap-3 mb-4">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center text-lg font-semibold">
                                        {{ substr($pengaduan->user->name, 0, 1) }}
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $pengaduan->user->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ $pengaduan->user->email }}</p>
                                </div>
                            </div>
                            
                            <dl class="space-y-2 text-sm">
                                <div class="flex justify-between py-1.5 border-b border-gray-100">
                                    <dt class="text-gray-600">NIK:</dt>
                                    <dd class="font-medium text-gray-900">{{ $pengaduan->user->nik }}</dd>
                                </div>
                                <div class="flex justify-between py-1.5 border-b border-gray-100">
                                    <dt class="text-gray-600">Telepon:</dt>
                                    <dd class="font-medium text-gray-900">{{ $pengaduan->user->telepon }}</dd>
                                </div>
                                <div class="pt-1.5">
                                    <dt class="text-gray-600 mb-1">Alamat:</dt>
                                    <dd class="text-gray-900 text-xs leading-relaxed">{{ $pengaduan->user->alamat }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Assigned Officer -->
                    @if($pengaduan->petugas)
                    <div class="bg-white rounded-xl shadow-sm border border-green-200">
                        <div class="px-5 py-4 border-b border-green-100 bg-green-50 rounded-t-xl">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-user-tie text-green-600"></i>
                                Petugas Penanggung Jawab
                            </h3>
                        </div>
                        <div class="p-5">
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center text-lg font-semibold">
                                        {{ substr($pengaduan->petugas->name, 0, 1) }}
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $pengaduan->petugas->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ $pengaduan->petugas->email }}</p>
                                    <p class="text-xs text-green-600 font-medium mt-1">
                                        {{ $pengaduan->petugas->jabatan ?? 'Petugas' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Timeline -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                        <div class="px-5 py-4 border-b border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-history text-gray-500"></i>
                                Timeline Status
                            </h3>
                        </div>
                        <div class="p-5">
                            <div class="space-y-3">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-600">Dibuat</span>
                                    <span class="font-medium text-gray-900">{{ $pengaduan->created_at->format('d M Y, H:i') }}</span>
                                </div>
                                
                                @if($pengaduan->diverifikasi_at)
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-600">Diverifikasi</span>
                                    <span class="font-medium text-gray-900">{{ $pengaduan->diverifikasi_at->format('d M Y, H:i') }}</span>
                                </div>
                                @endif
                                
                                @if($pengaduan->diproses_at)
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-600">Diproses</span>
                                    <span class="font-medium text-gray-900">{{ $pengaduan->diproses_at->format('d M Y, H:i') }}</span>
                                </div>
                                @endif
                                
                                @if($pengaduan->selesai_at)
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-600">Selesai</span>
                                    <span class="font-medium text-gray-900">{{ $pengaduan->selesai_at->format('d M Y, H:i') }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Back Button -->
            <div class="mt-6">
                <a href="{{ route('admin.pengaduan.index') }}" 
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
    </style>
    @endpush
</x-app-layout>