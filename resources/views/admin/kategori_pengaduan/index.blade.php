<x-app-layout>
    <x-slot name="title">Manajemen Kategori Pengaduan</x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Header -->
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Kategori Pengaduan</h2>
                            <p class="text-gray-600 mt-1">Kelola kategori untuk pengaduan warga</p>
                        </div>
                        <a href="{{ route('admin.kategori_pengaduan.create') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md flex items-center transition duration-200">
                            <i class="fas fa-plus mr-2"></i> Tambah Kategori
                        </a>
                    </div>

                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
                            <div class="flex">
                                <div class="py-1">
                                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                </div>
                                <div>
                                    <p class="font-bold">Sukses!</p>
                                    <p>{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded" role="alert">
                            <div class="flex">
                                <div class="py-1">
                                    <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                                </div>
                                <div>
                                    <p class="font-bold">Error!</p>
                                    <p>{{ session('error') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Search & Filter -->
                    <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Kategori</label>
                                <input type="text" id="searchInput" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                       placeholder="Cari berdasarkan nama...">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <select id="statusFilter" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Semua Status</option>
                                    <option value="active">Aktif</option>
                                    <option value="inactive">Nonaktif</option>
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button id="resetFilter" 
                                        class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md transition duration-200">
                                    <i class="fas fa-redo mr-2"></i> Reset Filter
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                            <div class="flex items-center">
                                <div class="bg-blue-100 p-3 rounded-full mr-4">
                                    <i class="fas fa-list text-blue-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-blue-600 font-medium">Total Kategori</p>
                                    <p class="text-2xl font-bold text-gray-800">{{ $kategories->total() }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                            <div class="flex items-center">
                                <div class="bg-green-100 p-3 rounded-full mr-4">
                                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-green-600 font-medium">Kategori Aktif</p>
                                    <p class="text-2xl font-bold text-gray-800">
                                        {{ $kategories->where('is_active', true)->count() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                            <div class="flex items-center">
                                <div class="bg-red-100 p-3 rounded-full mr-4">
                                    <i class="fas fa-times-circle text-red-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-red-600 font-medium">Kategori Nonaktif</p>
                                    <p class="text-2xl font-bold text-gray-800">
                                        {{ $kategories->where('is_active', false)->count() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <div class="flex items-center">
                                            <span>Nama Kategori</span>
                                            <i class="fas fa-sort ml-1 text-gray-400"></i>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Deskripsi
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal Dibuat
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="categoryTableBody">
                                @forelse($kategories as $kategori)
                                <tr class="hover:bg-gray-50 transition duration-150" data-status="{{ $kategori->is_active ? 'active' : 'inactive' }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $loop->iteration + ($kategories->currentPage() - 1) * $kategories->perPage() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if($kategori->icon)
                                                <i class="{{ $kategori->icon }} text-gray-400 mr-3 text-lg"></i>
                                            @else
                                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                                    <i class="fas fa-folder text-blue-600"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $kategori->nama_kategori }}</div>
                                                <div class="text-xs text-gray-500">ID: {{ $kategori->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 max-w-xs truncate">
                                            {{ $kategori->deskripsi ?: '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form action="{{ route('admin.kategori_pengaduan.update.status', $kategori->id) }}" 
                                              method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" 
                                                    class="px-3 py-1 rounded-full text-xs font-medium transition duration-200
                                                           {{ $kategori->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}"
                                                    onclick="return confirm('Ubah status kategori?')">
                                                <i class="fas fa-circle mr-1 text-xxs"></i>
                                                {{ $kategori->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $kategori->created_at->format('d/m/Y') }}
                                        <div class="text-xs text-gray-400">
                                            {{ $kategori->created_at->format('H:i') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <!-- View -->
                                            <a href="{{ route('admin.kategori_pengaduan.show', $kategori->id) }}" 
                                               class="text-blue-600 hover:text-blue-900 p-2 rounded hover:bg-blue-50 transition duration-200"
                                               title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            <!-- Edit -->
                                            <a href="{{ route('admin.kategori_pengaduan.edit', $kategori->id) }}" 
                                               class="text-yellow-600 hover:text-yellow-900 p-2 rounded hover:bg-yellow-50 transition duration-200"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            <!-- Delete -->
                                            <form action="{{ route('admin.kategori_pengaduan.destroy', $kategori->id) }}" 
                                                  method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-900 p-2 rounded hover:bg-red-50 transition duration-200"
                                                        title="Hapus"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?\n\nKategori: {{ $kategori->nama_kategori }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="text-gray-400">
                                            <i class="fas fa-inbox text-4xl mb-4"></i>
                                            <p class="text-lg font-medium">Belum ada data kategori</p>
                                            <p class="text-sm mt-2">Mulai dengan menambahkan kategori pertama Anda</p>
                                            <a href="{{ route('admin.kategori_pengaduan.create') }}" 
                                               class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200">
                                                <i class="fas fa-plus mr-2"></i>Tambah Kategori
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($kategories->hasPages())
                    <div class="mt-6">
                        {{ $kategories->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>