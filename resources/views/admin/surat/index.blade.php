@php
    // Helper functions untuk konsistensi
    if (!function_exists('getStatusBadgeClass')) {
        function getStatusBadgeClass($status) {
            $classes = [
                'draft' => 'bg-gray-100 text-gray-800',
                'diajukan' => 'bg-yellow-100 text-yellow-800',
                'diproses' => 'bg-blue-100 text-blue-800',
                'siap_ambil' => 'bg-green-100 text-green-800',
                'selesai' => 'bg-green-100 text-green-800',
                'ditolak' => 'bg-red-100 text-red-800'
            ];
            return $classes[$status] ?? 'bg-gray-100 text-gray-800';
        }
    }
    
    if (!function_exists('getStatusIcon')) {
        function getStatusIcon($status) {
            $icons = [
                'draft' => 'fa-file',
                'diajukan' => 'fa-clock',
                'diproses' => 'fa-cog',
                'siap_ambil' => 'fa-check-circle',
                'selesai' => 'fa-check',
                'ditolak' => 'fa-times'
            ];
            return $icons[$status] ?? 'fa-file';
        }
    }
    
    if (!function_exists('formatStatusText')) {
        function formatStatusText($status) {
            return str_replace('_', ' ', ucfirst($status));
        }
    }
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    Kelola Pengajuan Surat
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    Manajemen semua pengajuan surat warga
                </p>
            </div>
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <i class="fas fa-file-alt text-blue-500"></i>
                <span>Total: <span class="font-semibold text-gray-900">{{ $surats->total() }}</span> pengajuan</span>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Stats Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-6 gap-4">
            <!-- Total Surat -->
            <div class="stats-card">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="stats-icon stats-icon-blue">
                            <i class="fas fa-file-alt text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $surats->total() }}</p>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <span class="text-xs text-gray-500 flex items-center">
                            <i class="fas fa-list mr-2"></i>
                            Semua status
                        </span>
                    </div>
                </div>
            </div>

            <!-- Diajukan -->
            <div class="stats-card">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="stats-icon stats-icon-yellow">
                            <i class="fas fa-clock text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Diajukan</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $surats->where('status', 'diajukan')->count() }}</p>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <span class="text-xs text-gray-500 flex items-center">
                            <i class="fas fa-hourglass-half mr-2"></i>
                            Menunggu verifikasi
                        </span>
                    </div>
                </div>
            </div>

            <!-- Diproses -->
            <div class="stats-card">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="stats-icon stats-icon-blue">
                            <i class="fas fa-cog text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Diproses</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $surats->where('status', 'diproses')->count() }}</p>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <span class="text-xs text-gray-500 flex items-center">
                            <i class="fas fa-user-tie mr-2"></i>
                            Sedang diproses
                        </span>
                    </div>
                </div>
            </div>

            <!-- Siap Diambil -->
            <div class="stats-card">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="stats-icon stats-icon-green">
                            <i class="fas fa-check-circle text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Siap Diambil</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $surats->where('status', 'siap_ambil')->count() }}</p>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <span class="text-xs text-gray-500 flex items-center">
                            <i class="fas fa-flag-checkered mr-2"></i>
                            Tersedia untuk diambil
                        </span>
                    </div>
                </div>
            </div>

            <!-- Selesai -->
            <div class="stats-card">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="stats-icon stats-icon-green">
                            <i class="fas fa-check text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Selesai</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $surats->where('status', 'selesai')->count() }}</p>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <span class="text-xs text-gray-500 flex items-center">
                            <i class="fas fa-check-double mr-2"></i>
                            Sudah diambil
                        </span>
                    </div>
                </div>
            </div>

            <!-- Ditolak -->
            <div class="stats-card">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="stats-icon stats-icon-red">
                            <i class="fas fa-times-circle text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Ditolak</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $surats->where('status', 'ditolak')->count() }}</p>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <span class="text-xs text-gray-500 flex items-center">
                            <i class="fas fa-ban mr-2"></i>
                            Tidak disetujui
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
                    <form method="GET" action="{{ route('admin.surat.index') }}" class="p-5">
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
                                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="siap_ambil" {{ request('status') == 'siap_ambil' ? 'selected' : '' }}>Siap Diambil</option>
                                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>

                            <!-- Jenis Surat Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                                    <i class="fas fa-envelope text-gray-500 text-sm"></i>
                                    Jenis Surat
                                </label>
                                <select name="jenis_surat" 
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    <option value="">Semua Jenis</option>
                                    @foreach($jenisSurat as $jenis)
                                        <option value="{{ $jenis->id }}" {{ request('jenis_surat') == $jenis->id ? 'selected' : '' }}>
                                            {{ $jenis->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Date Range -->
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                                        <i class="fas fa-calendar text-gray-500 text-sm"></i>
                                        Tanggal Dari
                                    </label>
                                    <input type="date" 
                                           name="tanggal_dari" 
                                           value="{{ request('tanggal_dari') }}"
                                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                                        <i class="fas fa-calendar text-gray-500 text-sm"></i>
                                        Tanggal Sampai
                                    </label>
                                    <input type="date" 
                                           name="tanggal_sampai" 
                                           value="{{ request('tanggal_sampai') }}"
                                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                </div>
                            </div>

                            <!-- Search -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                                    <i class="fas fa-search text-gray-500 text-sm"></i>
                                    Pencarian
                                </label>
                                <div class="relative">
                                    <input type="text" name="search" value="{{ request('search') }}"
                                           placeholder="Cari nama, NIK, atau nomor surat..."
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
                                
                                <a href="{{ route('admin.surat.index') }}" 
                                   class="w-full px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg text-sm transition-colors duration-200 flex items-center justify-center gap-2">
                                    <i class="fas fa-redo"></i>
                                    Reset Semua
                                </a>

                                <a href="{{ route('admin.surat.quick.create') }}" 
                                   class="w-full px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg text-sm transition-colors duration-200 flex items-center justify-center gap-2">
                                    <i class="fas fa-plus-circle"></i>
                                    Buat Surat Baru
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
                                    Daftar Pengajuan Surat
                                </h3>
                                @if(request()->anyFilled(['status', 'jenis_surat', 'tanggal_dari', 'tanggal_sampai', 'search']))
                                <p class="text-sm text-gray-500 mt-1">
                                    Filter aktif: 
                                    @if(request('status')) 
                                        <span class="badge {{ getStatusBadgeClass(request('status')) }}">
                                            {{ formatStatusText(request('status')) }}
                                        </span>
                                    @endif
                                    @if(request('jenis_surat')) 
                                        <span class="badge bg-purple-100 text-purple-800">
                                            {{ $jenisSurat->where('id', request('jenis_surat'))->first()->nama ?? '' }}
                                        </span>
                                    @endif
                                    @if(request('search')) 
                                        <span class="font-medium text-gray-600">"{{ request('search') }}"</span>
                                    @endif
                                </p>
                                @endif
                            </div>
                            
                            <div class="flex items-center gap-3">
                                <span class="text-sm text-gray-500">
                                    <span class="font-medium text-gray-900">{{ $surats->firstItem() ?? 0 }}-{{ $surats->lastItem() ?? 0 }}</span>
                                    dari {{ $surats->total() }}
                                </span>
                            </div>
                        </div>
                    </div>

                    @if($surats->count() > 0)
                        <!-- Desktop Table -->
                        <div class="hidden lg:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Surat
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Pemohon
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status & Tanggal
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($surats as $surat)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <!-- Surat Info -->
                                        <td class="px-6 py-4">
                                            <div class="flex items-start gap-3">
                                                <div class="flex-shrink-0">
                                                    <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                                                        <i class="fas fa-envelope text-blue-600"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="text-sm font-semibold text-gray-900">
                                                        {{ $surat->nomor_surat ?? 'Belum ada nomor' }}
                                                    </div>
                                                    <div class="text-sm text-gray-500 mt-0.5">
                                                        {{ $surat->jenisSurat->nama }}
                                                    </div>
                                                    <div class="text-xs text-gray-400 mt-0.5">
                                                        ID: {{ $surat->id }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <!-- Pemohon -->
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $surat->user->name ?? '-' }}</div>
                                            <div class="text-xs text-gray-500 mt-0.5">{{ $surat->user->nik ?? '-' }}</div>
                                            <div class="text-xs text-gray-400 mt-0.5 truncate max-w-xs">
                                                {{ Str::limit($surat->jenisSurat->deskripsi, 40) }}
                                            </div>
                                        </td>
                                        
                                        <!-- Status & Tanggal -->
                                        <td class="px-6 py-4">
                                            <div class="space-y-2">
                                                <span class="badge {{ getStatusBadgeClass($surat->status) }}">
                                                    <i class="fas {{ getStatusIcon($surat->status) }} mr-1"></i>
                                                    {{ formatStatusText($surat->status) }}
                                                </span>
                                                <div class="text-sm">
                                                    <div class="text-gray-900 font-medium">{{ $surat->created_at->format('d M Y') }}</div>
                                                    <div class="text-xs text-gray-500">{{ $surat->created_at->format('H:i') }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <!-- Actions -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-2">
                                                <!-- View -->
                                                <a href="{{ route('admin.surat.show', $surat) }}" 
                                                   class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200"
                                                   title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                
                                                <!-- Quick Actions -->
                                                @if($surat->status === 'diajukan')
                                                <form action="{{ route('admin.surat.verifikasi', $surat) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="p-2 text-gray-500 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors duration-200"
                                                            title="Verifikasi"
                                                            onclick="return confirm('Verifikasi pengajuan surat ini?')">
                                                        <i class="fas fa-check-circle"></i>
                                                    </button>
                                                </form>
                                                @endif
                                                
                                                <!-- Quick Actions Dropdown -->
                                                <div class="relative group">
                                                    <button class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                                                        <i class="fas fa-ellipsis-h"></i>
                                                    </button>
                                                    
                                                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-200 z-10 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                                        <div class="py-2">
                                                            <!-- Lihat Detail (sebagai pengganti edit) -->
                                                            <a href="{{ route('admin.surat.show', $surat) }}" 
                                                               class="w-full text-left px-4 py-2 text-sm text-yellow-600 hover:bg-yellow-50 flex items-center gap-2">
                                                                <i class="fas fa-edit text-xs"></i>
                                                                Lihat & Kelola
                                                            </a>
                                                            
                                                            @if($surat->status === 'siap_ambil')
                                                            <form action="{{ route('admin.surat.selesai', $surat) }}" method="POST">
                                                                @csrf
                                                                <button type="submit" 
                                                                        class="w-full text-left px-4 py-2 text-sm text-green-600 hover:bg-green-50 flex items-center gap-2"
                                                                        onclick="return confirm('Tandai surat sudah diambil?')">
                                                                    <i class="fas fa-check text-xs"></i>
                                                                    Tandai Diambil
                                                                </button>
                                                            </form>
                                                            @endif
                                                            
                                                            <!-- Preview -->
                                                            <a href="{{ route('admin.surat.preview', $surat) }}" 
                                                               target="_blank"
                                                               class="w-full text-left px-4 py-2 text-sm text-blue-600 hover:bg-blue-50 flex items-center gap-2">
                                                                <i class="fas fa-print text-xs"></i>
                                                                Cetak/Preview
                                                            </a>
                                                            
                                                            <!-- Download PDF -->
                                                            <a href="{{ route('admin.surat.download', $surat) }}" 
                                                               target="_blank"
                                                               class="w-full text-left px-4 py-2 text-sm text-purple-600 hover:bg-purple-50 flex items-center gap-2">
                                                                <i class="fas fa-download text-xs"></i>
                                                                Download PDF
                                                            </a>
                                                            
                                                            <!-- Generate PDF -->
                                                            <form action="{{ route('admin.surat.generate.pdf', $surat) }}" method="POST">
                                                                @csrf
                                                                <button type="submit" 
                                                                        class="w-full text-left px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 flex items-center gap-2">
                                                                    <i class="fas fa-file-pdf text-xs"></i>
                                                                    Generate PDF
                                                                </button>
                                                            </form>
                                                            
                                                            <!-- Divider -->
                                                            <hr class="my-1 border-gray-200">
                                                            
                                                            <!-- Delete -->
                                                            <form action="{{ route('admin.surat.destroy', $surat) }}" method="POST" 
                                                                  onsubmit="return confirm('Hapus pengajuan surat ini?')">
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
                                @foreach($surats as $surat)
                                <div class="p-4 hover:bg-gray-50 transition-colors duration-150">
                                    <!-- Card Header -->
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-start gap-3">
                                                <div class="flex-shrink-0">
                                                    <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                                                        <i class="fas fa-envelope text-blue-600"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <h4 class="text-sm font-semibold text-gray-900 truncate">
                                                        {{ $surat->jenisSurat->nama }}
                                                    </h4>
                                                    <div class="text-xs text-gray-500 mt-0.5 truncate">
                                                        {{ $surat->nomor_surat ?? 'Belum ada nomor' }}
                                                    </div>
                                                    <div class="text-xs text-gray-400 mt-0.5">
                                                        ID: {{ $surat->id }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <a href="{{ route('admin.surat.show', $surat) }}" 
                                               class="p-1.5 text-gray-500 hover:text-blue-600">
                                                <i class="fas fa-eye text-sm"></i>
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <!-- Card Details -->
                                    <div class="space-y-3 text-sm">
                                        <!-- Status & Tanggal -->
                                        <div class="flex items-center justify-between">
                                            <span class="badge {{ getStatusBadgeClass($surat->status) }}">
                                                <i class="fas {{ getStatusIcon($surat->status) }} mr-1"></i>
                                                {{ formatStatusText($surat->status) }}
                                            </span>
                                            <div class="text-xs text-gray-500">
                                                {{ $surat->created_at->format('d M Y') }}
                                            </div>
                                        </div>
                                        
                                        <!-- Info -->
                                        <div class="grid grid-cols-2 gap-3">
                                            <div>
                                                <p class="text-xs text-gray-500 mb-1">Pemohon</p>
                                                <p class="text-sm font-medium text-gray-900 truncate">{{ $surat->user->name ?? '-' }}</p>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500 mb-1">NIK</p>
                                                <p class="text-sm font-medium text-gray-900">{{ $surat->user->nik ?? '-' }}</p>
                                            </div>
                                        </div>
                                        
                                        <!-- Deskripsi -->
                                        <p class="text-xs text-gray-500">
                                            {{ Str::limit($surat->jenisSurat->deskripsi, 80) }}
                                        </p>
                                        
                                        <!-- Quick Actions -->
                                        @if($surat->status === 'diajukan')
                                        <div class="pt-3 border-t border-gray-200">
                                            <form action="{{ route('admin.surat.verifikasi', $surat) }}" method="POST" class="w-full">
                                                @csrf
                                                <button type="submit" 
                                                        class="w-full px-4 py-2 bg-green-50 hover:bg-green-100 text-green-700 text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2"
                                                        onclick="return confirm('Verifikasi pengajuan surat ini?')">
                                                    <i class="fas fa-check-circle"></i>
                                                    Verifikasi Sekarang
                                                </button>
                                            </form>
                                        </div>
                                        @endif
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
                                        Menampilkan <span class="font-medium">{{ $surats->firstItem() }}</span> sampai 
                                        <span class="font-medium">{{ $surats->lastItem() }}</span> dari 
                                        <span class="font-medium">{{ $surats->total() }}</span> entri
                                    </div>
                                    <div class="flex justify-center sm:justify-end">
                                        {{ $surats->links() }}
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
                                Tidak ada pengajuan surat ditemukan
                            </h4>
                            <p class="text-gray-500 max-w-md mx-auto mb-6">
                                @if(request()->anyFilled(['status', 'jenis_surat', 'tanggal_dari', 'tanggal_sampai', 'search']))
                                    Tidak ada pengajuan surat yang sesuai dengan filter yang Anda pilih.
                                @else
                                    Belum ada pengajuan surat dari warga.
                                @endif
                            </p>
                            @if(request()->anyFilled(['status', 'jenis_surat', 'tanggal_dari', 'tanggal_sampai', 'search']))
                            <div class="space-x-3">
                                <a href="{{ route('admin.surat.index') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg text-sm transition-colors duration-200 gap-2">
                                    <i class="fas fa-redo-alt mr-2"></i>
                                    Reset Filter
                                </a>
                            </div>
                            @endif
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
                <p class="text-sm text-gray-500 mt-1">Aksi cepat untuk manajemen pengajuan surat</p>
            </div>
            <div class="card-body">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Buat Surat Baru -->
                    <a href="{{ route('admin.surat.quick.create') }}" 
                       class="group p-5 border border-gray-200 rounded-xl hover:border-blue-300 hover:shadow-sm transition-all duration-200 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="stats-icon stats-icon-blue group-hover:bg-blue-100">
                                <i class="fas fa-plus text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 group-hover:text-blue-600">
                                    Buat Surat Baru
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    Buat surat untuk warga
                                </p>
                            </div>
                            <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-blue-500"></i>
                        </div>
                    </a>

                    <!-- Export Data -->
                    <a href="#" 
                       class="group p-5 border border-gray-200 rounded-xl hover:border-green-300 hover:shadow-sm transition-all duration-200 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="stats-icon stats-icon-green group-hover:bg-green-100">
                                <i class="fas fa-file-export text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 group-hover:text-green-600">
                                    Export Data
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    Export surat ke Excel/PDF
                                </p>
                            </div>
                            <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-green-500"></i>
                        </div>
                    </a>

                    <!-- Kelola Jenis Surat -->
                    <a href="{{ route('admin.jenis_surat.index') }}" 
                       class="group p-5 border border-gray-200 rounded-xl hover:border-purple-300 hover:shadow-sm transition-all duration-200 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="stats-icon stats-icon-purple group-hover:bg-purple-100">
                                <i class="fas fa-envelope-open-text text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 group-hover:text-purple-600">
                                    Kelola Jenis Surat
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    Tambah/edit jenis surat
                                </p>
                            </div>
                            <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-purple-500"></i>
                        </div>
                    </a>

                    <!-- Laporan Surat -->
                    <a href="{{ route('admin.laporan') }}" 
                       class="group p-5 border border-gray-200 rounded-xl hover:border-orange-300 hover:shadow-sm transition-all duration-200 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="stats-icon stats-icon-orange group-hover:bg-orange-100">
                                <i class="fas fa-chart-bar text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 group-hover:text-orange-600">
                                    Laporan Surat
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    Lihat laporan statistik surat
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
            
            // Konfirmasi sebelum verifikasi
            document.querySelectorAll('form[action*="verifikasi"] button').forEach(button => {
                button.addEventListener('click', function(e) {
                    if (!confirm('Verifikasi pengajuan surat ini?')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
    @endpush
</x-app-layout>