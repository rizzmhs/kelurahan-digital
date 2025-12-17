@php
    // Helper functions untuk konsistensi
    if (!function_exists('getStatusBadgeClass')) {
        function getStatusBadgeClass($isActive) {
            return $isActive ? 'badge-selesai' : 'badge-ditolak';
        }
    }
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    Kategori Pengaduan
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    Kelola kategori untuk pengaduan warga
                </p>
            </div>
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <i class="fas fa-tags text-blue-500"></i>
                <span>Total: <span class="font-semibold text-gray-900">{{ $kategories->total() }}</span> kategori</span>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Total Kategori -->
            <div class="stats-card">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="stats-icon stats-icon-blue">
                            <i class="fas fa-list text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Kategori</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $kategories->total() }}</p>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <span class="text-xs text-gray-500 flex items-center">
                            <i class="fas fa-layer-group mr-2"></i>
                            Semua status
                        </span>
                    </div>
                </div>
            </div>

            <!-- Kategori Aktif -->
            <div class="stats-card">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="stats-icon stats-icon-green">
                            <i class="fas fa-check-circle text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Aktif</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $kategories->where('is_active', true)->count() }}</p>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <span class="text-xs text-gray-500 flex items-center">
                            <i class="fas fa-toggle-on mr-2"></i>
                            Dapat digunakan
                        </span>
                    </div>
                </div>
            </div>

            <!-- Kategori Nonaktif -->
            <div class="stats-card">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="stats-icon stats-icon-red">
                            <i class="fas fa-times-circle text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Nonaktif</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $kategories->where('is_active', false)->count() }}</p>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <span class="text-xs text-gray-500 flex items-center">
                            <i class="fas fa-toggle-off mr-2"></i>
                            Tidak aktif
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Content Section -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Filter Panel -->
            <div class="lg:col-span-1">
                <div class="card sticky top-6">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-filter text-blue-500"></i>
                            Filter & Pencarian
                        </h3>
                    </div>
                    <div class="p-5">
                        <div class="space-y-5">
                            <!-- Search -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-search text-gray-500 text-sm mr-2"></i>
                                    Cari Kategori
                                </label>
                                <input type="text" id="searchInput" 
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                       placeholder="Cari berdasarkan nama...">
                            </div>

                            <!-- Status Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-toggle-on text-gray-500 text-sm mr-2"></i>
                                    Status
                                </label>
                                <select id="statusFilter" 
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    <option value="">Semua Status</option>
                                    <option value="active">Aktif</option>
                                    <option value="inactive">Nonaktif</option>
                                </select>
                            </div>

                            <!-- Action Buttons -->
                            <div class="space-y-3 pt-2">
                                <a href="{{ route('admin.kategori_pengaduan.create') }}" 
                                   class="w-full px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm transition-colors duration-200 flex items-center justify-center gap-2">
                                    <i class="fas fa-plus"></i>
                                    Tambah Kategori
                                </a>
                                
                                <button id="resetFilter" 
                                        class="w-full px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg text-sm transition-colors duration-200 flex items-center justify-center gap-2">
                                    <i class="fas fa-redo"></i>
                                    Reset Filter
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-3">
                <div class="card">
                    <!-- Header -->
                    <div class="card-header">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                    <i class="fas fa-list-alt text-gray-500"></i>
                                    Daftar Kategori
                                </h3>
                                @if(request()->anyFilled(['search', 'status']))
                                <p class="text-sm text-gray-500 mt-1">
                                    Filter aktif: 
                                    @if(request('search')) <span class="font-medium text-gray-600">"{{ request('search') }}"</span> @endif
                                    @if(request('status')) <span class="font-medium {{ request('status') == 'active' ? 'text-green-600' : 'text-red-600' }}">{{ request('status') == 'active' ? 'Aktif' : 'Nonaktif' }}</span> @endif
                                </p>
                                @endif
                            </div>
                            
                            <div class="flex items-center gap-3">
                                <span class="text-sm text-gray-500">
                                    <span class="font-medium text-gray-900">{{ $kategories->firstItem() ?? 0 }}-{{ $kategories->lastItem() ?? 0 }}</span>
                                    dari {{ $kategories->total() }}
                                </span>
                            </div>
                        </div>
                    </div>

                    @if($kategories->count() > 0)
                        <!-- Desktop Table -->
                        <div class="hidden lg:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            No
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nama Kategori
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Deskripsi
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Dibuat
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="categoryTableBody">
                                    @foreach($kategories as $kategori)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150" 
                                        data-status="{{ $kategori->is_active ? 'active' : 'inactive' }}"
                                        data-name="{{ strtolower($kategori->nama_kategori) }}">
                                        <!-- No -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $loop->iteration + ($kategories->currentPage() - 1) * $kategories->perPage() }}
                                        </td>
                                        
                                        <!-- Nama Kategori -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                @if($kategori->icon)
                                                    <i class="{{ $kategori->icon }} text-gray-400 text-lg"></i>
                                                @else
                                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-folder text-blue-600"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="text-sm font-semibold text-gray-900">{{ $kategori->nama_kategori }}</div>
                                                    <div class="text-xs text-gray-500">ID: {{ $kategori->id }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <!-- Deskripsi -->
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900 max-w-xs truncate">
                                                {{ $kategori->deskripsi ?: '-' }}
                                            </div>
                                        </td>
                                        
                                        <!-- Status -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <form action="{{ route('admin.kategori_pengaduan.update.status', $kategori->id) }}" 
                                                  method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" 
                                                        class="badge {{ getStatusBadgeClass($kategori->is_active) }} hover:opacity-80 transition-opacity duration-200"
                                                        onclick="return confirm('Ubah status kategori?')">
                                                    <i class="fas {{ $kategori->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }} mr-1"></i>
                                                    {{ $kategori->is_active ? 'Aktif' : 'Nonaktif' }}
                                                </button>
                                            </form>
                                        </td>
                                        
                                        <!-- Dibuat -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="font-medium">{{ $kategori->created_at->format('d M Y') }}</div>
                                            <div class="text-xs text-gray-400">{{ $kategori->created_at->format('H:i') }}</div>
                                        </td>
                                        
                                        <!-- Actions -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-2">
                                                <!-- View -->
                                                <a href="{{ route('admin.kategori_pengaduan.show', $kategori->id) }}" 
                                                   class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200"
                                                   title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                
                                                <!-- Edit -->
                                                <a href="{{ route('admin.kategori_pengaduan.edit', $kategori->id) }}" 
                                                   class="p-2 text-gray-500 hover:text-yellow-600 hover:bg-yellow-50 rounded-lg transition-colors duration-200"
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                
                                                <!-- Delete -->
                                                <form action="{{ route('admin.kategori_pengaduan.destroy', $kategori->id) }}" 
                                                      method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200"
                                                            title="Hapus"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?\n\nKategori: {{ $kategori->nama_kategori }}')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile/Tablet Cards -->
                        <div class="lg:hidden">
                            <div class="divide-y divide-gray-200">
                                @foreach($kategories as $kategori)
                                <div class="p-4 hover:bg-gray-50 transition-colors duration-150">
                                    <!-- Card Header -->
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-start gap-3">
                                                <div class="flex-shrink-0">
                                                    @if($kategori->icon)
                                                        <i class="{{ $kategori->icon }} text-gray-400 text-lg"></i>
                                                    @else
                                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                                            <i class="fas fa-folder text-blue-600"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <h4 class="text-sm font-semibold text-gray-900">
                                                        {{ $kategori->nama_kategori }}
                                                    </h4>
                                                    <p class="text-xs text-gray-500 mt-0.5 truncate">
                                                        {{ $kategori->deskripsi ?: 'Tidak ada deskripsi' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <a href="{{ route('admin.kategori_pengaduan.edit', $kategori->id) }}" 
                                               class="p-1.5 text-gray-500 hover:text-yellow-600">
                                                <i class="fas fa-edit text-sm"></i>
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <!-- Card Details -->
                                    <div class="space-y-3 text-sm">
                                        <!-- Status & Created -->
                                        <div class="flex items-center justify-between">
                                            <form action="{{ route('admin.kategori_pengaduan.update.status', $kategori->id) }}" 
                                                  method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" 
                                                        class="badge {{ getStatusBadgeClass($kategori->is_active) }} hover:opacity-80 transition-opacity duration-200"
                                                        onclick="return confirm('Ubah status kategori?')">
                                                    <i class="fas {{ $kategori->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }} mr-1"></i>
                                                    {{ $kategori->is_active ? 'Aktif' : 'Nonaktif' }}
                                                </button>
                                            </form>
                                            <span class="text-xs text-gray-500">{{ $kategori->created_at->format('d M Y') }}</span>
                                        </div>
                                        
                                        <!-- Actions -->
                                        <div class="pt-3 border-t border-gray-200">
                                            <div class="flex items-center justify-between">
                                                <a href="{{ route('admin.kategori_pengaduan.show', $kategori->id) }}" 
                                                   class="px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-medium rounded-lg transition-colors duration-200 flex items-center gap-1">
                                                    <i class="fas fa-eye"></i>
                                                    Detail
                                                </a>
                                                
                                                <form action="{{ route('admin.kategori_pengaduan.destroy', $kategori->id) }}" 
                                                      method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-700 text-xs font-medium rounded-lg transition-colors duration-200 flex items-center gap-1"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?\n\nKategori: {{ $kategori->nama_kategori }}')">
                                                        <i class="fas fa-trash"></i>
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div class="border-t border-gray-200 bg-gray-50">
                            <div class="px-5 py-4">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                    <div class="text-sm text-gray-600">
                                        Menampilkan <span class="font-medium">{{ $kategories->firstItem() }}</span> sampai 
                                        <span class="font-medium">{{ $kategories->lastItem() }}</span> dari 
                                        <span class="font-medium">{{ $kategories->total() }}</span> entri
                                    </div>
                                    <div class="flex justify-center sm:justify-end">
                                        {{ $kategories->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="p-8 text-center">
                            <div class="empty-state-icon">
                                <i class="fas fa-inbox text-xl"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">
                                Tidak ada kategori ditemukan
                            </h4>
                            <p class="text-gray-500 max-w-md mx-auto mb-6">
                                @if(request()->anyFilled(['search', 'status']))
                                    Tidak ada kategori yang sesuai dengan filter yang Anda pilih.
                                @else
                                    Belum ada kategori yang dibuat.
                                @endif
                            </p>
                            <div class="space-x-3">
                                <a href="{{ route('admin.kategori_pengaduan.create') }}" 
                                   class="btn btn-primary">
                                    <i class="fas fa-plus mr-2"></i>
                                    Tambah Kategori Pertama
                                </a>
                                @if(request()->anyFilled(['search', 'status']))
                                <a href="{{ route('admin.kategori_pengaduan.index') }}" 
                                   class="btn btn-secondary">
                                    <i class="fas fa-redo-alt mr-2"></i>
                                    Reset Filter
                                </a>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-bolt text-yellow-500"></i>
                    Aksi Cepat
                </h3>
                <p class="text-sm text-gray-500 mt-1">Manajemen kategori cepat</p>
            </div>
            <div class="card-body">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Tambah Kategori -->
                    <a href="{{ route('admin.kategori_pengaduan.create') }}" 
                       class="group p-5 border border-gray-200 rounded-xl hover:border-blue-300 hover:shadow-sm transition-all duration-200 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="stats-icon stats-icon-blue group-hover:bg-blue-100">
                                <i class="fas fa-plus text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 group-hover:text-blue-600">
                                    Tambah Kategori
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    Buat kategori baru
                                </p>
                            </div>
                            <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-blue-500"></i>
                        </div>
                    </a>

                    <!-- Aktifkan Semua -->
                    <a href="#" 
                       onclick="return confirm('Aktifkan semua kategori?')"
                       class="group p-5 border border-gray-200 rounded-xl hover:border-green-300 hover:shadow-sm transition-all duration-200 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="stats-icon stats-icon-green group-hover:bg-green-100">
                                <i class="fas fa-toggle-on text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 group-hover:text-green-600">
                                    Aktifkan Semua
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    Set semua kategori aktif
                                </p>
                            </div>
                            <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-green-500"></i>
                        </div>
                    </a>

                    <!-- Export Data -->
                    <a href="#" 
                       class="group p-5 border border-gray-200 rounded-xl hover:border-purple-300 hover:shadow-sm transition-all duration-200 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="stats-icon stats-icon-purple group-hover:bg-purple-100">
                                <i class="fas fa-file-export text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 group-hover:text-purple-600">
                                    Export Data
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    Export data kategori
                                </p>
                            </div>
                            <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-purple-500"></i>
                        </div>
                    </a>

                    <!-- Pengaduan Stats -->
                    <a href="{{ route('admin.pengaduan.index') }}" 
                       class="group p-5 border border-gray-200 rounded-xl hover:border-orange-300 hover:shadow-sm transition-all duration-200 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="stats-icon stats-icon-orange group-hover:bg-orange-100">
                                <i class="fas fa-chart-bar text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 group-hover:text-orange-600">
                                    Statistik
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    Lihat statistik pengaduan
                                </p>
                            </div>
                            <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-orange-500"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animasi untuk stats cards
            const statsCards = document.querySelectorAll('.stats-card');
            statsCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
            
            // JavaScript untuk filter client-side
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            const resetFilterBtn = document.getElementById('resetFilter');
            const tableRows = document.querySelectorAll('#categoryTableBody tr');
            
            function filterTable() {
                const searchTerm = searchInput.value.toLowerCase();
                const statusValue = statusFilter.value;
                
                tableRows.forEach(row => {
                    const name = row.getAttribute('data-name') || '';
                    const status = row.getAttribute('data-status') || '';
                    
                    const nameMatch = name.includes(searchTerm);
                    const statusMatch = !statusValue || status === statusValue;
                    
                    if (nameMatch && statusMatch) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }
            
            // Event listeners
            searchInput.addEventListener('keyup', filterTable);
            statusFilter.addEventListener('change', filterTable);
            
            resetFilterBtn.addEventListener('click', function() {
                searchInput.value = '';
                statusFilter.value = '';
                filterTable();
            });
        });
    </script>
    @endpush
</x-app-layout>