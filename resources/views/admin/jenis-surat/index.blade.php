@php
    // Helper functions untuk konsistensi
    if (!function_exists('getStatusBadgeClass')) {
        function getStatusBadgeClass($isActive) {
            return $isActive ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
        }
    }
    
    if (!function_exists('getStatusIcon')) {
        function getStatusIcon($isActive) {
            return $isActive ? 'fa-toggle-on' : 'fa-toggle-off';
        }
    }
    
    if (!function_exists('formatCurrency')) {
        function formatCurrency($amount) {
            return 'Rp ' . number_format($amount, 0, ',', '.');
        }
    }
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    <i class="fas fa-file-alt text-blue-600 mr-2"></i>Jenis Surat
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    Manajemen template dan jenis surat administrasi
                </p>
            </div>
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <i class="fas fa-file-alt text-blue-500"></i>
                <span>Total: <span class="font-semibold text-gray-900">{{ $jenisSurat->total() }}</span> jenis surat</span>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Stats Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Jenis Surat -->
            <div class="stats-card">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="stats-icon stats-icon-blue">
                            <i class="fas fa-file-alt text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $jenisSurat->total() }}</p>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <span class="text-xs text-gray-500 flex items-center">
                            <i class="fas fa-list mr-2"></i>
                            Semua jenis
                        </span>
                    </div>
                </div>
            </div>

            <!-- Aktif -->
            <div class="stats-card">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="stats-icon stats-icon-green">
                            <i class="fas fa-check-circle text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Aktif</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ $jenisSurat->where('is_active', true)->count() }}
                            </p>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <span class="text-xs text-gray-500 flex items-center">
                            <i class="fas fa-toggle-on mr-2"></i>
                            Tersedia untuk publik
                        </span>
                    </div>
                </div>
            </div>

            <!-- Nonaktif -->
            <div class="stats-card">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="stats-icon stats-icon-red">
                            <i class="fas fa-times-circle text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Nonaktif</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ $jenisSurat->where('is_active', false)->count() }}
                            </p>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <span class="text-xs text-gray-500 flex items-center">
                            <i class="fas fa-toggle-off mr-2"></i>
                            Tidak tersedia
                        </span>
                    </div>
                </div>
            </div>

            <!-- Estimasi Rata-rata -->
            <div class="stats-card">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="stats-icon stats-icon-purple">
                            <i class="fas fa-clock text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Estimasi</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ round($jenisSurat->avg('estimasi_hari') ?? 0) }} hr
                            </p>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <span class="text-xs text-gray-500 flex items-center">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            Rata-rata waktu
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
                    <form method="GET" action="{{ route('admin.jenis_surat.index') }}" class="p-5">
                        <div class="space-y-5">
                            <!-- Status Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                                    <i class="fas fa-tag text-gray-500 text-sm"></i>
                                    Status
                                </label>
                                <select name="status" 
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    <option value="">Semua Status</option>
                                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                            </div>

                            <!-- Template Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                                    <i class="fas fa-code text-gray-500 text-sm"></i>
                                    Template
                                </label>
                                <select name="template" 
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    <option value="">Semua Template</option>
                                    <option value="default" {{ request('template') == 'default' ? 'selected' : '' }}>Default</option>
                                    <option value="custom" {{ request('template') == 'custom' ? 'selected' : '' }}>Custom</option>
                                </select>
                            </div>

                            <!-- Search -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                                    <i class="fas fa-search text-gray-500 text-sm"></i>
                                    Pencarian
                                </label>
                                <div class="relative">
                                    <input type="text" name="search" value="{{ request('search') }}"
                                           placeholder="Cari kode atau nama surat..."
                                           class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    <i class="fas fa-search absolute left-3 top-3 text-gray-400 text-sm"></i>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="space-y-3 pt-2">
                                <button type="submit" 
                                        class="w-full px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm transition-colors duration-200 flex items-center justify-center gap-2">
                                    <i class="fas fa-filter"></i>
                                    Terapkan Filter
                                </button>
                                
                                <a href="{{ route('admin.jenis_surat.index') }}" 
                                   class="w-full px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg text-sm transition-colors duration-200 flex items-center justify-center gap-2">
                                    <i class="fas fa-redo"></i>
                                    Reset Semua
                                </a>

                                <a href="{{ route('admin.jenis_surat.create') }}" 
                                   class="w-full px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg text-sm transition-colors duration-200 flex items-center justify-center gap-2">
                                    <i class="fas fa-plus-circle"></i>
                                    Tambah Baru
                                </a>
                            </div>
                        </div>
                    </form>
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
                                    Daftar Jenis Surat
                                </h3>
                                @if(request()->anyFilled(['status', 'template', 'search']))
                                <p class="text-sm text-gray-500 mt-1">
                                    Filter aktif: 
                                    @if(request('status')) 
                                        <span class="badge {{ request('status') == 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ request('status') }}
                                        </span>
                                    @endif
                                    @if(request('template')) 
                                        <span class="badge bg-purple-100 text-purple-800">{{ request('template') }}</span>
                                    @endif
                                    @if(request('search')) 
                                        <span class="font-medium text-gray-600">"{{ request('search') }}"</span>
                                    @endif
                                </p>
                                @endif
                            </div>
                            
                            <div class="flex items-center gap-3">
                                <span class="text-sm text-gray-500">
                                    <span class="font-medium text-gray-900">{{ $jenisSurat->firstItem() ?? 0 }}-{{ $jenisSurat->lastItem() ?? 0 }}</span>
                                    dari {{ $jenisSurat->total() }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div class="mx-5 mt-5 p-4 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                <span class="text-green-700 font-medium">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mx-5 mt-5 p-4 bg-red-50 border border-red-200 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                                <span class="text-red-700 font-medium">{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif

                    @if($jenisSurat->count() > 0)
                        <!-- Desktop Table -->
                        <div class="hidden lg:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Jenis Surat
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Detail
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status & Template
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($jenisSurat as $item)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <!-- Jenis Surat Info -->
                                        <td class="px-6 py-4">
                                            <div class="flex items-start gap-3">
                                                <div class="flex-shrink-0">
                                                    <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                                                        <i class="fas fa-file-alt text-blue-600"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center gap-2">
                                                        <span class="text-sm font-semibold text-gray-900 bg-blue-100 text-blue-800 px-2 py-0.5 rounded">
                                                            {{ $item->kode }}
                                                        </span>
                                                        @if($item->template === 'default')
                                                            <span class="badge bg-purple-100 text-purple-800">
                                                                <i class="fas fa-code text-xs mr-1"></i>Default
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="text-sm font-semibold text-gray-900 mt-1">
                                                        {{ $item->nama }}
                                                    </div>
                                                    <div class="text-xs text-gray-500 mt-0.5">
                                                        {{ Str::limit($item->deskripsi, 60) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <!-- Detail -->
                                        <td class="px-6 py-4">
                                            <div class="space-y-2">
                                                <div class="flex items-center gap-2">
                                                    <span class="badge bg-yellow-100 text-yellow-800">
                                                        <i class="fas fa-clock mr-1"></i>
                                                        {{ $item->estimasi_hari }} hari
                                                    </span>
                                                    <span class="badge bg-green-100 text-green-800">
                                                        <i class="fas fa-money-bill-wave mr-1"></i>
                                                        {{ formatCurrency($item->biaya) }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="badge bg-gray-100 text-gray-800">
                                                        <i class="fas fa-file mr-1"></i>
                                                        {{ $item->surats_count ?? 0 }} surat dibuat
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <!-- Status & Template -->
                                        <td class="px-6 py-4">
                                            <div class="space-y-2">
                                                <!-- Status Toggle -->
                                                <form action="{{ route('admin.jenis_surat.update.status', $item->id) }}" 
                                                      method="POST" class="inline-block">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" 
                                                            class="badge {{ getStatusBadgeClass($item->is_active) }} hover:opacity-80 transition-opacity"
                                                            onclick="return confirm('Ubah status jenis surat ini?')">
                                                        <i class="fas {{ getStatusIcon($item->is_active) }} mr-1"></i>
                                                        {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                                    </button>
                                                </form>
                                                
                                                <!-- Template Info -->
                                                @if($item->template !== 'default')
                                                <div class="mt-1">
                                                    <a href="{{ route('admin.jenis_surat.edit.template', $item->id) }}" 
                                                       class="text-xs text-gray-600 hover:text-purple-600 flex items-center gap-1">
                                                        <i class="fas fa-edit text-xs"></i>
                                                        Edit template
                                                    </a>
                                                </div>
                                                @endif
                                            </div>
                                        </td>
                                        
                                        <!-- Actions -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-2">
                                                <!-- View -->
                                                <a href="{{ route('admin.jenis_surat.show', $item->id) }}" 
                                                   class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200"
                                                   title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                
                                                <!-- Edit -->
                                                <a href="{{ route('admin.jenis_surat.edit', $item->id) }}" 
                                                   class="p-2 text-gray-500 hover:text-yellow-600 hover:bg-yellow-50 rounded-lg transition-colors duration-200"
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                
                                                <!-- Quick Actions Dropdown -->
                                                <div class="relative group">
                                                    <button class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                                                        <i class="fas fa-ellipsis-h"></i>
                                                    </button>
                                                    
                                                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-200 z-10 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                                        <div class="py-2">
                                                            <!-- Template -->
                                                            <a href="{{ route('admin.jenis_surat.edit.template', $item->id) }}" 
                                                               class="w-full text-left px-4 py-2 text-sm text-purple-600 hover:bg-purple-50 flex items-center gap-2">
                                                                <i class="fas fa-code text-xs"></i>
                                                                Edit Template
                                                            </a>
                                                            
                                                            <!-- Duplicate -->
                                                            <a href="#" 
                                                               onclick="return confirm('Duplikat jenis surat ini?')"
                                                               class="w-full text-left px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 flex items-center gap-2">
                                                                <i class="fas fa-copy text-xs"></i>
                                                                Duplikat
                                                            </a>
                                                            
                                                            <!-- Divider -->
                                                            <hr class="my-1 border-gray-200">
                                                            
                                                            <!-- Delete -->
                                                            <form action="{{ route('admin.jenis_surat.destroy', $item->id) }}" 
                                                                  method="POST" 
                                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus jenis surat ini?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" 
                                                                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center gap-2">
                                                                    <i class="fas fa-trash text-xs"></i>
                                                                    Hapus
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
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
                                @foreach($jenisSurat as $item)
                                <div class="p-4 hover:bg-gray-50 transition-colors duration-150">
                                    <!-- Card Header -->
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-start gap-3">
                                                <div class="flex-shrink-0">
                                                    <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                                                        <i class="fas fa-file-alt text-blue-600"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <h4 class="text-sm font-semibold text-gray-900 truncate">
                                                        {{ $item->nama }}
                                                    </h4>
                                                    <div class="flex items-center gap-2 mt-1">
                                                        <span class="text-xs bg-blue-100 text-blue-800 px-1.5 py-0.5 rounded">
                                                            {{ $item->kode }}
                                                        </span>
                                                        @if($item->template === 'default')
                                                            <span class="text-xs bg-purple-100 text-purple-800 px-1.5 py-0.5 rounded">
                                                                Default
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <a href="{{ route('admin.jenis_surat.show', $item->id) }}" 
                                               class="p-1.5 text-gray-500 hover:text-blue-600">
                                                <i class="fas fa-eye text-sm"></i>
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <!-- Card Details -->
                                    <div class="space-y-3 text-sm">
                                        <!-- Status & Detail -->
                                        <div class="flex items-center justify-between">
                                            <form action="{{ route('admin.jenis_surat.update.status', $item->id) }}" 
                                                  method="POST" class="inline-block">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" 
                                                        class="badge {{ getStatusBadgeClass($item->is_active) }}"
                                                        onclick="return confirm('Ubah status jenis surat ini?')">
                                                    <i class="fas {{ getStatusIcon($item->is_active) }} mr-1"></i>
                                                    {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                                </button>
                                            </form>
                                            
                                            <div class="flex items-center gap-2">
                                                <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded">
                                                    {{ $item->estimasi_hari }}h
                                                </span>
                                                <span class="text-xs bg-green-100 text-green-800 px-2 py-0.5 rounded">
                                                    {{ formatCurrency($item->biaya) }}
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <!-- Deskripsi -->
                                        <p class="text-xs text-gray-500">
                                            {{ Str::limit($item->deskripsi, 80) }}
                                        </p>
                                        
                                        <!-- Quick Actions -->
                                        <div class="pt-3 border-t border-gray-200">
                                            <div class="flex items-center justify-between">
                                                <div class="text-xs text-gray-500">
                                                    <i class="fas fa-file mr-1"></i>
                                                    {{ $item->surats_count ?? 0 }} surat dibuat
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <a href="{{ route('admin.jenis_surat.edit', $item->id) }}" 
                                                       class="p-1.5 text-gray-500 hover:text-yellow-600">
                                                        <i class="fas fa-edit text-sm"></i>
                                                    </a>
                                                    @if($item->template !== 'default')
                                                    <a href="{{ route('admin.jenis_surat.edit.template', $item->id) }}" 
                                                       class="p-1.5 text-gray-500 hover:text-purple-600">
                                                        <i class="fas fa-code text-sm"></i>
                                                    </a>
                                                    @endif
                                                </div>
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
                                        Menampilkan <span class="font-medium">{{ $jenisSurat->firstItem() }}</span> sampai 
                                        <span class="font-medium">{{ $jenisSurat->lastItem() }}</span> dari 
                                        <span class="font-medium">{{ $jenisSurat->total() }}</span> entri
                                    </div>
                                    <div class="flex justify-center sm:justify-end">
                                        {{ $jenisSurat->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="p-8 text-center">
                            <div class="empty-state-icon">
                                <i class="fas fa-file-alt text-xl"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">
                                Tidak ada jenis surat ditemukan
                            </h4>
                            <p class="text-gray-500 max-w-md mx-auto mb-6">
                                @if(request()->anyFilled(['status', 'template', 'search']))
                                    Tidak ada jenis surat yang sesuai dengan filter yang Anda pilih.
                                @else
                                    Belum ada jenis surat yang terdaftar.
                                @endif
                            </p>
                            <div class="space-x-3">
                                @if(request()->anyFilled(['status', 'template', 'search']))
                                <a href="{{ route('admin.jenis_surat.index') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg text-sm transition-colors duration-200 gap-2">
                                    <i class="fas fa-redo-alt mr-2"></i>
                                    Reset Filter
                                </a>
                                @endif
                                <a href="{{ route('admin.jenis_surat.create') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm transition-colors duration-200 gap-2">
                                    <i class="fas fa-plus-circle mr-2"></i>
                                    Tambah Jenis Surat
                                </a>
                            </div>
                        </div>
                    @endif
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
            
            // Konfirmasi sebelum menghapus
            document.querySelectorAll('form[onsubmit*="confirm"]').forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!confirm('Apakah Anda yakin ingin menghapus jenis surat ini?')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
    @endpush
</x-app-layout>