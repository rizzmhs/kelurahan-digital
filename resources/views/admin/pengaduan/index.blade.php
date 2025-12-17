@php
    // Helper functions untuk konsistensi
    if (!function_exists('getPrioritasClass')) {
        function getPrioritasClass($prioritas) {
            $classes = [
                'rendah' => 'bg-gray-100 text-gray-800',
                'sedang' => 'bg-yellow-100 text-yellow-800',
                'tinggi' => 'bg-orange-100 text-orange-800',
                'darurat' => 'bg-red-100 text-red-800'
            ];
            return $classes[$prioritas] ?? 'bg-gray-100 text-gray-800';
        }
    }
    
    if (!function_exists('getStatusIcon')) {
        function getStatusIcon($status) {
            $icons = [
                'menunggu' => 'fa-clock',
                'diverifikasi' => 'fa-check-circle',
                'diproses' => 'fa-cog',
                'selesai' => 'fa-check',
                'ditolak' => 'fa-times',
                'diterima' => 'fa-check-circle'
            ];
            return $icons[$status] ?? 'fa-info-circle';
        }
    }
    
    // Function untuk badge class pengaduan
    function getPengaduanBadgeClass($status) {
        $badgeClasses = [
            'menunggu' => 'badge-menunggu',
            'diverifikasi' => 'badge-diajukan',
            'diproses' => 'badge-diproses',
            'selesai' => 'badge-selesai',
            'ditolak' => 'badge-ditolak',
            'diterima' => 'badge-diproses'
        ];
        return $badgeClasses[$status] ?? 'badge-draft';
    }
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    Kelola Pengaduan
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    Manajemen semua pengaduan masyarakat
                </p>
            </div>
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <i class="fas fa-exclamation-triangle text-blue-500"></i>
                <span>Total: <span class="font-semibold text-gray-900">{{ $pengaduans->total() }}</span> pengaduan</span>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Stats Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
            <!-- Total Pengaduan -->
            <div class="stats-card">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="stats-icon stats-icon-blue">
                            <i class="fas fa-exclamation-circle text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $pengaduans->total() }}</p>
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

            <!-- Menunggu -->
            <div class="stats-card">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="stats-icon stats-icon-yellow">
                            <i class="fas fa-clock text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Menunggu</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $pengaduans->where('status', 'menunggu')->count() }}</p>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <span class="text-xs text-gray-500 flex items-center">
                            <i class="fas fa-hourglass-half mr-2"></i>
                            Butuh verifikasi
                        </span>
                    </div>
                </div>
            </div>

            <!-- Diproses -->
            <div class="stats-card">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="stats-icon stats-icon-purple">
                            <i class="fas fa-cog text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Diproses</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $pengaduans->where('status', 'diproses')->count() }}</p>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <span class="text-xs text-gray-500 flex items-center">
                            <i class="fas fa-user-tie mr-2"></i>
                            Ditangani petugas
                        </span>
                    </div>
                </div>
            </div>

            <!-- Selesai -->
            <div class="stats-card">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="stats-icon stats-icon-green">
                            <i class="fas fa-check-circle text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Selesai</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $pengaduans->where('status', 'selesai')->count() }}</p>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <span class="text-xs text-gray-500 flex items-center">
                            <i class="fas fa-flag-checkered mr-2"></i>
                            Tuntas ditangani
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
                            <p class="text-2xl font-bold text-gray-900">{{ $pengaduans->where('status', 'ditolak')->count() }}</p>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <span class="text-xs text-gray-500 flex items-center">
                            <i class="fas fa-ban mr-2"></i>
                            Tidak dapat diproses
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
                    <form method="GET" action="{{ route('admin.pengaduan.index') }}" class="p-5">
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
                                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="diverifikasi" {{ request('status') == 'diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
                                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>

                            <!-- Kategori Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                                    <i class="fas fa-folder text-gray-500 text-sm"></i>
                                    Kategori
                                </label>
                                <select name="kategori" 
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    <option value="">Semua Kategori</option>
                                    @foreach($kategories as $kategori)
                                        <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                                            {{ $kategori->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Prioritas Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                                    <i class="fas fa-flag text-gray-500 text-sm"></i>
                                    Prioritas
                                </label>
                                <select name="prioritas" 
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    <option value="">Semua Prioritas</option>
                                    <option value="rendah" {{ request('prioritas') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                                    <option value="sedang" {{ request('prioritas') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                    <option value="tinggi" {{ request('prioritas') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                                    <option value="darurat" {{ request('prioritas') == 'darurat' ? 'selected' : '' }}>Darurat</option>
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
                                           placeholder="Cari kode, judul, atau nama..."
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
                                
                                <a href="{{ route('admin.pengaduan.index') }}" 
                                   class="w-full px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg text-sm transition-colors duration-200 flex items-center justify-center gap-2">
                                    <i class="fas fa-redo"></i>
                                    Reset Semua
                                </a>

                                <a href="{{ route('admin.pengaduan.export.excel') }}" 
                                   class="w-full px-4 py-2.5 bg-green-50 hover:bg-green-100 text-green-700 font-medium rounded-lg text-sm transition-colors duration-200 flex items-center justify-center gap-2">
                                    <i class="fas fa-file-excel"></i>
                                    Export Excel
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
                                    Daftar Pengaduan
                                </h3>
                                @if(request()->anyFilled(['status', 'kategori', 'prioritas', 'search']))
                                <p class="text-sm text-gray-500 mt-1">
                                    Filter aktif: 
                                    @if(request('status')) <span class="font-medium text-blue-600">{{ request('status') }}</span> @endif
                                    @if(request('kategori')) <span class="font-medium text-purple-600">{{ $kategories->where('id', request('kategori'))->first()->nama_kategori ?? '' }}</span> @endif
                                    @if(request('prioritas')) <span class="font-medium text-orange-600">{{ request('prioritas') }}</span> @endif
                                    @if(request('search')) <span class="font-medium text-gray-600">"{{ request('search') }}"</span> @endif
                                </p>
                                @endif
                            </div>
                            
                            <div class="flex items-center gap-3">
                                <span class="text-sm text-gray-500">
                                    <span class="font-medium text-gray-900">{{ $pengaduans->firstItem() ?? 0 }}-{{ $pengaduans->lastItem() ?? 0 }}</span>
                                    dari {{ $pengaduans->total() }}
                                </span>
                            </div>
                        </div>
                    </div>

                    @if($pengaduans->count() > 0)
                        <!-- Desktop Table -->
                        <div class="hidden lg:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Pengaduan
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Pelapor
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Kategori & Prioritas
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tanggal
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($pengaduans as $pengaduan)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <!-- Pengaduan Info -->
                                        <td class="px-6 py-4">
                                            <div class="flex items-start gap-3">
                                                <div class="flex-shrink-0">
                                                    <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                                                        <i class="fas fa-exclamation-circle text-blue-600"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="text-sm font-semibold text-gray-900">
                                                        {{ $pengaduan->kode_pengaduan }}
                                                    </div>
                                                    <div class="text-sm text-gray-500 mt-0.5">
                                                        {{ Str::limit($pengaduan->judul, 50) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <!-- Pelapor -->
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $pengaduan->user->name ?? '-' }}</div>
                                            <div class="text-xs text-gray-500 mt-0.5">{{ $pengaduan->user->telepon ?? '-' }}</div>
                                        </td>
                                        
                                        <!-- Kategori & Prioritas -->
                                        <td class="px-6 py-4">
                                            <div class="space-y-2">
                                                <span class="badge bg-gray-100 text-gray-800">
                                                    <i class="fas fa-tag mr-1"></i>
                                                    {{ $pengaduan->kategori->nama_kategori ?? '-' }}
                                                </span>
                                                <div>
                                                    <span class="badge {{ getPrioritasClass($pengaduan->prioritas) }}">
                                                        <i class="fas fa-flag mr-1"></i>
                                                        {{ ucfirst($pengaduan->prioritas) }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <!-- Status -->
                                        <td class="px-6 py-4">
                                            <span class="badge {{ getPengaduanBadgeClass($pengaduan->status) }}">
                                                <i class="fas {{ getStatusIcon($pengaduan->status) }} mr-1"></i>
                                                {{ ucfirst($pengaduan->status) }}
                                            </span>
                                        </td>
                                        
                                        <!-- Tanggal -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 font-medium">{{ $pengaduan->created_at->format('d M Y') }}</div>
                                            <div class="text-xs text-gray-500">{{ $pengaduan->created_at->format('H:i') }}</div>
                                        </td>
                                        
                                        <!-- Actions -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-2">
                                                <!-- View -->
                                                <a href="{{ route('admin.pengaduan.show', $pengaduan) }}" 
                                                   class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200"
                                                   title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                
                                                <!-- Quick Actions Dropdown -->
                                                <div class="relative group">
                                                    <button class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                                                        <i class="fas fa-ellipsis-h"></i>
                                                    </button>
                                                    
                                                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-200 z-10 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                                        <div class="py-2">
                                                            @if($pengaduan->status === 'menunggu')
                                                            <form action="{{ route('admin.pengaduan.verifikasi', $pengaduan) }}" method="POST">
                                                                @csrf
                                                                <button type="submit" 
                                                                        class="w-full text-left px-4 py-2 text-sm text-green-600 hover:bg-green-50 flex items-center gap-2"
                                                                        onclick="return confirm('Verifikasi pengaduan ini?')">
                                                                    <i class="fas fa-check-circle text-xs"></i>
                                                                    Verifikasi
                                                                </button>
                                                            </form>
                                                            @endif
                                                            
                                                            @if($pengaduan->status === 'diproses')
                                                            <form action="{{ route('admin.pengaduan.selesai', $pengaduan) }}" method="POST">
                                                                @csrf
                                                                <button type="submit" 
                                                                        class="w-full text-left px-4 py-2 text-sm text-blue-600 hover:bg-blue-50 flex items-center gap-2"
                                                                        onclick="return confirm('Tandai sebagai selesai?')">
                                                                    <i class="fas fa-check text-xs"></i>
                                                                    Selesai
                                                                </button>
                                                            </form>
                                                            @endif
                                                            
                                                            <form action="{{ route('admin.pengaduan.tolak', $pengaduan) }}" method="POST" 
                                                                  onsubmit="return confirm('Tolak pengaduan ini?')">
                                                                @csrf
                                                                <button type="submit" 
                                                                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center gap-2">
                                                                    <i class="fas fa-times text-xs"></i>
                                                                    Tolak
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
                                @foreach($pengaduans as $pengaduan)
                                <div class="p-4 hover:bg-gray-50 transition-colors duration-150">
                                    <!-- Card Header -->
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-start gap-3">
                                                <div class="flex-shrink-0">
                                                    <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                                                        <i class="fas fa-exclamation-circle text-blue-600"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <h4 class="text-sm font-semibold text-gray-900 truncate">
                                                        {{ $pengaduan->kode_pengaduan }}
                                                    </h4>
                                                    <p class="text-xs text-gray-500 mt-0.5 truncate">
                                                        {{ Str::limit($pengaduan->judul, 50) }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <a href="{{ route('admin.pengaduan.show', $pengaduan) }}" 
                                               class="p-1.5 text-gray-500 hover:text-blue-600">
                                                <i class="fas fa-eye text-sm"></i>
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <!-- Card Details -->
                                    <div class="space-y-3 text-sm">
                                        <!-- Status & Prioritas -->
                                        <div class="flex items-center justify-between">
                                            <span class="badge {{ getPengaduanBadgeClass($pengaduan->status) }}">
                                                <i class="fas {{ getStatusIcon($pengaduan->status) }} mr-1"></i>
                                                {{ ucfirst($pengaduan->status) }}
                                            </span>
                                            <span class="badge {{ getPrioritasClass($pengaduan->prioritas) }}">
                                                <i class="fas fa-flag mr-1"></i>
                                                {{ ucfirst($pengaduan->prioritas) }}
                                            </span>
                                        </div>
                                        
                                        <!-- Info -->
                                        <div class="grid grid-cols-2 gap-3">
                                            <div>
                                                <p class="text-xs text-gray-500 mb-1">Pelapor</p>
                                                <p class="text-sm font-medium text-gray-900 truncate">{{ $pengaduan->user->name ?? '-' }}</p>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500 mb-1">Kategori</p>
                                                <p class="text-sm font-medium text-gray-900">{{ $pengaduan->kategori->nama_kategori ?? '-' }}</p>
                                            </div>
                                        </div>
                                        
                                        <!-- Quick Actions -->
                                        @if($pengaduan->status === 'menunggu')
                                        <div class="pt-3 border-t border-gray-200">
                                            <form action="{{ route('admin.pengaduan.verifikasi', $pengaduan) }}" method="POST" class="w-full">
                                                @csrf
                                                <button type="submit" 
                                                        class="w-full px-4 py-2 bg-green-50 hover:bg-green-100 text-green-700 text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2"
                                                        onclick="return confirm('Verifikasi pengaduan ini?')">
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
                                        Menampilkan <span class="font-medium">{{ $pengaduans->firstItem() }}</span> sampai 
                                        <span class="font-medium">{{ $pengaduans->lastItem() }}</span> dari 
                                        <span class="font-medium">{{ $pengaduans->total() }}</span> entri
                                    </div>
                                    <div class="flex justify-center sm:justify-end">
                                        {{ $pengaduans->links() }}
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
                                Tidak ada pengaduan ditemukan
                            </h4>
                            <p class="text-gray-500 max-w-md mx-auto mb-6">
                                @if(request()->anyFilled(['status', 'kategori', 'prioritas', 'search']))
                                    Tidak ada pengaduan yang sesuai dengan filter yang Anda pilih.
                                @else
                                    Belum ada pengaduan yang diajukan oleh masyarakat.
                                @endif
                            </p>
                            @if(request()->anyFilled(['status', 'kategori', 'prioritas', 'search']))
                            <div class="space-x-3">
                                <a href="{{ route('admin.pengaduan.index') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm transition-colors duration-200 gap-2">
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
                <p class="text-sm text-gray-500 mt-1">Aksi cepat untuk manajemen pengaduan</p>
            </div>
            <div class="card-body">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Verifikasi Massal -->
                    <a href="#" 
                       onclick="return confirm('Verifikasi semua pengaduan yang menunggu?')"
                       class="group p-5 border border-gray-200 rounded-xl hover:border-green-300 hover:shadow-sm transition-all duration-200 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="stats-icon stats-icon-green group-hover:bg-green-100">
                                <i class="fas fa-check-double text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 group-hover:text-green-600">
                                    Verifikasi Massal
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    Verifikasi semua pengaduan menunggu
                                </p>
                            </div>
                            <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-green-500"></i>
                        </div>
                    </a>

                    <!-- Export Data -->
                    <a href="{{ route('admin.pengaduan.export.excel') }}" 
                       class="group p-5 border border-gray-200 rounded-xl hover:border-blue-300 hover:shadow-sm transition-all duration-200 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="stats-icon stats-icon-blue group-hover:bg-blue-100">
                                <i class="fas fa-file-export text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 group-hover:text-blue-600">
                                    Export Data
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    Export pengaduan ke Excel/PDF
                                </p>
                            </div>
                            <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-blue-500"></i>
                        </div>
                    </a>

                    <!-- Kelola Kategori -->
                    <a href="{{ route('admin.kategori_pengaduan.index') }}" 
                       class="group p-5 border border-gray-200 rounded-xl hover:border-purple-300 hover:shadow-sm transition-all duration-200 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="stats-icon stats-icon-purple group-hover:bg-purple-100">
                                <i class="fas fa-tags text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 group-hover:text-purple-600">
                                    Kelola Kategori
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    Tambah/edit kategori pengaduan
                                </p>
                            </div>
                            <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-purple-500"></i>
                        </div>
                    </a>

                    <!-- Laporan -->
                    <a href="{{ route('admin.laporan') }}" 
                       class="group p-5 border border-gray-200 rounded-xl hover:border-orange-300 hover:shadow-sm transition-all duration-200 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="stats-icon stats-icon-orange group-hover:bg-orange-100">
                                <i class="fas fa-chart-bar text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 group-hover:text-orange-600">
                                    Laporan
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    Lihat laporan statistik pengaduan
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
        });
    </script>
    @endpush
</x-app-layout>