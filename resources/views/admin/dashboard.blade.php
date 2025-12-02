<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Warga -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total Warga</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_warga'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Petugas -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total Petugas</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_petugas'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Pengaduan -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total Pengaduan</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_pengaduan'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Surat -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total Surat</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_surat'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts & Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Recent Pengaduan -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Pengaduan Terbaru</h3>
                            <a href="{{ route('admin.pengaduan.index') }}" class="text-sm text-blue-600 hover:text-blue-900">Lihat Semua</a>
                        </div>
                        <div class="space-y-4">
                            @forelse($recentPengaduan as $pengaduan)
                            <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-1">
                                        <p class="text-sm font-medium text-gray-900">{{ Str::limit($pengaduan->judul, 40) }}</p>
                                        <span class="px-2 py-1 text-xs rounded-full {{ $pengaduan->getStatusBadgeClass() }}">
                                            {{ ucfirst($pengaduan->status) }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-500">Oleh: {{ $pengaduan->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $pengaduan->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            @empty
                            <p class="text-gray-500 text-sm text-center py-4">Belum ada pengaduan terbaru.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Recent Surat -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Surat Terbaru</h3>
                            <a href="{{ route('admin.surat.index') }}" class="text-sm text-blue-600 hover:text-blue-900">Lihat Semua</a>
                        </div>
                        <div class="space-y-4">
                            @forelse($recentSurat as $surat)
                            <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-1">
                                        <p class="text-sm font-medium text-gray-900">{{ $surat->jenisSurat->nama }}</p>
                                        @php
                                            $statusClasses = [
                                                'draft' => 'bg-gray-100 text-gray-800',
                                                'diajukan' => 'bg-yellow-100 text-yellow-800',
                                                'diproses' => 'bg-blue-100 text-blue-800',
                                                'siap_ambil' => 'bg-green-100 text-green-800',
                                                'selesai' => 'bg-green-100 text-green-800',
                                                'ditolak' => 'bg-red-100 text-red-800'
                                            ];
                                        @endphp
                                        <span class="px-2 py-1 text-xs rounded-full {{ $statusClasses[$surat->status] }}">
                                            {{ str_replace('_', ' ', ucfirst($surat->status)) }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-500">Oleh: {{ $surat->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $surat->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            @empty
                            <p class="text-gray-500 text-sm text-center py-4">Belum ada surat terbaru.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <a href="{{ route('admin.pengaduan.index') }}" class="p-4 border border-gray-200 rounded-lg hover:bg-blue-50 transition duration-150 text-center">
                            <div class="p-2 bg-blue-100 rounded-lg inline-flex mb-2">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-900">Kelola Pengaduan</p>
                        </a>

                        <a href="{{ route('admin.surat.index') }}" class="p-4 border border-gray-200 rounded-lg hover:bg-green-50 transition duration-150 text-center">
                            <div class="p-2 bg-green-100 rounded-lg inline-flex mb-2">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-900">Kelola Surat</p>
                        </a>

                        <a href="{{ route('admin.users.index') }}" class="p-4 border border-gray-200 rounded-lg hover:bg-purple-50 transition duration-150 text-center">
                            <div class="p-2 bg-purple-100 rounded-lg inline-flex mb-2">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-900">Kelola User</p>
                        </a>

                        <a href="{{ route('admin.kategori-pengaduan.index') }}" class="p-4 border border-gray-200 rounded-lg hover:bg-orange-50 transition duration-150 text-center">
                            <div class="p-2 bg-orange-100 rounded-lg inline-flex mb-2">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-900">Master Data</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>