<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <a href="{{ route('petugas.pengaduan.index') }}" class="text-blue-600 hover:text-blue-900 mr-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        <i class="fas fa-tasks mr-2 text-blue-600"></i>Detail Pengaduan
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Kode: {{ $pengaduan->kode_pengaduan }}</p>
                </div>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('petugas.pengaduan.riwayat', $pengaduan) }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    <i class="fas fa-history mr-2"></i>Riwayat
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column - Pengaduan Info -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Status Card -->
                    <div class="bg-white shadow rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Status Pengaduan</h3>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                                    {{ $pengaduan->status == 'diajukan' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $pengaduan->status == 'diproses' ? 'bg-purple-100 text-purple-800' : '' }}
                                    {{ $pengaduan->status == 'selesai' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $pengaduan->status == 'ditolak' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($pengaduan->status) }}
                                </span>
                                <span class="ml-2 px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $pengaduan->prioritas == 'rendah' ? 'bg-gray-100 text-gray-800' : '' }}
                                    {{ $pengaduan->prioritas == 'sedang' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $pengaduan->prioritas == 'tinggi' ? 'bg-orange-100 text-orange-800' : '' }}
                                    {{ $pengaduan->prioritas == 'darurat' ? 'bg-red-100 text-red-800' : '' }}">
                                    Prioritas: {{ ucfirst($pengaduan->prioritas) }}
                                </span>
                            </div>
                            <div class="text-sm text-gray-500">
                                Terakhir diupdate: {{ $pengaduan->updated_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                    </div>

                    <!-- Data Pemohon -->
                    <div class="bg-white shadow rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Data Pemohon</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Nama Lengkap</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $pengaduan->user->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">NIK</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $pengaduan->user->nik }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Alamat</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $pengaduan->user->alamat }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Telepon</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $pengaduan->user->telepon }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Pengaduan -->
                    <div class="bg-white shadow rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Detail Pengaduan</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Judul Pengaduan</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $pengaduan->judul }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Deskripsi</label>
                                <p class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $pengaduan->deskripsi }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Kategori</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $pengaduan->kategori->nama ?? 'Tidak ada kategori' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Lokasi</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $pengaduan->lokasi ?? 'Tidak disebutkan' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Bukti Foto -->
                    @if($pengaduan->bukti_foto)
                    <div class="bg-white shadow rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Bukti Foto</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach(json_decode($pengaduan->bukti_foto) as $foto)
                                <div class="border rounded-lg overflow-hidden">
                                    <img src="{{ Storage::url($foto) }}" alt="Bukti foto" class="w-full h-48 object-cover">
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Right Column - Actions -->
                <div class="space-y-6">
                    <!-- Quick Actions -->
                    <div class="bg-white shadow rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Aksi Cepat</h3>
                        <div class="space-y-3">
                            @if($pengaduan->status == 'diajukan')
                                <form action="{{ route('petugas.pengaduan.update.status', $pengaduan) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="diproses">
                                    <button type="submit" class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700">
                                        <i class="fas fa-cog mr-2"></i>Proses Pengaduan
                                    </button>
                                </form>
                            @endif

                            @if($pengaduan->status == 'diproses')
                                <form action="{{ route('petugas.pengaduan.update.status', $pengaduan) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="selesai">
                                    <button type="submit" class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                                        <i class="fas fa-check mr-2"></i>Tandai Selesai
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <!-- Update Status -->
                    <div class="bg-white shadow rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Update Status</h3>
                        <form action="{{ route('petugas.pengaduan.update.status', $pengaduan) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status</label>
                                    <select name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="diajukan" {{ $pengaduan->status == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                                        <option value="diproses" {{ $pengaduan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                        <option value="selesai" {{ $pengaduan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="ditolak" {{ $pengaduan->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Catatan</label>
                                    <textarea name="catatan" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Tambahkan catatan..."></textarea>
                                </div>
                                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Update Status
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Update Tindakan -->
                    <div class="bg-white shadow rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Tindakan</h3>
                        <form action="{{ route('petugas.pengaduan.update.tindakan', $pengaduan) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tindakan</label>
                                    <textarea name="tindakan" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Deskripsi tindakan yang dilakukan...">{{ $pengaduan->tindakan }}</textarea>
                                </div>
                                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Simpan Tindakan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>