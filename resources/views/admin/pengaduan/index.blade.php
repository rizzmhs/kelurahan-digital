<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-gray-900">
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

    <div class="py-4 md:py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 md:gap-4 mb-6">
                <!-- Total Pengaduan -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-2 md:p-3 rounded-xl bg-blue-50 text-blue-600">
                                <i class="fas fa-exclamation-circle text-base md:text-lg"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-xs font-medium text-gray-500">Total Pengaduan</p>
                                <p class="text-xl md:text-2xl font-bold text-gray-900">{{ $pengaduans->total() }}</p>
                            </div>
                        </div>
                        <div class="mt-2 pt-2 border-t border-gray-100">
                            <span class="text-xs text-gray-500 flex items-center gap-1">
                                <i class="fas fa-list"></i>
                                Semua status
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Menunggu -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-2 md:p-3 rounded-xl bg-yellow-50 text-yellow-600">
                                <i class="fas fa-clock text-base md:text-lg"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-xs font-medium text-gray-500">Menunggu</p>
                                <p class="text-xl md:text-2xl font-bold text-gray-900">{{ $pengaduans->where('status', 'menunggu')->count() }}</p>
                            </div>
                        </div>
                        <div class="mt-2 pt-2 border-t border-gray-100">
                            <span class="text-xs text-gray-500 flex items-center gap-1">
                                <i class="fas fa-hourglass-half"></i>
                                Butuh verifikasi
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Diproses -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-2 md:p-3 rounded-xl bg-purple-50 text-purple-600">
                                <i class="fas fa-cog text-base md:text-lg"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-xs font-medium text-gray-500">Diproses</p>
                                <p class="text-xl md:text-2xl font-bold text-gray-900">{{ $pengaduans->where('status', 'diproses')->count() }}</p>
                            </div>
                        </div>
                        <div class="mt-2 pt-2 border-t border-gray-100">
                            <span class="text-xs text-gray-500 flex items-center gap-1">
                                <i class="fas fa-user-tie"></i>
                                Ditangani petugas
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Selesai -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-2 md:p-3 rounded-xl bg-green-50 text-green-600">
                                <i class="fas fa-check-circle text-base md:text-lg"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-xs font-medium text-gray-500">Selesai</p>
                                <p class="text-xl md:text-2xl font-bold text-gray-900">{{ $pengaduans->where('status', 'selesai')->count() }}</p>
                            </div>
                        </div>
                        <div class="mt-2 pt-2 border-t border-gray-100">
                            <span class="text-xs text-gray-500 flex items-center gap-1">
                                <i class="fas fa-flag-checkered"></i>
                                Tuntas ditangani
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Ditolak -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-2 md:p-3 rounded-xl bg-red-50 text-red-600">
                                <i class="fas fa-times-circle text-base md:text-lg"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-xs font-medium text-gray-500">Ditolak</p>
                                <p class="text-xl md:text-2xl font-bold text-gray-900">{{ $pengaduans->where('status', 'ditolak')->count() }}</p>
                            </div>
                        </div>
                        <div class="mt-2 pt-2 border-t border-gray-100">
                            <span class="text-xs text-gray-500 flex items-center gap-1">
                                <i class="fas fa-ban"></i>
                                Tidak dapat diproses
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter & Content Section -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
                <!-- Filter Panel -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 sticky top-6">
                        <div class="px-4 md:px-5 py-4 border-b border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-filter text-blue-500"></i>
                                Filter & Pencarian
                            </h3>
                        </div>
                        <form method="GET" action="{{ route('admin.pengaduan.index') }}" class="p-4 md:p-5">
                            <div class="space-y-4 md:space-y-5">
                                <!-- Status Filter -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                                        <i class="fas fa-tag text-gray-500 text-sm"></i>
                                        Status
                                    </label>
                                    <select name="status" 
                                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors">
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
                                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors">
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
                                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors">
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
                                               class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors">
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
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <!-- Header -->
                        <div class="px-4 md:px-5 py-4 border-b border-gray-100">
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
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        <i class="fas fa-tag mr-1.5 text-xs text-gray-500"></i>
                                                        {{ $pengaduan->kategori->nama_kategori ?? '-' }}
                                                    </span>
                                                    <div>
                                                        @php
                                                            $prioritasClasses = [
                                                                'rendah' => 'bg-gray-100 text-gray-800',
                                                                'sedang' => 'bg-yellow-100 text-yellow-800',
                                                                'tinggi' => 'bg-orange-100 text-orange-800',
                                                                'darurat' => 'bg-red-100 text-red-800'
                                                            ];
                                                        @endphp
                                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $prioritasClasses[$pengaduan->prioritas] ?? 'bg-gray-100 text-gray-800' }}">
                                                            <i class="fas fa-flag mr-1.5 text-xs"></i>
                                                            {{ ucfirst($pengaduan->prioritas) }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            
                                            <!-- Status -->
                                            <td class="px-6 py-4">
                                                @php
                                                    $statusClasses = [
                                                        'menunggu' => 'bg-yellow-100 text-yellow-800',
                                                        'diverifikasi' => 'bg-blue-100 text-blue-800',
                                                        'diproses' => 'bg-purple-100 text-purple-800',
                                                        'selesai' => 'bg-green-100 text-green-800',
                                                        'ditolak' => 'bg-red-100 text-red-800'
                                                    ];
                                                    $statusIcons = [
                                                        'menunggu' => 'fa-clock',
                                                        'diverifikasi' => 'fa-check-circle',
                                                        'diproses' => 'fa-cog',
                                                        'selesai' => 'fa-check',
                                                        'ditolak' => 'fa-times'
                                                    ];
                                                @endphp
                                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium {{ $statusClasses[$pengaduan->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                    <i class="fas {{ $statusIcons[$pengaduan->status] ?? 'fa-info-circle' }} mr-1.5 text-xs"></i>
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
                                                <div class="flex items-center gap-1.5">
                                                    <!-- View -->
                                                    <a href="{{ route('admin.pengaduan.show', $pengaduan) }}" 
                                                       class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200"
                                                       title="Lihat Detail">
                                                        <i class="fas fa-eye text-sm"></i>
                                                    </a>
                                                    
                                                    <!-- Quick Actions Dropdown -->
                                                    <div class="relative group">
                                                        <button class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                                                            <i class="fas fa-ellipsis-h text-sm"></i>
                                                        </button>
                                                        
                                                        <div class="absolute right-0 mt-1 w-40 bg-white rounded-lg shadow-lg border border-gray-200 z-10 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                                            <div class="py-1">
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
                                                <div>
                                                    @php
                                                        $statusClasses = [
                                                            'menunggu' => 'bg-yellow-100 text-yellow-800',
                                                            'diverifikasi' => 'bg-blue-100 text-blue-800',
                                                            'diproses' => 'bg-purple-100 text-purple-800',
                                                            'selesai' => 'bg-green-100 text-green-800',
                                                            'ditolak' => 'bg-red-100 text-red-800'
                                                        ];
                                                    @endphp
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $statusClasses[$pengaduan->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                        {{ ucfirst($pengaduan->status) }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $prioritasClasses[$pengaduan->prioritas] ?? 'bg-gray-100 text-gray-800' }}">
                                                        {{ ucfirst($pengaduan->prioritas) }}
                                                    </span>
                                                </div>
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
                                                <form action="{{ route('admin.pengaduan.verifikasi', $pengaduan) }}" method="POST" class="inline w-full">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="w-full px-3 py-1.5 bg-green-50 hover:bg-green-100 text-green-700 text-xs font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2"
                                                            onclick="return confirm('Verifikasi pengaduan ini?')">
                                                        <i class="fas fa-check-circle text-xs"></i>
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
                            <div class="px-4 md:px-5 py-4 border-t border-gray-200 bg-gray-50">
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
                        @else
                            <!-- Empty State -->
                            <div class="p-6 md:p-8 text-center">
                                <div class="mx-auto w-14 h-14 md:w-16 md:h-16 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                                    <i class="fas fa-inbox text-gray-400 text-xl"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                    Tidak ada pengaduan ditemukan
                                </h3>
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
                                        <i class="fas fa-redo-alt"></i>
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
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-4 md:px-5 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-bolt text-yellow-500"></i>
                        Aksi Cepat
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">Aksi cepat untuk manajemen pengaduan</p>
                </div>
                <div class="p-4 md:p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4">
                        <!-- Verifikasi Massal -->
                        <a href="#" 
                           onclick="return confirm('Verifikasi semua pengaduan yang menunggu?')"
                           class="group p-4 border border-gray-200 rounded-xl hover:border-green-300 hover:shadow-sm transition-all duration-200 text-center sm:text-left">
                            <div class="flex flex-col items-center sm:items-start gap-3">
                                <div class="p-3 rounded-lg bg-green-50 group-hover:bg-green-100 transition-colors duration-200">
                                    <i class="fas fa-check-double text-green-600 text-lg"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900 group-hover:text-green-600 transition-colors duration-200">
                                        Verifikasi Massal
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1 hidden sm:block">
                                        Verifikasi semua pengaduan menunggu
                                    </p>
                                </div>
                                <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-green-500 mt-1 sm:mt-0"></i>
                            </div>
                        </a>

                        <!-- Export Data -->
                        <a href="{{ route('admin.pengaduan.export.excel') }}" 
                           class="group p-4 border border-gray-200 rounded-xl hover:border-blue-300 hover:shadow-sm transition-all duration-200 text-center sm:text-left">
                            <div class="flex flex-col items-center sm:items-start gap-3">
                                <div class="p-3 rounded-lg bg-blue-50 group-hover:bg-blue-100 transition-colors duration-200">
                                    <i class="fas fa-file-export text-blue-600 text-lg"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900 group-hover:text-blue-600 transition-colors duration-200">
                                        Export Data
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1 hidden sm:block">
                                        Export pengaduan ke Excel/PDF
                                    </p>
                                </div>
                                <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-blue-500 mt-1 sm:mt-0"></i>
                            </div>
                        </a>

                        <!-- Kelola Kategori -->
                        <a href="{{ route('admin.kategori_pengaduan.index') }}" 
                           class="group p-4 border border-gray-200 rounded-xl hover:border-purple-300 hover:shadow-sm transition-all duration-200 text-center sm:text-left">
                            <div class="flex flex-col items-center sm:items-start gap-3">
                                <div class="p-3 rounded-lg bg-purple-50 group-hover:bg-purple-100 transition-colors duration-200">
                                    <i class="fas fa-tags text-purple-600 text-lg"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900 group-hover:text-purple-600 transition-colors duration-200">
                                        Kelola Kategori
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1 hidden sm:block">
                                        Tambah/edit kategori pengaduan
                                    </p>
                                </div>
                                <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-purple-500 mt-1 sm:mt-0"></i>
                            </div>
                        </a>

                        <!-- Laporan -->
                        <a href="{{ route('admin.laporan') }}" 
                           class="group p-4 border border-gray-200 rounded-xl hover:border-orange-300 hover:shadow-sm transition-all duration-200 text-center sm:text-left">
                            <div class="flex flex-col items-center sm:items-start gap-3">
                                <div class="p-3 rounded-lg bg-orange-50 group-hover:bg-orange-100 transition-colors duration-200">
                                    <i class="fas fa-chart-bar text-orange-600 text-lg"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900 group-hover:text-orange-600 transition-colors duration-200">
                                        Laporan
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1 hidden sm:block">
                                        Lihat laporan statistik pengaduan
                                    </p>
                                </div>
                                <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-orange-500 mt-1 sm:mt-0"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .shadow-sm {
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }
        
        .hover\:shadow-md:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        /* Custom scrollbar */
        .overflow-x-auto::-webkit-scrollbar {
            height: 6px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 3px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }
        
        /* Dropdown animation */
        .group:hover .group-hover\:visible {
            visibility: visible;
        }
        
        .group:hover .group-hover\:opacity-100 {
            opacity: 1;
        }
        
        /* Sticky filter */
        .sticky {
            position: sticky;
        }
    </style>
    @endpush
</x-app-layout>