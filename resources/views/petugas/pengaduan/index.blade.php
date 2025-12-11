<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    Kelola Pengaduan
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    Manajemen pengaduan yang dapat Anda akses
                </p>
            </div>
            <div class="flex items-center space-x-2 text-sm text-gray-500">
                <i class="fas fa-user-tie text-green-500"></i>
                <span>Petugas: {{ auth()->user()->name }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
                <!-- Total Pengaduan -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="p-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 rounded-xl bg-blue-50 text-blue-600">
                                <i class="fas fa-tasks text-lg sm:text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-xs sm:text-sm font-medium text-gray-500">Total Pengaduan</p>
                                <p class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $pengaduans->total() }}</p>
                            </div>
                        </div>
                        <div class="mt-3 pt-3 border-t border-gray-100">
                            <span class="text-xs text-gray-500">
                                <i class="fas fa-eye mr-1"></i>
                                Semua pengaduan
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Diajukan -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="p-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 rounded-xl bg-yellow-50 text-yellow-600">
                                <i class="fas fa-clock text-lg sm:text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-xs sm:text-sm font-medium text-gray-500">Diajukan</p>
                                <p class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $pengaduans->where('status', 'diajukan')->count() }}</p>
                            </div>
                        </div>
                        <div class="mt-3 pt-3 border-t border-gray-100">
                            <span class="text-xs text-gray-500">
                                <i class="fas fa-hourglass-half mr-1"></i>
                                Butuh penanganan
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Diproses -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="p-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 rounded-xl bg-purple-50 text-purple-600">
                                <i class="fas fa-cog text-lg sm:text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-xs sm:text-sm font-medium text-gray-500">Diproses</p>
                                <p class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $pengaduans->where('status', 'diproses')->count() }}</p>
                            </div>
                        </div>
                        <div class="mt-3 pt-3 border-t border-gray-100">
                            <span class="text-xs text-gray-500">
                                <i class="fas fa-user-tie mr-1"></i>
                                Dalam penanganan
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Selesai -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="p-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 rounded-xl bg-green-50 text-green-600">
                                <i class="fas fa-check-circle text-lg sm:text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-xs sm:text-sm font-medium text-gray-500">Selesai</p>
                                <p class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $pengaduans->where('status', 'selesai')->count() }}</p>
                            </div>
                        </div>
                        <div class="mt-3 pt-3 border-t border-gray-100">
                            <span class="text-xs text-gray-500">
                                <i class="fas fa-flag-checkered mr-1"></i>
                                Tuntas ditangani
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter & Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
                <div class="p-5 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-sliders-h text-blue-600"></i>
                            <h3 class="text-base font-semibold text-gray-900">Filter & Pencarian</h3>
                        </div>
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('petugas.pengaduan.tugas-saya') }}" 
                               class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg text-sm transition-colors duration-200">
                                <i class="fas fa-user-check mr-2"></i>
                                Tugas Saya
                            </a>
                        </div>
                    </div>
                    
                    <form method="GET" action="{{ route('petugas.pengaduan.index') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Status Filter -->
                            <div class="space-y-1.5">
                                <label class="flex items-center text-sm font-medium text-gray-700">
                                    <i class="fas fa-tag mr-2 text-gray-400 text-xs"></i>
                                    Status
                                </label>
                                <select name="status" 
                                        class="w-full h-10 pl-3 pr-10 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                    <option value="">Semua Status</option>
                                    <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>

                            <!-- Prioritas Filter -->
                            <div class="space-y-1.5">
                                <label class="flex items-center text-sm font-medium text-gray-700">
                                    <i class="fas fa-flag mr-2 text-gray-400 text-xs"></i>
                                    Prioritas
                                </label>
                                <select name="prioritas" 
                                        class="w-full h-10 pl-3 pr-10 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                    <option value="">Semua Prioritas</option>
                                    <option value="rendah" {{ request('prioritas') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                                    <option value="sedang" {{ request('prioritas') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                    <option value="tinggi" {{ request('prioritas') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                                    <option value="darurat" {{ request('prioritas') == 'darurat' ? 'selected' : '' }}>Darurat</option>
                                </select>
                            </div>

                            <!-- Search -->
                            <div class="space-y-1.5">
                                <label class="flex items-center text-sm font-medium text-gray-700">
                                    <i class="fas fa-search mr-2 text-gray-400 text-xs"></i>
                                    Pencarian
                                </label>
                                <div class="relative">
                                    <input type="text" name="search" value="{{ request('search') }}"
                                           placeholder="Cari judul atau nama..."
                                           class="w-full h-10 pl-10 pr-4 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                    <i class="fas fa-search absolute left-3 top-3 text-gray-400 text-sm"></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-3 pt-2">
                            <button type="submit" 
                                    class="w-full sm:w-auto px-4 h-10 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm transition-colors duration-200 inline-flex items-center justify-center">
                                <i class="fas fa-filter mr-2"></i>
                                Terapkan Filter
                            </button>
                            
                            <a href="{{ route('petugas.pengaduan.index') }}" 
                               class="w-full sm:w-auto px-4 h-10 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg text-sm transition-colors duration-200 inline-flex items-center justify-center">
                                <i class="fas fa-redo mr-2"></i>
                                Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Header -->
                <div class="px-5 sm:px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-list-ul text-gray-500"></i>
                            <h3 class="text-base font-semibold text-gray-900">Daftar Pengaduan</h3>
                            <span class="px-2 py-1 text-xs font-medium bg-gray-200 text-gray-800 rounded-full">
                                {{ $pengaduans->total() }} data
                            </span>
                        </div>
                        
                        <div class="text-sm text-gray-600">
                            <span class="font-medium">{{ $pengaduans->firstItem() ?? 0 }}-{{ $pengaduans->lastItem() ?? 0 }}</span>
                            dari {{ $pengaduans->total() }} entri
                        </div>
                    </div>
                </div>

                @if($pengaduans->count() > 0)
                    <!-- Desktop Table -->
                    <div class="hidden lg:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                        <div class="flex items-center">
                                            <i class="fas fa-hashtag mr-2 text-gray-400"></i>
                                            Kode / Judul
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                        <div class="flex items-center">
                                            <i class="fas fa-user mr-2 text-gray-400"></i>
                                            Pemohon
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                        <div class="flex items-center">
                                            <i class="fas fa-info-circle mr-2 text-gray-400"></i>
                                            Status
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                        <div class="flex items-center">
                                            <i class="fas fa-flag mr-2 text-gray-400"></i>
                                            Prioritas
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                        <div class="flex items-center">
                                            <i class="far fa-calendar mr-2 text-gray-400"></i>
                                            Tanggal
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                        <div class="flex items-center">
                                            <i class="fas fa-cog mr-2 text-gray-400"></i>
                                            Aksi
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($pengaduans as $pengaduan)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <!-- Kode & Judul -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-start space-x-3">
                                            <div class="flex-shrink-0">
                                                <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                                                    <i class="fas fa-exclamation-circle text-blue-600"></i>
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="text-sm font-semibold text-gray-900">
                                                    {{ $pengaduan->kode_pengaduan }}
                                                </div>
                                                <div class="text-sm text-gray-500 mt-0.5 truncate max-w-xs">
                                                    {{ Str::limit($pengaduan->judul, 50) }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <!-- Pemohon -->
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $pengaduan->user->name ?? '-' }}</div>
                                        <div class="text-xs text-gray-500 mt-0.5">{{ $pengaduan->user->nik ?? '-' }}</div>
                                    </td>
                                    
                                    <!-- Status -->
                                    <td class="px-6 py-4">
                                        @php
                                            $statusClasses = [
                                                'diajukan' => 'bg-yellow-100 text-yellow-800',
                                                'diproses' => 'bg-purple-100 text-purple-800',
                                                'selesai' => 'bg-green-100 text-green-800',
                                                'ditolak' => 'bg-red-100 text-red-800'
                                            ];
                                            $statusIcons = [
                                                'diajukan' => 'fa-clock',
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
                                    
                                    <!-- Prioritas -->
                                    <td class="px-6 py-4">
                                        @php
                                            $prioritasClasses = [
                                                'rendah' => 'bg-gray-100 text-gray-800',
                                                'sedang' => 'bg-blue-100 text-blue-800',
                                                'tinggi' => 'bg-orange-100 text-orange-800',
                                                'darurat' => 'bg-red-100 text-red-800'
                                            ];
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $prioritasClasses[$pengaduan->prioritas] ?? 'bg-gray-100 text-gray-800' }}">
                                            <i class="fas fa-flag mr-1.5 text-xs"></i>
                                            {{ ucfirst($pengaduan->prioritas) }}
                                        </span>
                                    </td>
                                    
                                    <!-- Tanggal -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 font-medium">{{ $pengaduan->created_at->format('d M Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $pengaduan->created_at->format('H:i') }}</div>
                                    </td>
                                    
                                    <!-- Actions -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <!-- View -->
                                            <a href="{{ route('petugas.pengaduan.show', $pengaduan) }}" 
                                               class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200"
                                               title="Lihat Detail">
                                                <i class="fas fa-eye text-sm"></i>
                                            </a>
                                            
                                            <!-- Quick Actions -->
                                            @if($pengaduan->status == 'diajukan')
                                            <form action="{{ route('petugas.pengaduan.update.status', $pengaduan) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="diproses">
                                                <button type="submit" 
                                                        class="p-2 text-gray-500 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition-colors duration-200"
                                                        title="Proses Pengaduan"
                                                        onclick="return confirm('Mulai proses pengaduan ini?')">
                                                    <i class="fas fa-cog text-sm"></i>
                                                </button>
                                            </form>
                                            @endif

                                            @if($pengaduan->status == 'diproses')
                                            <form action="{{ route('petugas.pengaduan.update.status', $pengaduan) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="selesai">
                                                <button type="submit" 
                                                        class="p-2 text-gray-500 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors duration-200"
                                                        title="Tandai Selesai"
                                                        onclick="return confirm('Tandai pengaduan sebagai selesai?')">
                                                    <i class="fas fa-check text-sm"></i>
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

                    <!-- Mobile/Tablet Cards -->
                    <div class="lg:hidden">
                        <div class="divide-y divide-gray-200">
                            @foreach($pengaduans as $pengaduan)
                            <div class="p-4 hover:bg-gray-50 transition-colors duration-150">
                                <!-- Card Header -->
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-start space-x-3">
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
                                                    {{ Str::limit($pengaduan->judul, 40) }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        <a href="{{ route('petugas.pengaduan.show', $pengaduan) }}" 
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
                                            <p class="text-xs text-gray-500 mb-1">Pemohon</p>
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $pengaduan->user->name ?? '-' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 mb-1">Tanggal</p>
                                            <p class="text-sm font-medium text-gray-900">{{ $pengaduan->created_at->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                    
                                    <!-- Quick Actions -->
                                    <div class="pt-3 border-t border-gray-200">
                                        <div class="flex items-center space-x-2">
                                            @if($pengaduan->status == 'diajukan')
                                            <form action="{{ route('petugas.pengaduan.update.status', $pengaduan) }}" method="POST" class="flex-1">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="diproses">
                                                <button type="submit" 
                                                        class="w-full px-3 py-1.5 bg-purple-50 hover:bg-purple-100 text-purple-700 text-xs font-medium rounded-lg transition-colors duration-200 flex items-center justify-center"
                                                        onclick="return confirm('Mulai proses pengaduan ini?')">
                                                    <i class="fas fa-cog mr-1.5 text-xs"></i>
                                                    Proses Sekarang
                                                </button>
                                            </form>
                                            @endif

                                            @if($pengaduan->status == 'diproses')
                                            <form action="{{ route('petugas.pengaduan.update.status', $pengaduan) }}" method="POST" class="flex-1">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="selesai">
                                                <button type="submit" 
                                                        class="w-full px-3 py-1.5 bg-green-50 hover:bg-green-100 text-green-700 text-xs font-medium rounded-lg transition-colors duration-200 flex items-center justify-center"
                                                        onclick="return confirm('Tandai pengaduan sebagai selesai?')">
                                                    <i class="fas fa-check mr-1.5 text-xs"></i>
                                                    Tandai Selesai
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="px-4 sm:px-5 py-4 border-t border-gray-200 bg-gray-50">
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
                    <div class="p-8 sm:p-10 text-center">
                        <div class="mx-auto w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                            <i class="fas fa-tasks text-gray-400 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">
                            Tidak ada pengaduan ditemukan
                        </h3>
                        <p class="text-gray-500 max-w-md mx-auto mb-6">
                            @if(request()->anyFilled(['status', 'prioritas', 'search']))
                                Tidak ada pengaduan yang sesuai dengan filter yang Anda pilih.
                            @else
                                Belum ada pengaduan yang dapat Anda akses.
                            @endif
                        </p>
                        @if(request()->anyFilled(['status', 'prioritas', 'search']))
                        <div class="space-x-3">
                            <a href="{{ route('petugas.pengaduan.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm transition-colors duration-200">
                                <i class="fas fa-redo-alt mr-2"></i>
                                Reset Filter
                            </a>
                            <a href="{{ route('petugas.pengaduan.tugas-saya') }}" 
                               class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg text-sm transition-colors duration-200">
                                <i class="fas fa-user-check mr-2"></i>
                                Lihat Tugas Saya
                            </a>
                        </div>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Quick Actions -->
            <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-5 sm:px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-bolt text-yellow-500 mr-2"></i>
                        Quick Actions
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">Aksi cepat untuk petugas</p>
                </div>
                <div class="p-4 sm:p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                        <!-- Tugas Saya -->
                        <a href="{{ route('petugas.pengaduan.tugas-saya') }}" 
                           class="group p-4 sm:p-5 border border-gray-200 rounded-xl hover:border-green-300 hover:shadow-sm transition-all duration-200 text-center sm:text-left">
                            <div class="flex flex-col items-center sm:items-start gap-3">
                                <div class="p-3 rounded-lg bg-green-50 group-hover:bg-green-100 transition-colors duration-200">
                                    <i class="fas fa-user-check text-green-600 text-lg"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900 group-hover:text-green-600 transition-colors duration-200">
                                        Tugas Saya
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1 hidden sm:block">
                                        Lihat pengaduan yang ditugaskan
                                    </p>
                                </div>
                                <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-green-500 mt-1 sm:mt-0"></i>
                            </div>
                        </a>

                        <!-- Proses Massal -->
                        <button onclick="prosesMassal()"
                                class="group p-4 sm:p-5 border border-gray-200 rounded-xl hover:border-purple-300 hover:shadow-sm transition-all duration-200 text-center sm:text-left bg-white">
                            <div class="flex flex-col items-center sm:items-start gap-3">
                                <div class="p-3 rounded-lg bg-purple-50 group-hover:bg-purple-100 transition-colors duration-200">
                                    <i class="fas fa-cogs text-purple-600 text-lg"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900 group-hover:text-purple-600 transition-colors duration-200">
                                        Proses Massal
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1 hidden sm:block">
                                        Proses semua pengaduan diajukan
                                    </p>
                                </div>
                                <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-purple-500 mt-1 sm:mt-0"></i>
                            </div>
                        </button>

                        <!-- Laporan Harian -->
                        <a href="#" 
                           class="group p-4 sm:p-5 border border-gray-200 rounded-xl hover:border-blue-300 hover:shadow-sm transition-all duration-200 text-center sm:text-left">
                            <div class="flex flex-col items-center sm:items-start gap-3">
                                <div class="p-3 rounded-lg bg-blue-50 group-hover:bg-blue-100 transition-colors duration-200">
                                    <i class="fas fa-chart-line text-blue-600 text-lg"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900 group-hover:text-blue-600 transition-colors duration-200">
                                        Laporan Harian
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1 hidden sm:block">
                                        Statistik penanganan hari ini
                                    </p>
                                </div>
                                <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-blue-500 mt-1 sm:mt-0"></i>
                            </div>
                        </a>

                        <!-- Panduan -->
                        <a href="#" 
                           class="group p-4 sm:p-5 border border-gray-200 rounded-xl hover:border-orange-300 hover:shadow-sm transition-all duration-200 text-center sm:text-left">
                            <div class="flex flex-col items-center sm:items-start gap-3">
                                <div class="p-3 rounded-lg bg-orange-50 group-hover:bg-orange-100 transition-colors duration-200">
                                    <i class="fas fa-question-circle text-orange-600 text-lg"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900 group-hover:text-orange-600 transition-colors duration-200">
                                        Panduan
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1 hidden sm:block">
                                        Panduan penanganan pengaduan
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

    @push('scripts')
    <script>
        function prosesMassal() {
            if (confirm('Proses semua pengaduan yang berstatus "Diajukan"? Pastikan Anda telah mengecek semua data.')) {
                // Implement mass processing logic here
                alert('Proses massal akan diimplementasikan!');
            }
        }
    </script>
    @endpush

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
    </style>
    @endpush
</x-app-layout>