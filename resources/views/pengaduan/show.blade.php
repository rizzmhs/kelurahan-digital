<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Pengaduan - {{ $pengaduan->kode_pengaduan }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Header Info -->
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $pengaduan->judul }}</h1>
                            <p class="text-gray-600 mt-1">Kode: {{ $pengaduan->kode_pengaduan }}</p>
                        </div>
                        <div class="text-right">
                            <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $pengaduan->getStatusBadgeClass() }}">
                                {{ ucfirst($pengaduan->status) }}
                            </span>
                            <span class="ml-2 px-3 py-1 text-sm font-semibold rounded-full {{ $pengaduan->getPrioritasBadgeClass() }}">
                                {{ ucfirst($pengaduan->prioritas) }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Main Content -->
                        <div class="lg:col-span-2 space-y-6">
                            <!-- Deskripsi -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Deskripsi Pengaduan</h3>
                                <p class="text-gray-700 whitespace-pre-line">{{ $pengaduan->deskripsi }}</p>
                            </div>

                            <!-- Foto Bukti -->
                            @if($pengaduan->foto_bukti && count($pengaduan->foto_bukti) > 0)
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-3">Foto Bukti</h3>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                    @foreach($pengaduan->foto_bukti as $foto)
                                    <div class="relative group">
                                        <img src="{{ Storage::url($foto) }}" alt="Foto bukti" 
                                             class="w-full h-32 object-cover rounded-lg cursor-pointer"
                                             onclick="openModal('{{ Storage::url($foto) }}')">
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition duration-200 rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100">
                                            <button onclick="openModal('{{ Storage::url($foto) }}')" class="bg-white bg-opacity-90 p-2 rounded-full">
                                                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m0 0l3-3m-3 3l-3-3"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <!-- Foto Penanganan -->
                            @if($pengaduan->foto_penanganan && count($pengaduan->foto_penanganan) > 0)
                            <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                                <h3 class="text-lg font-medium text-gray-900 mb-3">Foto Penanganan</h3>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                    @foreach($pengaduan->foto_penanganan as $foto)
                                    <div class="relative group">
                                        <img src="{{ Storage::url($foto) }}" alt="Foto penanganan" 
                                             class="w-full h-32 object-cover rounded-lg cursor-pointer"
                                             onclick="openModal('{{ Storage::url($foto) }}')">
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition duration-200 rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100">
                                            <button onclick="openModal('{{ Storage::url($foto) }}')" class="bg-white bg-opacity-90 p-2 rounded-full">
                                                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m0 0l3-3m-3 3l-3-3"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <!-- Tindakan -->
                            @if($pengaduan->tindakan)
                            <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Tindakan yang Dilakukan</h3>
                                <p class="text-gray-700 whitespace-pre-line">{{ $pengaduan->tindakan }}</p>
                            </div>
                            @endif

                            <!-- Catatan Admin -->
                            @if($pengaduan->catatan_admin)
                            <div class="bg-yellow-50 rounded-lg p-4 border border-yellow-200">
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Catatan Admin</h3>
                                <p class="text-gray-700 whitespace-pre-line">{{ $pengaduan->catatan_admin }}</p>
                            </div>
                            @endif
                        </div>

                        <!-- Sidebar Info -->
                        <div class="space-y-6">
                            <!-- Informasi Pengaduan -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-3">Informasi Pengaduan</h3>
                                <dl class="space-y-2">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-600">Kategori</dt>
                                        <dd class="text-sm text-gray-900">{{ $pengaduan->kategori->nama_kategori }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-600">Lokasi</dt>
                                        <dd class="text-sm text-gray-900">{{ $pengaduan->lokasi }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-600">Tanggal Kejadian</dt>
                                        <dd class="text-sm text-gray-900">{{ $pengaduan->tanggal_kejadian->format('d F Y') }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-600">Tanggal Dilaporkan</dt>
                                        <dd class="text-sm text-gray-900">{{ $pengaduan->created_at->format('d F Y H:i') }}</dd>
                                    </div>
                                </dl>
                            </div>

                            <!-- Status Timeline -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-3">Status Timeline</h3>
                                <div class="space-y-4">
                                    @php
                                        $timeline = [
                                            'menunggu' => ['icon' => '⏳', 'label' => 'Menunggu', 'time' => $pengaduan->created_at],
                                            'diverifikasi' => ['icon' => '✅', 'label' => 'Diverifikasi', 'time' => $pengaduan->diverifikasi_at],
                                            'diproses' => ['icon' => '🔄', 'label' => 'Diproses', 'time' => $pengaduan->diproses_at],
                                            'selesai' => ['icon' => '🎉', 'label' => 'Selesai', 'time' => $pengaduan->selesai_at],
                                        ];
                                        
                                        $currentStatus = $pengaduan->status;
                                        $statusOrder = ['menunggu', 'diverifikasi', 'diproses', 'selesai'];
                                        $currentIndex = array_search($currentStatus, $statusOrder);
                                    @endphp

                                    @foreach($timeline as $status => $data)
                                        @php
                                            $isCompleted = array_search($status, $statusOrder) <= $currentIndex;
                                            $isCurrent = $status === $currentStatus;
                                        @endphp
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <div class="w-8 h-8 rounded-full flex items-center justify-center 
                                                    {{ $isCompleted ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-500' }}">
                                                    {{ $data['icon'] }}
                                                </div>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium {{ $isCompleted ? 'text-gray-900' : 'text-gray-500' }}">
                                                    {{ $data['label'] }}
                                                </p>
                                                @if($data['time'])
                                                    <p class="text-xs text-gray-500">
                                                        {{ $data['time']->format('d M Y H:i') }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                        @if(!$loop->last)
                                            <div class="ml-4 border-l-2 border-gray-300 h-4"></div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <!-- Petugas Penanggung Jawab -->
                            @if($pengaduan->petugas)
                            <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Petugas Penanggung Jawab</h3>
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-semibold">
                                            {{ substr($pengaduan->petugas->name, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $pengaduan->petugas->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $pengaduan->petugas->email }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="flex flex-col space-y-2">
                                <a href="{{ route('warga.pengaduan.index') }}" class="w-full bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded-md text-center">
                                    Kembali ke Daftar
                                </a>
                                @if($pengaduan->status === 'menunggu')
                                <a href="{{ route('warga.pengaduan.edit', $pengaduan) }}" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white py-2 px-4 rounded-md text-center">
                                    Edit Pengaduan
                                </a>
                                @endif
                                @if(auth()->user()->isAdmin() || auth()->user()->isPetugas())
                                <a href="{{ route('petugas.pengaduan.index') }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md text-center">
                                    Kelola Pengaduan
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="max-w-4xl max-h-full">
            <img id="modalImage" src="" alt="" class="max-w-full max-h-full">
            <button onclick="closeModal()" class="absolute top-4 right-4 text-white text-2xl bg-black bg-opacity-50 rounded-full w-10 h-10 flex items-center justify-center">
                ×
            </button>
        </div>
    </div>

    @push('scripts')
    <script>
        function openModal(src) {
            document.getElementById('modalImage').src = src;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }

        // Close modal on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });

        // Close modal on background click
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
    @endpush
</x-app-layout>