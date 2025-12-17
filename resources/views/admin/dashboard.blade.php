@php
    // Helper function untuk badge class
    function getBadgeClass($status) {
        $badgeClasses = [
            'draft' => 'badge-draft',
            'diajukan' => 'badge-diajukan',
            'diproses' => 'badge-diproses',
            'siap_ambil' => 'badge-siap_ambil',
            'selesai' => 'badge-selesai',
            'ditolak' => 'badge-ditolak',
            'menunggu' => 'badge-menunggu',
            'admin' => 'badge-admin',
            'petugas' => 'badge-petugas',
            'warga' => 'badge-warga'
        ];
        return $badgeClasses[$status] ?? 'badge-draft';
    }
    
    // Helper function untuk status display
    function getStatusDisplay($status) {
        $statusDisplay = [
            'draft' => 'Draft',
            'diajukan' => 'Diajukan',
            'diproses' => 'Diproses',
            'siap_ambil' => 'Siap Ambil',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
            'menunggu' => 'Menunggu',
            'diterima' => 'Diterima',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak'
        ];
        return $statusDisplay[$status] ?? ucfirst($status);
    }
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    Dashboard Admin
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    <i class="far fa-calendar-alt mr-2"></i>
                    {{ now()->translatedFormat('l, d F Y') }}
                </p>
            </div>
            <div class="flex items-center space-x-2 text-sm text-gray-500">
                <span class="badge badge-admin">
                    <i class="fas fa-user-shield mr-1"></i>
                    {{ auth()->user()->name }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Warga -->
            <div class="stats-card">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="stats-icon stats-icon-blue">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Warga</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_warga'] ?? 0 }}</p>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <span class="text-xs text-gray-500 flex items-center">
                            <i class="fas fa-user-check text-green-500 mr-2"></i>
                            {{ $stats['warga_verified'] ?? 0 }} Terverifikasi
                        </span>
                    </div>
                </div>
            </div>

            <!-- Total Petugas -->
            <div class="stats-card">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="stats-icon stats-icon-green">
                            <i class="fas fa-user-shield text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Petugas</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_petugas'] ?? 0 }}</p>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <span class="text-xs text-gray-500 flex items-center">
                            <i class="fas fa-circle text-green-500 mr-2"></i>
                            {{ $stats['petugas_active'] ?? 0 }} Aktif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Total Pengaduan -->
            <div class="stats-card">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="stats-icon stats-icon-purple">
                            <i class="fas fa-exclamation-circle text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Pengaduan</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_pengaduan'] ?? 0 }}</p>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <span class="text-xs text-gray-500 flex items-center">
                            <i class="fas fa-clock text-yellow-500 mr-2"></i>
                            {{ $stats['pengaduan_pending'] ?? 0 }} Menunggu
                        </span>
                    </div>
                </div>
            </div>

            <!-- Total Surat -->
            <div class="stats-card">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="stats-icon stats-icon-orange">
                            <i class="fas fa-file-alt text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Surat</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_surat'] ?? 0 }}</p>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <span class="text-xs text-gray-500 flex items-center">
                            <i class="fas fa-spinner text-blue-500 mr-2"></i>
                            {{ $stats['surat_proses'] ?? 0 }} Diproses
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Pengaduan -->
            <div class="card">
                <div class="card-header">
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
                <div class="card-body">
                    <div class="space-y-4">
                        @forelse($recentPengaduan as $pengaduan)
                        <div class="group p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-150">
                            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
                                <div class="flex-1">
                                    <div class="flex items-start gap-3">
                                        <div class="flex-shrink-0 p-2 rounded-lg bg-gray-100 group-hover:bg-white">
                                            <i class="fas fa-bullhorn text-gray-500"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-sm font-medium text-gray-900 truncate">
                                                {{ Str::limit($pengaduan->judul, 60) }}
                                            </h4>
                                            <div class="mt-2 flex flex-wrap items-center gap-3 text-xs text-gray-500">
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
                                    <span class="badge {{ getBadgeClass($pengaduan->status) }}">
                                        {{ getStatusDisplay($pengaduan->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fas fa-inbox text-xl"></i>
                            </div>
                            <h4 class="text-sm font-medium text-gray-900 mb-1">Belum ada pengaduan</h4>
                            <p class="text-gray-500 text-sm">Tidak ada pengaduan terbaru untuk ditampilkan.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Surat -->
            <div class="card">
                <div class="card-header">
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
                <div class="card-body">
                    <div class="space-y-4">
                        @forelse($recentSurat as $surat)
                        <div class="group p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-150">
                            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
                                <div class="flex-1">
                                    <div class="flex items-start gap-3">
                                        <div class="flex-shrink-0 p-2 rounded-lg bg-gray-100 group-hover:bg-white">
                                            <i class="fas fa-envelope text-gray-500"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-sm font-medium text-gray-900">
                                                {{ $surat->jenisSurat->nama ?? 'Unknown Type' }}
                                            </h4>
                                            <div class="mt-2 flex flex-wrap items-center gap-3 text-xs text-gray-500">
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
                                    <span class="badge {{ getBadgeClass($surat->status) }}">
                                        {{ getStatusDisplay($surat->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fas fa-file-alt text-xl"></i>
                            </div>
                            <h4 class="text-sm font-medium text-gray-900 mb-1">Belum ada surat</h4>
                            <p class="text-gray-500 text-sm">Tidak ada surat terbaru untuk ditampilkan.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-bolt text-yellow-500 mr-2"></i>
                    Quick Actions
                </h3>
                <p class="text-sm text-gray-500 mt-1">Akses cepat ke fitur utama sistem</p>
            </div>
            <div class="card-body">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Kelola Pengaduan -->
                    <a href="{{ route('admin.pengaduan.index') }}" 
                       class="group p-5 border border-gray-200 rounded-xl hover:border-blue-300 hover:shadow-sm transition-all duration-200 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="stats-icon stats-icon-blue group-hover:bg-blue-100">
                                <i class="fas fa-exclamation-triangle text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 group-hover:text-blue-600">
                                    Kelola Pengaduan
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    Kelola semua pengaduan
                                </p>
                            </div>
                            <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-blue-500"></i>
                        </div>
                    </a>

                    <!-- Kelola Surat -->
                    <a href="{{ route('admin.surat.index') }}" 
                       class="group p-5 border border-gray-200 rounded-xl hover:border-green-300 hover:shadow-sm transition-all duration-200 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="stats-icon stats-icon-green group-hover:bg-green-100">
                                <i class="fas fa-file-contract text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 group-hover:text-green-600">
                                    Kelola Surat
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    Proses pengajuan surat
                                </p>
                            </div>
                            <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-green-500"></i>
                        </div>
                    </a>

                    <!-- Kelola User -->
                    <a href="{{ route('admin.users.index') }}" 
                       class="group p-5 border border-gray-200 rounded-xl hover:border-purple-300 hover:shadow-sm transition-all duration-200 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="stats-icon stats-icon-purple group-hover:bg-purple-100">
                                <i class="fas fa-users-cog text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 group-hover:text-purple-600">
                                    Kelola User
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    Manajemen user
                                </p>
                            </div>
                            <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-purple-500"></i>
                        </div>
                    </a>

                    <!-- Master Data -->
                    <a href="{{ route('admin.kategori_pengaduan.index') }}" 
                       class="group p-5 border border-gray-200 rounded-xl hover:border-orange-300 hover:shadow-sm transition-all duration-200 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="stats-icon stats-icon-orange group-hover:bg-orange-100">
                                <i class="fas fa-database text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 group-hover:text-orange-600">
                                    Master Data
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    Kelola data master
                                </p>
                            </div>
                            <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-orange-500"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- System Info -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- System Status -->
            <div class="card">
                <div class="card-header">
                    <h4 class="text-sm font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-server text-gray-500 mr-2"></i>
                        System Status
                    </h4>
                </div>
                <div class="card-body">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">App Version</span>
                            <span class="text-sm font-medium text-gray-900">v1.0.0</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Last Backup</span>
                            <span class="text-sm font-medium text-green-600">Today, 00:00</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Active Sessions</span>
                            <span class="text-sm font-medium text-blue-600">{{ $stats['active_sessions'] ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Today Stats -->
            <div class="lg:col-span-2 card">
                <div class="card-header">
                    <h4 class="text-sm font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-chart-line text-gray-500 mr-2"></i>
                        Statistik Hari Ini
                    </h4>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <div class="text-center p-4 bg-blue-50 rounded-lg">
                            <p class="text-xs text-gray-600 mb-1">Pengaduan Baru</p>
                            <p class="text-xl font-bold text-gray-900">{{ $stats['today_pengaduan'] ?? 0 }}</p>
                        </div>
                        <div class="text-center p-4 bg-green-50 rounded-lg">
                            <p class="text-xs text-gray-600 mb-1">Surat Baru</p>
                            <p class="text-xl font-bold text-gray-900">{{ $stats['today_surat'] ?? 0 }}</p>
                        </div>
                        <div class="text-center p-4 bg-purple-50 rounded-lg">
                            <p class="text-xs text-gray-600 mb-1">User Baru</p>
                            <p class="text-xl font-bold text-gray-900">{{ $stats['today_users'] ?? 0 }}</p>
                        </div>
                        <div class="text-center p-4 bg-orange-50 rounded-lg">
                            <p class="text-xs text-gray-600 mb-1">Selesai</p>
                            <p class="text-xl font-bold text-gray-900">{{ $stats['today_completed'] ?? 0 }}</p>
                        </div>
                    </div>
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