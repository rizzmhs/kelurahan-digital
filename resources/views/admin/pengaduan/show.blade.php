<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Pengaduan - {{ $pengaduan->kode_pengaduan }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Header & Actions -->
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $pengaduan->judul }}</h1>
                            <p class="text-gray-600 mt-1">Kode: {{ $pengaduan->kode_pengaduan }}</p>
                        </div>
                        <div class="flex space-x-2">
                            <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $pengaduan->getStatusBadgeClass() }}">
                                {{ ucfirst($pengaduan->status) }}
                            </span>
                            <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $pengaduan->getPrioritasBadgeClass() }}">
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
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <!-- Management Actions -->
                            <div class="bg-white border border-gray-200 rounded-lg p-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Kelola Pengaduan</h3>
                                
                                <!-- Status Update -->
                                <form action="{{ route('admin.pengaduan.update.status', $pengaduan) }}" method="POST" class="mb-4">
                                    @csrf
                                    @method('PUT')
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="status" class="block text-sm font-medium text-gray-700">Ubah Status</label>
                                            <select id="status" name="status" required
                                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                                <option value="menunggu" {{ $pengaduan->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                                <option value="diverifikasi" {{ $pengaduan->status == 'diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
                                                <option value="diproses" {{ $pengaduan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                                <option value="selesai" {{ $pengaduan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                                <option value="ditolak" {{ $pengaduan->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="prioritas" class="block text-sm font-medium text-gray-700">Prioritas</label>
                                            <select id="prioritas" name="prioritas"
                                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                                <option value="rendah" {{ $pengaduan->prioritas == 'rendah' ? 'selected' : '' }}>Rendah</option>
                                                <option value="sedang" {{ $pengaduan->prioritas == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                                <option value="tinggi" {{ $pengaduan->prioritas == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                                                <option value="darurat" {{ $pengaduan->prioritas == 'darurat' ? 'selected' : '' }}>Darurat</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <label for="catatan_admin" class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                                        <textarea id="catatan_admin" name="catatan_admin" rows="3"
                                                  class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                  placeholder="Berikan catatan untuk pengaduan ini...">{{ old('catatan_admin', $pengaduan->catatan_admin) }}</textarea>
                                    </div>
                                    <div class="mt-4">
                                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md text-sm font-medium">
                                            Update Status
                                        </button>
                                    </div>
                                </form>

                                <!-- Assign Petugas -->
                                @if(in_array($pengaduan->status, ['diverifikasi', 'diproses']))
                                <form action="{{ route('admin.pengaduan.assign.petugas', $pengaduan) }}" method="POST" class="mb-4">
                                    @csrf
                                    @method('PUT')
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="petugas_id" class="block text-sm font-medium text-gray-700">Assign Petugas</label>
                                            <select id="petugas_id" name="petugas_id"
                                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                                <option value="">Pilih Petugas</option>
                                                @foreach($petugas as $p)
                                                <option value="{{ $p->id }}" {{ $pengaduan->petugas_id == $p->id ? 'selected' : '' }}>
                                                    {{ $p->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="flex items-end">
                                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-md text-sm font-medium">
                                                Assign Petugas
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                @endif

                                <!-- Quick Actions -->
                                <div class="flex space-x-2">
                                    @if($pengaduan->status === 'menunggu')
                                    <form action="{{ route('admin.pengaduan.verifikasi', $pengaduan) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-md text-sm font-medium">
                                            Verifikasi
                                        </button>
                                    </form>
                                    @endif

                                    @if($pengaduan->status === 'diproses')
                                    <form action="{{ route('admin.pengaduan.selesai', $pengaduan) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md text-sm font-medium">
                                            Tandai Selesai
                                        </button>
                                    </form>
                                    @endif

                                    <form action="{{ route('admin.pengaduan.tolak', $pengaduan) }}" method="POST" class="inline">
                                        @csrf
                                        <div class="flex space-x-2">
                                            <input type="text" name="catatan_admin" required
                                                   class="flex-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                   placeholder="Alasan penolakan...">
                                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-md text-sm font-medium" 
                                                    onclick="return confirm('Apakah Anda yakin ingin menolak pengaduan ini?')">
                                                Tolak
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Tindakan & Foto Penanganan -->
                            @if($pengaduan->tindakan || ($pengaduan->foto_penanganan && count($pengaduan->foto_penanganan) > 0))
                            <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                                <h3 class="text-lg font-medium text-gray-900 mb-3">Penanganan</h3>
                                
                                @if($pengaduan->tindakan)
                                <div class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Tindakan yang Dilakukan</h4>
                                    <p class="text-gray-700 whitespace-pre-line">{{ $pengaduan->tindakan }}</p>
                                </div>
                                @endif

                                @if($pengaduan->foto_penanganan && count($pengaduan->foto_penanganan) > 0)
                                <div>
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Foto Penanganan</h4>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                        @foreach($pengaduan->foto_penanganan as $foto)
                                        <div class="relative group">
                                            <img src="{{ Storage::url($foto) }}" alt="Foto penanganan" 
                                                 class="w-full h-32 object-cover rounded-lg cursor-pointer"
                                                 onclick="openModal('{{ Storage::url($foto) }}')">
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>
                            @endif
                        </div>

                        <!-- Sidebar -->
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

                            <!-- Informasi Pelapor -->
                            <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                                <h3 class="text-lg font-medium text-gray-900 mb-3">Informasi Pelapor</h3>
                                <div class="flex items-center mb-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-semibold">
                                            {{ substr($pengaduan->user->name, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $pengaduan->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $pengaduan->user->email }}</p>
                                    </div>
                                </div>
                                <dl class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <dt class="text-gray-600">NIK:</dt>
                                        <dd class="text-gray-900">{{ $pengaduan->user->nik }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-gray-600">Telepon:</dt>
                                        <dd class="text-gray-900">{{ $pengaduan->user->telepon }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-gray-600">Alamat:</dt>
                                        <dd class="text-gray-900">{{ $pengaduan->user->alamat }}</dd>
                                    </div>
                                </dl>
                            </div>

                            <!-- Petugas Penanggung Jawab -->
                            @if($pengaduan->petugas)
                            <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                                <h3 class="text-lg font-medium text-gray-900 mb-3">Petugas Penanggung Jawab</h3>
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center text-white font-semibold">
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

                            <!-- Timeline Status -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-3">Timeline Status</h3>
                                <div class="space-y-3">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Dibuat:</span>
                                        <span class="text-gray-900">{{ $pengaduan->created_at->format('d M Y H:i') }}</span>
                                    </div>
                                    @if($pengaduan->diverifikasi_at)
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Diverifikasi:</span>
                                        <span class="text-gray-900">{{ $pengaduan->diverifikasi_at->format('d M Y H:i') }}</span>
                                    </div>
                                    @endif
                                    @if($pengaduan->diproses_at)
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Diproses:</span>
                                        <span class="text-gray-900">{{ $pengaduan->diproses_at->format('d M Y H:i') }}</span>
                                    </div>
                                    @endif
                                    @if($pengaduan->selesai_at)
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Selesai:</span>
                                        <span class="text-gray-900">{{ $pengaduan->selesai_at->format('d M Y H:i') }}</span>
                                    </div>
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

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeModal();
        });

        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
    </script>
    @endpush
</x-app-layout>