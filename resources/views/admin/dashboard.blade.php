<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    Dashboard Admin
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    {{ now()->translatedFormat('l, d F Y') }}
                </p>
            </div>
            <div class="flex items-center space-x-2 text-sm text-gray-500">
                <i class="fas fa-user-shield text-blue-500"></i>
                <span>Welcome back, {{ auth()->user()->name }}!</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
                <!-- Total Warga -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="p-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 rounded-xl bg-blue-50 text-blue-600">
                                <i class="fas fa-users text-lg sm:text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-xs sm:text-sm font-medium text-gray-500">Total Warga</p>
                                <p class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $stats['total_warga'] ?? 0 }}</p>
                            </div>
                        </div>
                        <div class="mt-3 pt-3 border-t border-gray-100">
                            <span class="text-xs text-gray-500">
                                <i class="fas fa-user-check mr-1"></i>
                                {{ $stats['warga_verified'] ?? 0 }} Terverifikasi
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Total Petugas -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="p-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 rounded-xl bg-green-50 text-green-600">
                                <i class="fas fa-user-tie text-lg sm:text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-xs sm:text-sm font-medium text-gray-500">Total Petugas</p>
                                <p class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $stats['total_petugas'] ?? 0 }}</p>
                            </div>
                        </div>
                        <div class="mt-3 pt-3 border-t border-gray-100">
                            <span class="text-xs text-gray-500">
                                <i class="fas fa-circle text-green-500 mr-1"></i>
                                {{ $stats['petugas_active'] ?? 0 }} Aktif
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Total Pengaduan -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="p-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 rounded-xl bg-purple-50 text-purple-600">
                                <i class="fas fa-exclamation-circle text-lg sm:text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-xs sm:text-sm font-medium text-gray-500">Total Pengaduan</p>
                                <p class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $stats['total_pengaduan'] ?? 0 }}</p>
                            </div>
                        </div>
                        <div class="mt-3 pt-3 border-t border-gray-100">
                            <span class="text-xs text-gray-500">
                                <i class="fas fa-clock mr-1"></i>
                                {{ $stats['pengaduan_pending'] ?? 0 }} Menunggu
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Total Surat -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="p-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 rounded-xl bg-orange-50 text-orange-600">
                                <i class="fas fa-file-alt text-lg sm:text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-xs sm:text-sm font-medium text-gray-500">Total Surat</p>
                                <p class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $stats['total_surat'] ?? 0 }}</p>
                            </div>
                        </div>
                        <div class="mt-3 pt-3 border-t border-gray-100">
                            <span class="text-xs text-gray-500">
                                <i class="fas fa-spinner mr-1"></i>
                                {{ $stats['surat_proses'] ?? 0 }} Diproses
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts & Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Recent Pengaduan -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-5 sm:px-6 py-4 border-b border-gray-100">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-exclamation-triangle text-orange-500 mr-2"></i>
                                Pengaduan Terbaru
                            </h3>
                            <a href="{{ route('admin.pengaduan.index') }}" 
                               class="text-sm text-blue-600 hover:text-blue-800 font-medium inline-flex items-center">
                                Lihat Semua
                                <i class="fas fa-chevron-right ml-1 text-xs"></i>
                            </a>
                        </div>
                    </div>
                    <div class="p-4 sm:p-6">
                        <div class="space-y-3">
                            @forelse($recentPengaduan as $pengaduan)
                            <div class="group p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-150">
                                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2">
                                    <div class="flex-1">
                                        <div class="flex items-start gap-3 mb-2">
                                            <div class="flex-shrink-0 p-2 rounded-lg bg-gray-100 group-hover:bg-white">
                                                <i class="fas fa-bullhorn text-gray-500 text-sm"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h4 class="text-sm font-medium text-gray-900 truncate">
                                                    {{ Str::limit($pengaduan->judul, 50) }}
                                                </h4>
                                                <div class="mt-1 flex flex-wrap items-center gap-2 text-xs text-gray-500">
                                                    <span class="flex items-center">
                                                        <i class="fas fa-user mr-1"></i>
                                                        {{ $pengaduan->user->name ?? 'Unknown' }}
                                                    </span>
                                                    <span class="hidden sm:inline">•</span>
                                                    <span class="flex items-center">
                                                        <i class="far fa-clock mr-1"></i>
                                                        {{ $pengaduan->created_at->diffForHumans() }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sm:flex-shrink-0">
                                        <span class="px-3 py-1 text-xs font-medium rounded-full {{ $pengaduan->getStatusBadgeClass() }}">
                                            {{ ucfirst($pengaduan->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-8">
                                <div class="mx-auto w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mb-3">
                                    <i class="fas fa-inbox text-gray-400"></i>
                                </div>
                                <p class="text-gray-500 text-sm">Belum ada pengaduan terbaru.</p>
                                <p class="text-gray-400 text-xs mt-1">Semua pengaduan telah diproses</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Recent Surat -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-5 sm:px-6 py-4 border-b border-gray-100">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-file-contract text-blue-500 mr-2"></i>
                                Surat Terbaru
                            </h3>
                            <a href="{{ route('admin.surat.index') }}" 
                               class="text-sm text-blue-600 hover:text-blue-800 font-medium inline-flex items-center">
                                Lihat Semua
                                <i class="fas fa-chevron-right ml-1 text-xs"></i>
                            </a>
                        </div>
                    </div>
                    <div class="p-4 sm:p-6">
                        <div class="space-y-3">
                            @forelse($recentSurat as $surat)
                            <div class="group p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-150">
                                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2">
                                    <div class="flex-1">
                                        <div class="flex items-start gap-3 mb-2">
                                            <div class="flex-shrink-0 p-2 rounded-lg bg-gray-100 group-hover:bg-white">
                                                <i class="fas fa-envelope text-gray-500 text-sm"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h4 class="text-sm font-medium text-gray-900">
                                                    {{ $surat->jenisSurat->nama ?? 'Unknown Type' }}
                                                </h4>
                                                <div class="mt-1 flex flex-wrap items-center gap-2 text-xs text-gray-500">
                                                    <span class="flex items-center">
                                                        <i class="fas fa-user mr-1"></i>
                                                        {{ $surat->user->name ?? 'Unknown' }}
                                                    </span>
                                                    <span class="hidden sm:inline">•</span>
                                                    <span class="flex items-center">
                                                        <i class="far fa-clock mr-1"></i>
                                                        {{ $surat->created_at->diffForHumans() }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sm:flex-shrink-0">
                                        @php
                                            $statusClasses = [
                                                'draft' => 'bg-gray-100 text-gray-800',
                                                'diajukan' => 'bg-yellow-100 text-yellow-800',
                                                'diproses' => 'bg-blue-100 text-blue-800',
                                                'siap_ambil' => 'bg-green-100 text-green-800',
                                                'selesai' => 'bg-green-100 text-green-800',
                                                'ditolak' => 'bg-red-100 text-red-800'
                                            ];
                                            $statusDisplay = [
                                                'draft' => 'Draft',
                                                'diajukan' => 'Diajukan',
                                                'diproses' => 'Diproses',
                                                'siap_ambil' => 'Siap Ambil',
                                                'selesai' => 'Selesai',
                                                'ditolak' => 'Ditolak'
                                            ];
                                        @endphp
                                        <span class="px-3 py-1 text-xs font-medium rounded-full {{ $statusClasses[$surat->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ $statusDisplay[$surat->status] ?? ucfirst($surat->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-8">
                                <div class="mx-auto w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mb-3">
                                    <i class="fas fa-file-alt text-gray-400"></i>
                                </div>
                                <p class="text-gray-500 text-sm">Belum ada surat terbaru.</p>
                                <p class="text-gray-400 text-xs mt-1">Semua pengajuan surat telah diproses</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-5 sm:px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-bolt text-yellow-500 mr-2"></i>
                        Quick Actions
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">Akses cepat ke fitur utama sistem</p>
                </div>
                <div class="p-4 sm:p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                        <!-- Kelola Pengaduan -->
                        <a href="{{ route('admin.pengaduan.index') }}" 
                           class="group p-4 sm:p-5 border border-gray-200 rounded-xl hover:border-blue-300 hover:shadow-sm transition-all duration-200 text-center sm:text-left">
                            <div class="flex flex-col items-center sm:items-start gap-3">
                                <div class="p-3 rounded-lg bg-blue-50 group-hover:bg-blue-100 transition-colors duration-200">
                                    <i class="fas fa-exclamation-triangle text-blue-600 text-lg"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900 group-hover:text-blue-600 transition-colors duration-200">
                                        Kelola Pengaduan
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1 hidden sm:block">
                                        Kelola semua pengaduan dari warga
                                    </p>
                                </div>
                                <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-blue-500 mt-1 sm:mt-0"></i>
                            </div>
                        </a>

                        <!-- Kelola Surat -->
                        <a href="{{ route('admin.surat.index') }}" 
                           class="group p-4 sm:p-5 border border-gray-200 rounded-xl hover:border-green-300 hover:shadow-sm transition-all duration-200 text-center sm:text-left">
                            <div class="flex flex-col items-center sm:items-start gap-3">
                                <div class="p-3 rounded-lg bg-green-50 group-hover:bg-green-100 transition-colors duration-200">
                                    <i class="fas fa-file-contract text-green-600 text-lg"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900 group-hover:text-green-600 transition-colors duration-200">
                                        Kelola Surat
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1 hidden sm:block">
                                        Proses pengajuan surat warga
                                    </p>
                                </div>
                                <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-green-500 mt-1 sm:mt-0"></i>
                            </div>
                        </a>

                        <!-- Kelola User -->
                        <a href="{{ route('admin.users.index') }}" 
                           class="group p-4 sm:p-5 border border-gray-200 rounded-xl hover:border-purple-300 hover:shadow-sm transition-all duration-200 text-center sm:text-left">
                            <div class="flex flex-col items-center sm:items-start gap-3">
                                <div class="p-3 rounded-lg bg-purple-50 group-hover:bg-purple-100 transition-colors duration-200">
                                    <i class="fas fa-users-cog text-purple-600 text-lg"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900 group-hover:text-purple-600 transition-colors duration-200">
                                        Kelola User
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1 hidden sm:block">
                                        Manajemen user dan role
                                    </p>
                                </div>
                                <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-purple-500 mt-1 sm:mt-0"></i>
                            </div>
                        </a>

                        <!-- Master Data -->
                        <a href="{{ route('admin.kategori_pengaduan.index') }}" 
                           class="group p-4 sm:p-5 border border-gray-200 rounded-xl hover:border-orange-300 hover:shadow-sm transition-all duration-200 text-center sm:text-left">
                            <div class="flex flex-col items-center sm:items-start gap-3">
                                <div class="p-3 rounded-lg bg-orange-50 group-hover:bg-orange-100 transition-colors duration-200">
                                    <i class="fas fa-database text-orange-600 text-lg"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900 group-hover:text-orange-600 transition-colors duration-200">
                                        Master Data
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1 hidden sm:block">
                                        Kelola kategori dan data master
                                    </p>
                                </div>
                                <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-orange-500 mt-1 sm:mt-0"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Additional Info -->
            <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- System Status -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <h4 class="text-sm font-semibold text-gray-900 mb-3 flex items-center">
                        <i class="fas fa-server text-gray-500 mr-2"></i>
                        System Status
                    </h4>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">App Version</span>
                            <span class="font-medium text-gray-900">v1.0.0</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">Last Backup</span>
                            <span class="font-medium text-green-600">Today, 00:00</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">Active Sessions</span>
                            <span class="font-medium text-blue-600">{{ $stats['active_sessions'] ?? 0 }}</span>
                        </div>
                    </div>
                </div>

                <!-- Statistik Hari Ini (Pengganti Recent Activities) -->
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <h4 class="text-sm font-semibold text-gray-900 mb-3 flex items-center">
                        <i class="fas fa-chart-line text-gray-500 mr-2"></i>
                        Statistik Hari Ini
                    </h4>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <div class="text-center p-3 bg-blue-50 rounded-lg">
                            <p class="text-xs text-gray-600">Pengaduan Baru</p>
                            <p class="text-xl font-bold text-gray-900">{{ $stats['today_pengaduan'] ?? 0 }}</p>
                        </div>
                        <div class="text-center p-3 bg-green-50 rounded-lg">
                            <p class="text-xs text-gray-600">Surat Baru</p>
                            <p class="text-xl font-bold text-gray-900">{{ $stats['today_surat'] ?? 0 }}</p>
                        </div>
                        <div class="text-center p-3 bg-purple-50 rounded-lg">
                            <p class="text-xs text-gray-600">User Baru</p>
                            <p class="text-xl font-bold text-gray-900">{{ $stats['today_users'] ?? 0 }}</p>
                        </div>
                        <div class="text-center p-3 bg-orange-50 rounded-lg">
                            <p class="text-xs text-gray-600">Selesai</p>
                            <p class="text-xl font-bold text-gray-900">{{ $stats['today_completed'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>