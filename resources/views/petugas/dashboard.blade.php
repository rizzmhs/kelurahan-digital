<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-tachometer-alt mr-2 text-blue-600"></i>Dashboard Petugas
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <i class="fas fa-tasks text-blue-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Pengaduan</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_pengaduan'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center">
                        <div class="p-2 bg-yellow-100 rounded-lg">
                            <i class="fas fa-clock text-yellow-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Diajukan</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['pengaduan_diajukan'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center">
                        <div class="p-2 bg-purple-100 rounded-lg">
                            <i class="fas fa-cog text-purple-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Diproses</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['pengaduan_diproses'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center">
                        <div class="p-2 bg-green-100 rounded-lg">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Selesai</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['pengaduan_selesai'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center">
                        <div class="p-2 bg-orange-100 rounded-lg">
                            <i class="fas fa-user-check text-orange-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Tugas Saya</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['tugas_saya'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Aksi Cepat</h3>
                    <div class="space-y-3">
                        <a href="{{ route('petugas.pengaduan.index') }}" 
                           class="w-full flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                            <div class="flex items-center">
                                <div class="p-2 bg-blue-100 rounded-lg mr-3">
                                    <i class="fas fa-tasks text-blue-600"></i>
                                </div>
                                <span class="text-gray-700">Kelola Semua Pengaduan</span>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400"></i>
                        </a>

                        <a href="{{ route('petugas.pengaduan.tugas-saya') }}" 
                           class="w-full flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                            <div class="flex items-center">
                                <div class="p-2 bg-orange-100 rounded-lg mr-3">
                                    <i class="fas fa-user-check text-orange-600"></i>
                                </div>
                                <span class="text-gray-700">Lihat Tugas Saya</span>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400"></i>
                        </a>

                        <a href="{{ route('petugas.surat.index') }}" 
                           class="w-full flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                            <div class="flex items-center">
                                <div class="p-2 bg-green-100 rounded-lg mr-3">
                                    <i class="fas fa-envelope text-green-600"></i>
                                </div>
                                <span class="text-gray-700">Kelola Surat</span>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400"></i>
                        </a>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Pengaduan Terbaru</h3>
                    <div class="space-y-3">
                        @forelse($pengaduanTerbaru as $pengaduan)
                            <div class="flex items-center justify-between p-3 border border-gray-100 rounded-lg">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $pengaduan->judul }}</p>
                                    <p class="text-xs text-gray-500">{{ $pengaduan->user->name }} • {{ $pengaduan->created_at->diffForHumans() }}</p>
                                </div>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $pengaduan->status == 'diajukan' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $pengaduan->status == 'diproses' ? 'bg-purple-100 text-purple-800' : '' }}
                                    {{ $pengaduan->status == 'selesai' ? 'bg-green-100 text-green-800' : '' }}">
                                    {{ ucfirst($pengaduan->status) }}
                                </span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 text-center py-4">Belum ada pengaduan terbaru.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>