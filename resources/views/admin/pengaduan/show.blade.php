@php
    // Helper functions untuk konsistensi
    if (!function_exists('getPengaduanBadgeClass')) {
        function getPengaduanBadgeClass($status) {
            $badgeClasses = [
                'menunggu' => 'badge-menunggu',
                'diverifikasi' => 'badge-diajukan',
                'diproses' => 'badge-diproses',
                'selesai' => 'badge-selesai',
                'ditolak' => 'badge-ditolak'
            ];
            return $badgeClasses[$status] ?? 'badge-draft';
        }
    }
    
    if (!function_exists('getPrioritasClass')) {
        function getPrioritasClass($prioritas) {
            $classes = [
                'rendah' => 'bg-gray-100 text-gray-800',
                'sedang' => 'bg-yellow-100 text-yellow-800',
                'tinggi' => 'bg-orange-100 text-orange-800',
                'darurat' => 'bg-red-100 text-red-800'
            ];
            return $classes[$prioritas] ?? 'bg-gray-100 text-gray-800';
        }
    }
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    Detail Pengaduan
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    {{ $pengaduan->kode_pengaduan }} • {{ $pengaduan->judul }}
                </p>
            </div>
            <div class="flex items-center gap-2">
                <span class="badge {{ getPengaduanBadgeClass($pengaduan->status) }}">
                    {{ ucfirst($pengaduan->status) }}
                </span>
                <span class="badge {{ getPrioritasClass($pengaduan->prioritas) }}">
                    {{ ucfirst($pengaduan->prioritas) }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Complaint Description -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-file-alt text-blue-500"></i>
                            Deskripsi Pengaduan
                        </h3>
                    </div>
                    <div class="card-body">
                        <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ $pengaduan->deskripsi }}</p>
                    </div>
                </div>

                <!-- Evidence Photos -->
                @if($pengaduan->foto_bukti && count($pengaduan->foto_bukti) > 0)
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-images text-green-500"></i>
                            Foto Bukti
                            <span class="text-sm font-normal text-gray-500">
                                ({{ count($pengaduan->foto_bukti) }} foto)
                            </span>
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($pengaduan->foto_bukti as $index => $foto)
                            <div class="relative group cursor-pointer" onclick="openModal('{{ Storage::url($foto) }}')">
                                <img src="{{ Storage::url($foto) }}" 
                                     alt="Bukti pengaduan {{ $index + 1 }}"
                                     class="w-full h-40 object-cover rounded-lg border border-gray-200 group-hover:border-blue-300 transition-colors">
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-all rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100">
                                    <div class="bg-white/80 p-2 rounded-full">
                                        <i class="fas fa-search-plus text-gray-700"></i>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- Management Actions -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-cogs text-purple-500"></i>
                            Kelola Pengaduan
                        </h3>
                    </div>
                    <div class="p-5 space-y-5">
                        <!-- Status Update Form -->
                        <form action="{{ route('admin.pengaduan.update.status', $pengaduan) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                            Status Pengaduan
                                        </label>
                                        <select id="status" name="status" required
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                            <option value="menunggu" {{ $pengaduan->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                            <option value="diverifikasi" {{ $pengaduan->status == 'diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
                                            <option value="diproses" {{ $pengaduan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                            <option value="selesai" {{ $pengaduan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                            <option value="ditolak" {{ $pengaduan->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="prioritas" class="block text-sm font-medium text-gray-700 mb-2">
                                            Tingkat Prioritas
                                        </label>
                                        <select id="prioritas" name="prioritas"
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                            <option value="rendah" {{ $pengaduan->prioritas == 'rendah' ? 'selected' : '' }}>Rendah</option>
                                            <option value="sedang" {{ $pengaduan->prioritas == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                            <option value="tinggi" {{ $pengaduan->prioritas == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                                            <option value="darurat" {{ $pengaduan->prioritas == 'darurat' ? 'selected' : '' }}>Darurat</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="catatan_admin" class="block text-sm font-medium text-gray-700 mb-2">
                                        Catatan Admin
                                    </label>
                                    <textarea id="catatan_admin" name="catatan_admin" rows="3"
                                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm resize-none"
                                              placeholder="Berikan catatan atau instruksi...">{{ old('catatan_admin', $pengaduan->catatan_admin) }}</textarea>
                                </div>
                                
                                <div class="flex justify-end">
                                    <button type="submit" 
                                            class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm transition-colors flex items-center gap-2">
                                        <i class="fas fa-save"></i>
                                        Perbarui Status
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Assign Officer -->
                        @if(in_array($pengaduan->status, ['diverifikasi', 'diproses']))
                        <form action="{{ route('admin.pengaduan.assign.petugas', $pengaduan) }}" method="POST" class="border-t border-gray-100 pt-5">
                            @csrf
                            @method('PUT')
                            <div class="space-y-3">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-user-tie mr-2 text-gray-500"></i>
                                    Assign Petugas
                                </label>
                                <div class="flex gap-3">
                                    <select id="petugas_id" name="petugas_id"
                                            class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                        <option value="">Pilih Petugas...</option>
                                        @foreach($petugas as $p)
                                        <option value="{{ $p->id }}" {{ $pengaduan->petugas_id == $p->id ? 'selected' : '' }}>
                                            {{ $p->name }} • {{ $p->jabatan ?? 'Petugas' }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" 
                                            class="px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg text-sm transition-colors flex items-center gap-2 whitespace-nowrap">
                                        <i class="fas fa-user-check"></i>
                                        Assign
                                    </button>
                                </div>
                            </div>
                        </form>
                        @endif

                        <!-- Quick Action Buttons -->
                        <div class="border-t border-gray-100 pt-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @if($pengaduan->status === 'menunggu')
                                <form action="{{ route('admin.pengaduan.verifikasi', $pengaduan) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg text-sm transition-colors flex items-center justify-center gap-2">
                                        <i class="fas fa-check-circle"></i>
                                        Verifikasi
                                    </button>
                                </form>
                                @endif

                                @if($pengaduan->status === 'diproses')
                                <form action="{{ route('admin.pengaduan.selesai', $pengaduan) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm transition-colors flex items-center justify-center gap-2">
                                        <i class="fas fa-flag-checkered"></i>
                                        Tandai Selesai
                                    </button>
                                </form>
                                @endif

                                <div class="md:col-span-2">
                                    <form action="{{ route('admin.pengaduan.tolak', $pengaduan) }}" method="POST">
                                        @csrf
                                        <div class="space-y-3">
                                            <input type="text" name="catatan_admin" required
                                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm"
                                                   placeholder="Alasan penolakan...">
                                            <button type="submit" 
                                                    class="w-full px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg text-sm transition-colors flex items-center justify-center gap-2"
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
                </div>

                <!-- Resolution Section -->
                @if($pengaduan->tindakan || ($pengaduan->foto_penanganan && count($pengaduan->foto_penanganan) > 0))
                <div class="card border-green-200">
                    <div class="card-header bg-green-50 border-green-100">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-tasks text-green-600"></i>
                            Penanganan & Tindakan
                        </h3>
                    </div>
                    <div class="p-5 space-y-5">
                        @if($pengaduan->tindakan)
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Tindakan yang Dilakukan</h4>
                            <p class="text-gray-700 whitespace-pre-line bg-green-50 p-4 rounded-lg">{{ $pengaduan->tindakan }}</p>
                        </div>
                        @endif

                        @if($pengaduan->foto_penanganan && count($pengaduan->foto_penanganan) > 0)
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Foto Penanganan</h4>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach($pengaduan->foto_penanganan as $index => $foto)
                                <div class="relative group cursor-pointer" onclick="openModal('{{ Storage::url($foto) }}')">
                                    <img src="{{ Storage::url($foto) }}" 
                                         alt="Penanganan {{ $index + 1 }}"
                                         class="w-full h-40 object-cover rounded-lg border border-green-200 group-hover:border-green-300 transition-colors">
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-all rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100">
                                        <div class="bg-white/80 p-2 rounded-full">
                                            <i class="fas fa-search-plus text-gray-700"></i>
                                        </div>
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
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-info-circle text-blue-500"></i>
                            Informasi Pengaduan
                        </h3>
                    </div>
                    <div class="p-5">
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Kategori</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $pengaduan->kategori->nama_kategori ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Lokasi</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $pengaduan->lokasi }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Tanggal Kejadian</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $pengaduan->tanggal_kejadian->format('d F Y') }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Dibuat Pada</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $pengaduan->created_at->format('d M Y, H:i') }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Reporter Information -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-user text-blue-500"></i>
                            Informasi Pelapor
                        </h3>
                    </div>
                    <div class="p-5">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center text-lg font-semibold">
                                    {{ substr($pengaduan->user->name ?? '?', 0, 1) }}
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ $pengaduan->user->name ?? '-' }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ $pengaduan->user->email ?? '-' }}</p>
                            </div>
                        </div>
                        
                        <dl class="space-y-3 text-sm">
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <dt class="text-gray-600">NIK:</dt>
                                <dd class="font-medium text-gray-900">{{ $pengaduan->user->nik ?? '-' }}</dd>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <dt class="text-gray-600">Telepon:</dt>
                                <dd class="font-medium text-gray-900">{{ $pengaduan->user->telepon ?? '-' }}</dd>
                            </div>
                            <div class="pt-2">
                                <dt class="text-gray-600 mb-2">Alamat:</dt>
                                <dd class="text-gray-900 text-xs leading-relaxed">{{ $pengaduan->user->alamat ?? '-' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Assigned Officer -->
                @if($pengaduan->petugas)
                <div class="card border-green-200">
                    <div class="card-header bg-green-50 border-green-100">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-user-tie text-green-600"></i>
                            Petugas Penanggung Jawab
                        </h3>
                    </div>
                    <div class="p-5">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-green-100 text-green-600 rounded-lg flex items-center justify-center text-lg font-semibold">
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
                <div class="card">
                    <div class="card-header">
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
        <div>
            <a href="{{ route('admin.pengaduan.index') }}" 
               class="inline-flex items-center px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg text-sm transition-colors gap-2">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Daftar
            </a>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/75 p-4">
        <div class="relative max-w-4xl max-h-full">
            <button onclick="closeModal()" 
                    class="absolute -top-12 right-0 text-white hover:text-gray-300 text-2xl transition-colors">
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
</x-app-layout>