<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
                    <i class="fas fa-list-alt mr-2 text-blue-600"></i>Daftar Pengaduan Saya
                </h2>
                <p class="text-sm text-gray-500 mt-1">Kelola dan pantau semua pengaduan Anda</p>
            </div>
            <div class="text-sm text-gray-500">
                {{ now()->format('d/m/Y') }}
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200 card-hover">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Total Pengaduan</p>
                                <p class="text-3xl font-bold text-gray-900 stats-counter">{{ $pengaduans->total() }}</p>
                            </div>
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                <i class="fas fa-file-alt text-xl"></i>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-sm text-gray-500">
                            <i class="fas fa-chart-bar mr-2"></i>
                            <span>Semua pengaduan</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200 card-hover">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Menunggu</p>
                                <p class="text-3xl font-bold text-gray-900 stats-counter">{{ $pengaduans->where('status', 'menunggu')->count() }}</p>
                            </div>
                            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                                <i class="fas fa-clock text-xl"></i>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-sm text-gray-500">
                            <i class="fas fa-hourglass-half mr-2"></i>
                            <span>Belum diproses</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200 card-hover">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Diproses</p>
                                <p class="text-3xl font-bold text-gray-900 stats-counter">{{ $pengaduans->where('status', 'diproses')->count() }}</p>
                            </div>
                            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                                <i class="fas fa-cog text-xl"></i>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-sm text-gray-500">
                            <i class="fas fa-spinner mr-2"></i>
                            <span>Sedang ditangani</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200 card-hover">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Selesai</p>
                                <p class="text-3xl font-bold text-gray-900 stats-counter">{{ $pengaduans->where('status', 'selesai')->count() }}</p>
                            </div>
                            <div class="p-3 rounded-full bg-green-100 text-green-600">
                                <i class="fas fa-check-circle text-xl"></i>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-sm text-gray-500">
                            <i class="fas fa-check-double mr-2"></i>
                            <span>Telah diselesaikan</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-history text-gray-500 mr-2"></i>Riwayat Pengaduan
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Total: {{ $pengaduans->total() }} pengaduan
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('warga.pengaduan.create') }}" 
                           class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium py-2.5 px-5 rounded-lg transition-all duration-200 flex items-center hover:shadow-lg card-hover">
                            <i class="fas fa-plus mr-2.5"></i>
                            Buat Pengaduan Baru
                        </a>
                    </div>
                </div>

                <div class="p-6">
                    @if($pengaduans->count() > 0)
                        <!-- Desktop Table -->
                        <div class="hidden md:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                            <div class="flex items-center">
                                                <i class="fas fa-hashtag mr-2 text-gray-500"></i>
                                                Kode
                                            </div>
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                            <div class="flex items-center">
                                                <i class="fas fa-heading mr-2 text-gray-500"></i>
                                                Pengaduan
                                            </div>
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                            <div class="flex items-center">
                                                <i class="fas fa-tag mr-2 text-gray-500"></i>
                                                Kategori
                                            </div>
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                            <div class="flex items-center">
                                                <i class="fas fa-info-circle mr-2 text-gray-500"></i>
                                                Status
                                            </div>
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                            <div class="flex items-center">
                                                <i class="fas fa-exclamation-triangle mr-2 text-gray-500"></i>
                                                Prioritas
                                            </div>
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                            <div class="flex items-center">
                                                <i class="fas fa-calendar-alt mr-2 text-gray-500"></i>
                                                Tanggal
                                            </div>
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                            <div class="flex items-center">
                                                <i class="fas fa-cogs mr-2 text-gray-500"></i>
                                                Aksi
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($pengaduans as $pengaduan)
                                    <tr class="hover:bg-gray-50 transition duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-blue-600 font-mono">
                                                {{ $pengaduan->kode_pengaduan }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="min-w-0">
                                                <div class="text-sm font-semibold text-gray-900 truncate">
                                                    {{ Str::limit($pengaduan->judul, 50) }}
                                                </div>
                                                <div class="text-xs text-gray-500 mt-1 truncate">
                                                    {{ Str::limit($pengaduan->deskripsi, 70) }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <span class="px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-800">
                                                    {{ $pengaduan->kategori->nama_kategori ?? '-' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1.5 text-xs font-semibold rounded-full {{ $pengaduan->getStatusBadgeClass() }}">
                                                {{ ucfirst($pengaduan->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1.5 text-xs font-semibold rounded-full {{ $pengaduan->getPrioritasBadgeClass() }}">
                                                {{ ucfirst($pengaduan->prioritas) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            <div class="flex items-center">
                                                <i class="far fa-calendar mr-2 text-gray-400"></i>
                                                {{ $pengaduan->created_at->format('d/m/Y') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <div class="flex items-center space-x-2">
                                                <a href="{{ route('warga.pengaduan.show', $pengaduan) }}" 
                                                   class="text-blue-600 hover:text-blue-800 transition duration-200 flex items-center"
                                                   title="Lihat Detail">
                                                    <i class="fas fa-eye mr-1.5"></i>
                                                    <span class="hidden lg:inline">Lihat</span>
                                                </a>
                                                @if($pengaduan->status === 'menunggu')
                                                <a href="{{ route('warga.pengaduan.edit', $pengaduan) }}" 
                                                   class="text-yellow-600 hover:text-yellow-800 transition duration-200 flex items-center"
                                                   title="Edit">
                                                    <i class="fas fa-edit mr-1.5"></i>
                                                    <span class="hidden lg:inline">Edit</span>
                                                </a>
                                                <form action="{{ route('warga.pengaduan.destroy', $pengaduan) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="text-red-600 hover:text-red-800 transition duration-200 flex items-center"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus pengaduan ini?')"
                                                            title="Hapus">
                                                        <i class="fas fa-trash mr-1.5"></i>
                                                        <span class="hidden lg:inline">Hapus</span>
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Cards -->
                        <div class="md:hidden space-y-4">
                            @foreach($pengaduans as $pengaduan)
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition duration-200">
                                <div class="p-4">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $pengaduan->getStatusBadgeClass() }} mb-2 inline-block">
                                                {{ ucfirst($pengaduan->status) }}
                                            </span>
                                            <h4 class="text-sm font-semibold text-gray-900">{{ Str::limit($pengaduan->judul, 60) }}</h4>
                                            <p class="text-xs text-gray-500 mt-1">{{ Str::limit($pengaduan->deskripsi, 80) }}</p>
                                        </div>
                                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $pengaduan->getPrioritasBadgeClass() }}">
                                            {{ ucfirst($pengaduan->prioritas) }}
                                        </span>
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-3 text-xs text-gray-600 mb-3">
                                        <div class="flex items-center">
                                            <i class="fas fa-hashtag text-gray-400 mr-2"></i>
                                            <span class="font-medium">{{ $pengaduan->kode_pengaduan }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-tag text-gray-400 mr-2"></i>
                                            <span>{{ $pengaduan->kategori->nama_kategori ?? '-' }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-calendar-alt text-gray-400 mr-2"></i>
                                            <span>{{ $pengaduan->created_at->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="flex justify-between items-center pt-3 border-t border-gray-100">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('warga.pengaduan.show', $pengaduan) }}" 
                                               class="text-blue-600 hover:text-blue-800 text-sm font-medium px-3 py-1.5 bg-blue-50 rounded-lg transition duration-200">
                                                <i class="fas fa-eye mr-1.5"></i>Lihat
                                            </a>
                                            @if($pengaduan->status === 'menunggu')
                                            <a href="{{ route('warga.pengaduan.edit', $pengaduan) }}" 
                                               class="text-yellow-600 hover:text-yellow-800 text-sm font-medium px-3 py-1.5 bg-yellow-50 rounded-lg transition duration-200">
                                                <i class="fas fa-edit mr-1.5"></i>Edit
                                            </a>
                                            @endif
                                        </div>
                                        @if($pengaduan->status === 'menunggu')
                                        <form action="{{ route('warga.pengaduan.destroy', $pengaduan) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-800 text-sm font-medium px-3 py-1.5 bg-red-50 rounded-lg transition duration-200"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus pengaduan ini?')">
                                                <i class="fas fa-trash mr-1.5"></i>Hapus
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        @if($pengaduans->hasPages())
                        <div class="mt-6 border-t border-gray-200 pt-4">
                            <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                                <div class="text-sm text-gray-700">
                                    Menampilkan 
                                    <span class="font-medium">{{ $pengaduans->firstItem() }}</span>
                                    hingga 
                                    <span class="font-medium">{{ $pengaduans->lastItem() }}</span>
                                    dari 
                                    <span class="font-medium">{{ $pengaduans->total() }}</span>
                                    hasil
                                </div>
                                <div class="flex space-x-1">
                                    {{ $pengaduans->links('pagination::tailwind') }}
                                </div>
                            </div>
                        </div>
                        @endif

                    @else
                        <!-- Empty State -->
                        <div class="text-center py-12">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-100 mb-4">
                                <i class="fas fa-inbox text-blue-600 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada pengaduan</h3>
                            <p class="text-gray-500 max-w-md mx-auto mb-6">
                                Anda belum membuat pengaduan apapun. Mulai laporkan masalah atau keluhan Anda.
                            </p>
                            <div class="flex flex-wrap justify-center gap-3">
                                <a href="{{ route('warga.pengaduan.create') }}" 
                                   class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium py-2.5 px-5 rounded-lg transition-all duration-200 flex items-center hover:shadow-lg card-hover">
                                    <i class="fas fa-plus mr-2.5"></i>
                                    Buat Pengaduan Pertama
                                </a>
                                <a href="{{ route('dashboard') }}" 
                                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2.5 px-5 rounded-lg transition-all duration-200 flex items-center card-hover">
                                    <i class="fas fa-home mr-2.5"></i>
                                    Kembali ke Dashboard
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .stats-counter {
            font-feature-settings: "tnum";
            font-variant-numeric: tabular-nums;
        }
        
        /* Custom pagination styling */
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .page-item {
            margin: 0 2px;
        }
        
        .page-link {
            display: block;
            padding: 0.5rem 0.75rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            color: #374151;
            font-size: 0.875rem;
            transition: all 0.2s;
        }
        
        .page-link:hover {
            background-color: #f3f4f6;
            border-color: #d1d5db;
        }
        
        .page-item.active .page-link {
            background-color: #3b82f6;
            border-color: #3b82f6;
            color: white;
        }
        
        .page-item.disabled .page-link {
            color: #9ca3af;
            background-color: #f9fafb;
            border-color: #e5e7eb;
            cursor: not-allowed;
        }
    </style>
    @endpush
</x-app-layout>