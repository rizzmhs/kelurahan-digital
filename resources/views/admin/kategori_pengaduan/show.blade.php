<x-app-layout>
    <x-slot name="title">Detail Kategori Pengaduan</x-slot>
    
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Header -->
                    <div class="flex justify-between items-start mb-8">
                        <div>
                            <div class="flex items-center mb-2">
                                @if($kategori->icon)
                                    <i class="{{ $kategori->icon }} text-2xl text-blue-600 mr-3"></i>
                                @else
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-folder text-blue-600"></i>
                                    </div>
                                @endif
                                <h2 class="text-2xl font-bold text-gray-800">{{ $kategori->nama_kategori }}</h2>
                            </div>
                            <div class="flex items-center space-x-4">
                                <span class="px-3 py-1 rounded-full text-xs font-medium 
                                    {{ $kategori->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    <i class="fas fa-circle mr-1 text-xxs"></i>
                                    {{ $kategori->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                                <span class="text-gray-500 text-sm">
                                    ID: {{ $kategori->id }}
                                </span>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.kategori_pengaduan.edit', $kategori->id) }}" 
                               class="px-4 py-2 bg-yellow-100 text-yellow-800 hover:bg-yellow-200 rounded-md flex items-center transition duration-200">
                                <i class="fas fa-edit mr-2"></i> Edit
                            </a>
                            <a href="{{ route('admin.kategori_pengaduan.index') }}" 
                               class="px-4 py-2 bg-gray-100 text-gray-800 hover:bg-gray-200 rounded-md flex items-center transition duration-200">
                                <i class="fas fa-arrow-left mr-2"></i> Kembali
                            </a>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                            <div class="flex items-center">
                                <div class="bg-blue-100 p-3 rounded-full mr-4">
                                    <i class="fas fa-calendar text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-blue-600 font-medium">Tanggal Dibuat</p>
                                    <p class="text-lg font-bold text-gray-800">{{ $kategori->created_at->format('d/m/Y') }}</p>
                                    <p class="text-sm text-gray-500">{{ $kategori->created_at->format('H:i:s') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                            <div class="flex items-center">
                                <div class="bg-green-100 p-3 rounded-full mr-4">
                                    <i class="fas fa-sync-alt text-green-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-green-600 font-medium">Terakhir Diperbarui</p>
                                    <p class="text-lg font-bold text-gray-800">{{ $kategori->updated_at->format('d/m/Y') }}</p>
                                    <p class="text-sm text-gray-500">{{ $kategori->updated_at->format('H:i:s') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-purple-50 border border-purple-200 rounded-lg p-6">
                            <div class="flex items-center">
                                <div class="bg-purple-100 p-3 rounded-full mr-4">
                                    <i class="fas fa-comments text-purple-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-purple-600 font-medium">Total Pengaduan</p>
                                    <p class="text-lg font-bold text-gray-800">{{ $kategori->pengaduans->count() }}</p>
                                    <p class="text-sm text-gray-500">Pengaduan terkait</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Info -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <!-- Deskripsi -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h3 class="text-lg font-medium text-gray-700 mb-4 flex items-center">
                                    <i class="fas fa-align-left text-gray-400 mr-2"></i> Deskripsi
                                </h3>
                                @if($kategori->deskripsi)
                                    <p class="text-gray-700">{{ $kategori->deskripsi }}</p>
                                @else
                                    <p class="text-gray-500 italic">Tidak ada deskripsi</p>
                                @endif
                            </div>

                            <!-- Icon Info -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h3 class="text-lg font-medium text-gray-700 mb-4 flex items-center">
                                    <i class="fas fa-icons text-gray-400 mr-2"></i> Icon
                                </h3>
                                <div class="flex items-center space-x-4">
                                    <div class="w-20 h-20 bg-blue-100 rounded-lg flex items-center justify-center">
                                        @if($kategori->icon)
                                            <i class="{{ $kategori->icon }} text-blue-600 text-3xl"></i>
                                        @else
                                            <i class="fas fa-folder text-blue-600 text-3xl"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">
                                            {{ $kategori->icon ?: 'Default Icon' }}
                                        </p>
                                        @if($kategori->icon)
                                            <p class="text-sm text-gray-500 mt-1">Class: <code class="bg-gray-100 px-2 py-1 rounded">{{ $kategori->icon }}</code></p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <!-- Status Details -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h3 class="text-lg font-medium text-gray-700 mb-4 flex items-center">
                                    <i class="fas fa-info-circle text-gray-400 mr-2"></i> Status & Informasi
                                </h3>
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                        <span class="text-gray-600">Status Kategori</span>
                                        <span class="px-3 py-1 rounded-full text-sm font-medium 
                                            {{ $kategori->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $kategori->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                        <span class="text-gray-600">Dibuat Pada</span>
                                        <span class="font-medium">{{ $kategori->created_at->format('d F Y H:i') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                        <span class="text-gray-600">Diperbarui Pada</span>
                                        <span class="font-medium">{{ $kategori->updated_at->format('d F Y H:i') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h3 class="text-lg font-medium text-gray-700 mb-4 flex items-center">
                                    <i class="fas fa-bolt text-gray-400 mr-2"></i> Aksi Cepat
                                </h3>
                                <div class="space-y-3">
                                    <!-- Toggle Status -->
                                    <form action="{{ route('admin.kategori_pengaduan.update.status', $kategori->id) }}" 
                                          method="POST" class="inline w-full">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" 
                                                class="w-full flex items-center justify-between p-3 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition duration-200">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 rounded-full mr-3 flex items-center justify-center
                                                    {{ $kategori->is_active ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                                                    <i class="fas fa-power-off"></i>
                                                </div>
                                                <div class="text-left">
                                                    <p class="font-medium">{{ $kategori->is_active ? 'Nonaktifkan' : 'Aktifkan' }} Kategori</p>
                                                    <p class="text-xs text-gray-500">Ubah status kategori</p>
                                                </div>
                                            </div>
                                            <i class="fas fa-chevron-right text-gray-400"></i>
                                        </button>
                                    </form>

                                    <!-- Edit -->
                                    <a href="{{ route('admin.kategori_pengaduan.edit', $kategori->id) }}" 
                                       class="block p-3 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition duration-200">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 bg-yellow-100 rounded-full mr-3 flex items-center justify-center">
                                                    <i class="fas fa-edit text-yellow-600"></i>
                                                </div>
                                                <div class="text-left">
                                                    <p class="font-medium">Edit Kategori</p>
                                                    <p class="text-xs text-gray-500">Ubah informasi kategori</p>
                                                </div>
                                            </div>
                                            <i class="fas fa-chevron-right text-gray-400"></i>
                                        </div>
                                    </a>

                                    <!-- Delete -->
                                    <form action="{{ route('admin.kategori_pengaduan.destroy', $kategori->id) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?\n\nSemua pengaduan yang terkait akan kehilangan kategori ini.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="w-full flex items-center justify-between p-3 bg-white border border-red-300 rounded-lg hover:bg-red-50 transition duration-200 text-red-600">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 bg-red-100 rounded-full mr-3 flex items-center justify-center">
                                                    <i class="fas fa-trash"></i>
                                                </div>
                                                <div class="text-left">
                                                    <p class="font-medium">Hapus Kategori</p>
                                                    <p class="text-xs text-gray-500">Hapus permanen kategori</p>
                                                </div>
                                            </div>
                                            <i class="fas fa-chevron-right text-red-400"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pengaduan Terkait -->
                    @if($kategori->pengaduans->count() > 0)
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-700 mb-4 flex items-center">
                            <i class="fas fa-link text-gray-400 mr-2"></i> 
                            Pengaduan Terkait ({{ $kategori->pengaduans->count() }})
                        </h3>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul Pengaduan</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($kategori->pengaduans->take(5) as $pengaduan)
                                    <tr class="hover:bg-gray-100 transition duration-150">
                                        <td class="px-4 py-3 text-sm">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3">
                                            <a href="{{ route('admin.pengaduan.show', $pengaduan->id) }}" 
                                               class="text-blue-600 hover:text-blue-800 font-medium">
                                                {{ Str::limit($pengaduan->judul, 50) }}
                                            </a>
                                        </td>
                                        <td class="px-4 py-3">
                                            @php
                                                $statusColors = [
                                                    'draft' => 'bg-gray-100 text-gray-800',
                                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                                    'diproses' => 'bg-blue-100 text-blue-800',
                                                    'selesai' => 'bg-green-100 text-green-800',
                                                    'ditolak' => 'bg-red-100 text-red-800',
                                                ];
                                                $status = $pengaduan->status ?? 'pending';
                                            @endphp
                                            <span class="px-2 py-1 text-xs rounded-full {{ $statusColors[$status] }}">
                                                {{ ucfirst($status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-500">
                                            {{ $pengaduan->created_at->format('d/m/Y') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($kategori->pengaduans->count() > 5)
                            <div class="mt-4 text-center">
                                <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Lihat semua {{ $kategori->pengaduans->count() }} pengaduan 
                                    <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        @endif
                    </div>
                    @endif

                    <!-- Danger Zone -->
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                            <h3 class="text-lg font-medium text-red-700 mb-2 flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2"></i> Zona Bahaya
                            </h3>
                            <p class="text-sm text-red-600 mb-4">
                                Aksi di bawah ini bersifat permanen dan tidak dapat dibatalkan.
                            </p>
                            
                            <div class="space-y-4">
                                <!-- Delete Category -->
                                <div class="bg-white border border-red-300 rounded-lg p-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="font-medium text-red-700">Hapus Kategori</p>
                                            <p class="text-sm text-red-600 mt-1">
                                                @if($kategori->pengaduans->count() > 0)
                                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                                    Kategori ini memiliki {{ $kategori->pengaduans->count() }} pengaduan yang terkait.
                                                    Menghapus kategori akan memisahkan pengaduan dari kategori ini.
                                                @else
                                                    Kategori ini akan dihapus secara permanen dari sistem.
                                                @endif
                                            </p>
                                        </div>
                                        <form action="{{ route('admin.kategori_pengaduan.destroy', $kategori->id) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('⚠️ PERINGATAN!\\n\\nAnda akan menghapus kategori \"{{ $kategori->nama_kategori }}\".\\n\\nApakah Anda yakin?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition duration-200">
                                                Hapus Permanen
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        code {
            font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
            font-size: 0.9em;
        }
    </style>
    @endpush
</x-app-layout>