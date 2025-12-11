<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
                    <i class="fas fa-info-circle mr-2 text-blue-600"></i>Detail Pengaduan
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
                            <h1 class="text-2xl font-bold text-gray-900">{{ $pengaduan->judul }}</h1>
                            <div class="flex flex-wrap items-center gap-2 mt-2">
                                <span class="px-3 py-1.5 text-sm font-semibold rounded-full {{ $pengaduan->getStatusBadgeClass() }}">
                                    <i class="fas fa-circle text-xs mr-1.5"></i>
                                    {{ ucfirst($pengaduan->status) }}
                                </span>
                                <span class="px-3 py-1.5 text-sm font-semibold rounded-full {{ $pengaduan->getPrioritasBadgeClass() }}">
                                    <i class="fas fa-exclamation-triangle text-xs mr-1.5"></i>
                                    {{ ucfirst($pengaduan->prioritas) }}
                                </span>
                                <span class="text-sm text-gray-600">
                                    <i class="far fa-calendar-alt mr-1.5"></i>
                                    {{ $pengaduan->created_at->format('d F Y') }}
                                </span>
                            </div>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('warga.pengaduan.index') }}" 
                               class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg transition duration-200 flex items-center card-hover">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Kembali
                            </a>
                            @if($pengaduan->status === 'menunggu')
                            <a href="{{ route('warga.pengaduan.edit', $pengaduan) }}" 
                               class="bg-yellow-100 hover:bg-yellow-200 text-yellow-700 font-medium py-2 px-4 rounded-lg transition duration-200 flex items-center card-hover">
                                <i class="fas fa-edit mr-2"></i>
                                Edit
                            </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Left Column: Main Content -->
                        <div class="lg:col-span-2 space-y-6">
                            <!-- Deskripsi Section -->
                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-lg p-5">
                                <div class="flex items-center mb-4">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-align-left text-blue-600"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900">Deskripsi Pengaduan</h3>
                                </div>
                                <div class="bg-white rounded-lg p-4">
                                    <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ $pengaduan->deskripsi }}</p>
                                </div>
                            </div>

                            <!-- Foto Bukti Section -->
                            @if($pengaduan->foto_bukti && count($pengaduan->foto_bukti) > 0)
                            <div class="border border-gray-200 rounded-lg p-5">
                                <div class="flex items-center mb-4">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-images text-green-600"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900">Foto Bukti</h3>
                                    <span class="ml-auto px-2.5 py-1 text-xs font-medium bg-gray-100 text-gray-700 rounded-full">
                                        {{ count($pengaduan->foto_bukti) }} foto
                                    </span>
                                </div>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                    @foreach($pengaduan->foto_bukti as $index => $foto)
                                    <div class="relative group cursor-pointer card-hover" onclick="openModal('{{ Storage::url($foto) }}')">
                                        <img src="{{ Storage::url($foto) }}" 
                                             alt="Foto bukti {{ $index + 1 }}"
                                             class="w-full h-40 object-cover rounded-lg transition duration-200 group-hover:opacity-90">
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition duration-200 rounded-lg"></div>
                                        <div class="absolute bottom-2 right-2 bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded-full">
                                            <i class="fas fa-search-plus mr-1"></i>Preview
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <!-- Foto Penanganan Section -->
                            @if($pengaduan->foto_penanganan && count($pengaduan->foto_penanganan) > 0)
                            <div class="border border-green-200 rounded-lg p-5 bg-gradient-to-br from-green-50 to-green-100">
                                <div class="flex items-center mb-4">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-check-circle text-green-600"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900">Foto Penanganan</h3>
                                    <span class="ml-auto px-2.5 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">
                                        {{ count($pengaduan->foto_penanganan) }} foto
                                    </span>
                                </div>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                    @foreach($pengaduan->foto_penanganan as $index => $foto)
                                    <div class="relative group cursor-pointer card-hover" onclick="openModal('{{ Storage::url($foto) }}')">
                                        <img src="{{ Storage::url($foto) }}" 
                                             alt="Foto penanganan {{ $index + 1 }}"
                                             class="w-full h-40 object-cover rounded-lg transition duration-200 group-hover:opacity-90">
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition duration-200 rounded-lg"></div>
                                        <div class="absolute bottom-2 right-2 bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded-full">
                                            <i class="fas fa-search-plus mr-1"></i>Preview
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <!-- Tindakan Section -->
                            @if($pengaduan->tindakan)
                            <div class="border border-blue-200 rounded-lg p-5 bg-gradient-to-br from-blue-50 to-blue-100">
                                <div class="flex items-center mb-4">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-cog text-blue-600"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900">Tindakan yang Dilakukan</h3>
                                </div>
                                <div class="bg-white rounded-lg p-4">
                                    <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ $pengaduan->tindakan }}</p>
                                </div>
                            </div>
                            @endif

                            <!-- Catatan Admin Section -->
                            @if($pengaduan->catatan_admin)
                            <div class="border border-yellow-200 rounded-lg p-5 bg-gradient-to-br from-yellow-50 to-yellow-100">
                                <div class="flex items-center mb-4">
                                    <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-sticky-note text-yellow-600"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900">Catatan Admin</h3>
                                </div>
                                <div class="bg-white rounded-lg p-4">
                                    <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ $pengaduan->catatan_admin }}</p>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Right Column: Sidebar Info -->
                        <div class="space-y-6">
                            <!-- Informasi Pengaduan Card -->
                            <div class="border border-gray-200 rounded-lg p-5">
                                <div class="flex items-center mb-4">
                                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-info-circle text-gray-600"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900">Informasi</h3>
                                </div>
                                <div class="space-y-4">
                                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                        <i class="fas fa-tag text-gray-400 mr-3 w-5"></i>
                                        <div>
                                            <p class="text-xs text-gray-500">Kategori</p>
                                            <p class="text-sm font-medium text-gray-900">{{ $pengaduan->kategori->nama_kategori }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                        <i class="fas fa-map-marker-alt text-gray-400 mr-3 w-5"></i>
                                        <div>
                                            <p class="text-xs text-gray-500">Lokasi</p>
                                            <p class="text-sm font-medium text-gray-900">{{ $pengaduan->lokasi }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                        <i class="fas fa-calendar-day text-gray-400 mr-3 w-5"></i>
                                        <div>
                                            <p class="text-xs text-gray-500">Tanggal Kejadian</p>
                                            <p class="text-sm font-medium text-gray-900">{{ $pengaduan->tanggal_kejadian->format('d F Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                        <i class="fas fa-paper-plane text-gray-400 mr-3 w-5"></i>
                                        <div>
                                            <p class="text-xs text-gray-500">Dilaporkan</p>
                                            <p class="text-sm font-medium text-gray-900">{{ $pengaduan->created_at->format('d F Y H:i') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Status Timeline Card -->
                            <div class="border border-gray-200 rounded-lg p-5">
                                <div class="flex items-center mb-4">
                                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-history text-purple-600"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900">Status Timeline</h3>
                                </div>
                                <div class="space-y-6">
                                    @php
                                        $timeline = [
                                            'menunggu' => [
                                                'icon' => 'far fa-clock',
                                                'label' => 'Menunggu',
                                                'color' => 'text-yellow-500 bg-yellow-100',
                                                'time' => $pengaduan->created_at
                                            ],
                                            'diverifikasi' => [
                                                'icon' => 'fas fa-user-check',
                                                'label' => 'Diverifikasi',
                                                'color' => 'text-blue-500 bg-blue-100',
                                                'time' => $pengaduan->diverifikasi_at
                                            ],
                                            'diproses' => [
                                                'icon' => 'fas fa-cogs',
                                                'label' => 'Diproses',
                                                'color' => 'text-purple-500 bg-purple-100',
                                                'time' => $pengaduan->diproses_at
                                            ],
                                            'selesai' => [
                                                'icon' => 'fas fa-check-circle',
                                                'label' => 'Selesai',
                                                'color' => 'text-green-500 bg-green-100',
                                                'time' => $pengaduan->selesai_at
                                            ]
                                        ];
                                        
                                        $statusOrder = ['menunggu', 'diverifikasi', 'diproses', 'selesai'];
                                        $currentStatus = $pengaduan->status;
                                        $currentIndex = array_search($currentStatus, $statusOrder);
                                    @endphp

                                    @foreach($statusOrder as $status)
                                        @php
                                            $data = $timeline[$status];
                                            $isCompleted = array_search($status, $statusOrder) <= $currentIndex;
                                            $isCurrent = $status === $currentStatus;
                                        @endphp
                                        <div class="relative">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 z-10">
                                                    <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $isCompleted ? $data['color'] : 'bg-gray-200 text-gray-400' }}">
                                                        <i class="{{ $data['icon'] }}"></i>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="flex items-center">
                                                        <p class="text-sm font-medium {{ $isCompleted ? 'text-gray-900' : 'text-gray-500' }}">
                                                            {{ $data['label'] }}
                                                        </p>
                                                        @if($isCurrent)
                                                        <span class="ml-2 px-2 py-0.5 text-xs font-medium rounded-full bg-blue-100 text-blue-700">
                                                            Sedang Berjalan
                                                        </span>
                                                        @endif
                                                    </div>
                                                    @if($data['time'])
                                                    <p class="text-xs {{ $isCompleted ? 'text-gray-600' : 'text-gray-400' }}">
                                                        <i class="far fa-clock mr-1"></i>
                                                        {{ $data['time']->format('d M Y H:i') }}
                                                    </p>
                                                    @elseif($isCurrent)
                                                    <p class="text-xs text-gray-500">
                                                        <i class="far fa-clock mr-1"></i>
                                                        Dalam proses
                                                    </p>
                                                    @endif
                                                </div>
                                            </div>
                                            @if(!$loop->last)
                                            <div class="absolute left-5 top-10 bottom-0 w-0.5 bg-gray-200"></div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Petugas Penanggung Jawab Card -->
                            @if($pengaduan->petugas)
                            <div class="border border-blue-200 rounded-lg p-5 bg-gradient-to-br from-blue-50 to-blue-100">
                                <div class="flex items-center mb-4">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-user-tie text-blue-600"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900">Petugas Penanggung Jawab</h3>
                                </div>
                                <div class="bg-white rounded-lg p-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-semibold text-lg">
                                                {{ substr($pengaduan->petugas->name, 0, 1) }}
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <p class="font-medium text-gray-900">{{ $pengaduan->petugas->name }}</p>
                                            <p class="text-sm text-gray-600 mt-1">
                                                <i class="fas fa-envelope mr-2 text-gray-400"></i>
                                                {{ $pengaduan->petugas->email }}
                                            </p>
                                            @if($pengaduan->petugas->no_hp)
                                            <p class="text-sm text-gray-600 mt-1">
                                                <i class="fas fa-phone mr-2 text-gray-400"></i>
                                                {{ $pengaduan->petugas->no_hp }}
                                            </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Quick Actions -->
                            <div class="border border-gray-200 rounded-lg p-5">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
                                <div class="space-y-3">
                                    <a href="{{ route('warga.pengaduan.index') }}" 
                                       class="flex items-center justify-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition duration-200">
                                        <i class="fas fa-list mr-3 text-gray-500"></i>
                                        <span class="font-medium">Lihat Semua Pengaduan</span>
                                    </a>
                                    @if($pengaduan->status === 'menunggu')
                                    <a href="{{ route('warga.pengaduan.edit', $pengaduan) }}" 
                                       class="flex items-center justify-center p-3 border border-yellow-300 rounded-lg hover:bg-yellow-50 transition duration-200">
                                        <i class="fas fa-edit mr-3 text-yellow-600"></i>
                                        <span class="font-medium">Edit Pengaduan</span>
                                    </a>
                                    @endif
                                    @if(auth()->user()->isAdmin() || auth()->user()->isPetugas())
                                    <a href="{{ route('petugas.pengaduan.index') }}" 
                                       class="flex items-center justify-center p-3 border border-blue-300 rounded-lg hover:bg-blue-50 transition duration-200">
                                        <i class="fas fa-cog mr-3 text-blue-600"></i>
                                        <span class="font-medium">Kelola Pengaduan</span>
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-90 flex items-center justify-center z-50 hidden p-4">
        <div class="relative max-w-5xl max-h-[90vh]">
            <img id="modalImage" src="" alt="" class="max-w-full max-h-[80vh] object-contain rounded-lg shadow-2xl">
            <button onclick="closeModal()" 
                    class="absolute -top-12 right-0 text-white text-2xl hover:text-gray-300 transition duration-200 bg-black bg-opacity-50 rounded-full w-10 h-10 flex items-center justify-center">
                <i class="fas fa-times"></i>
            </button>
            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-black bg-opacity-50 text-white px-4 py-2 rounded-full text-sm">
                Klik di luar gambar untuk menutup
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
        
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        function openModal(src) {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            modalImage.src = src;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modal on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });

        // Close modal on background click
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this || e.target.id === 'modalImage') {
                closeModal();
            }
        });

        // Smooth scroll for page
        document.addEventListener('DOMContentLoaded', function() {
            // Add loading animation to images
            const images = document.querySelectorAll('img');
            images.forEach(img => {
                img.addEventListener('load', function() {
                    this.classList.add('loaded');
                });
            });
        });
    </script>
    @endpush
</x-app-layout>