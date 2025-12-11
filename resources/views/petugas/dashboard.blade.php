<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    <i class="fas fa-home mr-2 text-blue-600"></i>Dashboard
                </h2>
                <p class="text-sm text-gray-500 mt-1">Selamat datang, {{ auth()->user()->name }}!</p>
            </div>
            <div class="text-sm text-gray-500">
                {{ now()->translatedFormat('l, d F Y') }}
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Message -->
            @if(auth()->user()->isWarga())
                <div class="mb-8 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-lg text-white overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-2xl font-bold mb-2">Halo, {{ auth()->user()->name }}! 👋</h3>
                                <p class="text-blue-100 mb-4">
                                    Selamat datang di Sistem Layanan Kelurahan Digital. 
                                    Anda dapat mengajukan pengaduan atau surat dengan mudah melalui sistem ini.
                                </p>
                                <div class="flex space-x-3">
                                    <a href="{{ route('warga.pengaduan.create') }}" 
                                       class="px-4 py-2 bg-white text-blue-600 font-medium rounded-lg hover:bg-blue-50 transition duration-200">
                                        <i class="fas fa-plus mr-2"></i>Buat Pengaduan
                                    </a>
                                    <a href="{{ route('warga.surat.create') }}" 
                                       class="px-4 py-2 border-2 border-white text-white font-medium rounded-lg hover:bg-white hover:text-blue-600 transition duration-200">
                                        <i class="fas fa-envelope mr-2"></i>Ajukan Surat
                                    </a>
                                </div>
                            </div>
                            <div class="hidden md:block">
                                <i class="fas fa-user-circle text-6xl opacity-20"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                @if(auth()->user()->isWarga())
                    <!-- Stats for Warga -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 mb-1">Total Pengaduan</p>
                                    <p class="text-3xl font-bold text-gray-900">{{ $data['total_pengaduan'] ?? 0 }}</p>
                                </div>
                                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                    <i class="fas fa-exclamation-circle text-xl"></i>
                                </div>
                            </div>
                            <div class="mt-4 flex items-center text-sm text-gray-500">
                                <i class="fas fa-clock mr-2"></i>
                                <span>Menunggu: {{ $data['pengaduan_menunggu'] ?? 0 }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 mb-1">Pengaduan Diproses</p>
                                    <p class="text-3xl font-bold text-gray-900">{{ $data['pengaduan_diproses'] ?? 0 }}</p>
                                </div>
                                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                                    <i class="fas fa-cog text-xl"></i>
                                </div>
                            </div>
                            <div class="mt-4 flex items-center text-sm text-gray-500">
                                <i class="fas fa-user-check mr-2"></i>
                                <span>Ditangani petugas</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 mb-1">Total Surat</p>
                                    <p class="text-3xl font-bold text-gray-900">{{ $data['total_surat'] ?? 0 }}</p>
                                </div>
                                <div class="p-3 rounded-full bg-green-100 text-green-600">
                                    <i class="fas fa-envelope text-xl"></i>
                                </div>
                            </div>
                            <div class="mt-4 flex items-center text-sm text-gray-500">
                                <i class="fas fa-check-circle mr-2"></i>
                                <span>Selesai: {{ $data['surat_selesai'] ?? 0 }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 mb-1">Surat Diproses</p>
                                    <p class="text-3xl font-bold text-gray-900">{{ $data['surat_diproses'] ?? 0 }}</p>
                                </div>
                                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                                    <i class="fas fa-file-contract text-xl"></i>
                                </div>
                            </div>
                            <div class="mt-4 flex items-center text-sm text-gray-500">
                                <i class="fas fa-hourglass-half mr-2"></i>
                                <span>Dalam proses</span>
                            </div>
                        </div>
                    </div>

                @elseif(auth()->user()->isPetugas() || auth()->user()->isAdmin())
                    <!-- Stats for Petugas/Admin -->
                    @if(auth()->user()->isPetugas())
                        <!-- Petugas Specific Stats -->
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200">
                            <div class="p-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 mb-1">Total Tugas</p>
                                        <p class="text-3xl font-bold text-gray-900">{{ $data['total_tugas'] ?? 0 }}</p>
                                    </div>
                                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                        <i class="fas fa-tasks text-xl"></i>
                                    </div>
                                </div>
                                <div class="mt-4 flex items-center text-sm text-gray-500">
                                    <i class="fas fa-user-tie mr-2"></i>
                                    <span>Tugas Anda</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200">
                            <div class="p-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 mb-1">Sedang Diproses</p>
                                        <p class="text-3xl font-bold text-gray-900">{{ $data['tugas_diproses'] ?? 0 }}</p>
                                    </div>
                                    <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                                        <i class="fas fa-cogs text-xl"></i>
                                    </div>
                                </div>
                                <div class="mt-4 flex items-center text-sm text-gray-500">
                                    <i class="fas fa-spinner mr-2"></i>
                                    <span>Dalam pengerjaan</span>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Common Stats for Petugas & Admin -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 mb-1">Surat Diproses</p>
                                    <p class="text-3xl font-bold text-gray-900">{{ $data['surat_diproses'] ?? 0 }}</p>
                                </div>
                                <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                                    <i class="fas fa-file-signature text-xl"></i>
                                </div>
                            </div>
                            <div class="mt-4 flex items-center text-sm text-gray-500">
                                <i class="fas fa-edit mr-2"></i>
                                <span>Perlu diproses</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 mb-1">Total Pengaduan</p>
                                    <p class="text-3xl font-bold text-gray-900">{{ $data['total_pengaduan'] ?? 0 }}</p>
                                </div>
                                <div class="p-3 rounded-full bg-green-100 text-green-600">
                                    <i class="fas fa-exclamation-triangle text-xl"></i>
                                </div>
                            </div>
                            <div class="mt-4 flex items-center text-sm text-gray-500">
                                <i class="fas fa-list-ol mr-2"></i>
                                <span>Semua pengaduan</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column: Quick Actions & Recent -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Quick Actions -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-bolt text-yellow-500 mr-2"></i>Quick Actions
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if(auth()->user()->isWarga())
                                    <!-- Warga Quick Actions -->
                                    <a href="{{ route('warga.pengaduan.create') }}" 
                                       class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-200 transition duration-200 group">
                                        <div class="flex-shrink-0 p-3 bg-blue-100 rounded-lg mr-4 group-hover:bg-blue-200">
                                            <i class="fas fa-plus text-blue-600 text-lg"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-gray-900 group-hover:text-blue-600">Buat Pengaduan</h4>
                                            <p class="text-sm text-gray-500 mt-1">Laporkan masalah atau keluhan</p>
                                        </div>
                                    </a>

                                    <a href="{{ route('warga.surat.create') }}" 
                                       class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-green-50 hover:border-green-200 transition duration-200 group">
                                        <div class="flex-shrink-0 p-3 bg-green-100 rounded-lg mr-4 group-hover:bg-green-200">
                                            <i class="fas fa-envelope text-green-600 text-lg"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-gray-900 group-hover:text-green-600">Ajukan Surat</h4>
                                            <p class="text-sm text-gray-500 mt-1">Ajukan pembuatan surat resmi</p>
                                        </div>
                                    </a>

                                    <a href="{{ route('warga.pengaduan.index') }}" 
                                       class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-purple-50 hover:border-purple-200 transition duration-200 group">
                                        <div class="flex-shrink-0 p-3 bg-purple-100 rounded-lg mr-4 group-hover:bg-purple-200">
                                            <i class="fas fa-list text-purple-600 text-lg"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-gray-900 group-hover:text-purple-600">Lihat Pengaduan</h4>
                                            <p class="text-sm text-gray-500 mt-1">Cek status pengaduan Anda</p>
                                        </div>
                                    </a>

                                    <a href="{{ route('warga.surat.index') }}" 
                                       class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-orange-50 hover:border-orange-200 transition duration-200 group">
                                        <div class="flex-shrink-0 p-3 bg-orange-100 rounded-lg mr-4 group-hover:bg-orange-200">
                                            <i class="fas fa-file-alt text-orange-600 text-lg"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-gray-900 group-hover:text-orange-600">Lihat Surat</h4>
                                            <p class="text-sm text-gray-500 mt-1">Monitor pengajuan surat Anda</p>
                                        </div>
                                    </a>

                                @else
                                    <!-- Petugas/Admin Quick Actions -->
                                    @if(auth()->user()->isPetugas())
                                        <!-- Petugas Specific Actions -->
                                        <a href="{{ route('petugas.pengaduan.index') }}" 
                                           class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-200 transition duration-200 group">
                                            <div class="flex-shrink-0 p-3 bg-blue-100 rounded-lg mr-4 group-hover:bg-blue-200">
                                                <i class="fas fa-tasks text-blue-600 text-lg"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-medium text-gray-900 group-hover:text-blue-600">Kelola Pengaduan</h4>
                                                <p class="text-sm text-gray-500 mt-1">Lihat dan proses pengaduan</p>
                                            </div>
                                        </a>

                                        <a href="{{ route('petugas.pengaduan.tugas-saya') }}" 
                                           class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-purple-50 hover:border-purple-200 transition duration-200 group">
                                            <div class="flex-shrink-0 p-3 bg-purple-100 rounded-lg mr-4 group-hover:bg-purple-200">
                                                <i class="fas fa-user-tie text-purple-600 text-lg"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-medium text-gray-900 group-hover:text-purple-600">Tugas Saya</h4>
                                                <p class="text-sm text-gray-500 mt-1">Pengaduan yang ditugaskan</p>
                                            </div>
                                        </a>
                                    @elseif(auth()->user()->isAdmin())
                                        <!-- Admin Specific Actions -->
                                        <a href="{{ route('admin.pengaduan.index') }}" 
                                           class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-200 transition duration-200 group">
                                            <div class="flex-shrink-0 p-3 bg-blue-100 rounded-lg mr-4 group-hover:bg-blue-200">
                                                <i class="fas fa-exclamation-triangle text-blue-600 text-lg"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-medium text-gray-900 group-hover:text-blue-600">Kelola Pengaduan</h4>
                                                <p class="text-sm text-gray-500 mt-1">Manajemen semua pengaduan</p>
                                            </div>
                                        </a>

                                        <a href="{{ route('admin.users.index') }}" 
                                           class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-orange-50 hover:border-orange-200 transition duration-200 group">
                                            <div class="flex-shrink-0 p-3 bg-orange-100 rounded-lg mr-4 group-hover:bg-orange-200">
                                                <i class="fas fa-users-cog text-orange-600 text-lg"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-medium text-gray-900 group-hover:text-orange-600">Kelola User</h4>
                                                <p class="text-sm text-gray-500 mt-1">Manajemen user dan role</p>
                                            </div>
                                        </a>
                                    @endif

                                    <!-- Common Actions for Petugas & Admin -->
                                    <a href="{{ route('petugas.surat.index') }}" 
                                       class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-green-50 hover:border-green-200 transition duration-200 group">
                                        <div class="flex-shrink-0 p-3 bg-green-100 rounded-lg mr-4 group-hover:bg-green-200">
                                            <i class="fas fa-file-contract text-green-600 text-lg"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-gray-900 group-hover:text-green-600">Kelola Surat</h4>
                                            <p class="text-sm text-gray-500 mt-1">Proses pengajuan surat</p>
                                        </div>
                                    </a>

                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('admin.dashboard') }}" 
                                           class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-indigo-50 hover:border-indigo-200 transition duration-200 group">
                                            <div class="flex-shrink-0 p-3 bg-indigo-100 rounded-lg mr-4 group-hover:bg-indigo-200">
                                                <i class="fas fa-tachometer-alt text-indigo-600 text-lg"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-medium text-gray-900 group-hover:text-indigo-600">Admin Dashboard</h4>
                                                <p class="text-sm text-gray-500 mt-1">Dashboard admin lengkap</p>
                                            </div>
                                        </a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <i class="fas fa-history text-gray-500 mr-2"></i>
                                    @if(auth()->user()->isWarga())
                                        Aktivitas Terbaru
                                    @else
                                        Pengaduan Terbaru
                                    @endif
                                </h3>
                                @if(auth()->user()->isWarga())
                                    <a href="{{ route('warga.pengaduan.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                                        Lihat Semua →
                                    </a>
                                @elseif(auth()->user()->isPetugas())
                                    <a href="{{ route('petugas.pengaduan.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                                        Lihat Semua →
                                    </a>
                                @elseif(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.pengaduan.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                                        Lihat Semua →
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="p-6">
                            @if(isset($data['recent_activity']) && count($data['recent_activity']) > 0)
                                <div class="space-y-4">
                                    @foreach($data['recent_activity'] as $activity)
                                        <div class="flex items-start border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                                            <div class="flex-shrink-0 mr-4">
                                                <div class="p-2 rounded-full {{ $activity['color_class'] ?? 'bg-gray-100' }}">
                                                    <i class="fas {{ $activity['icon'] ?? 'fa-info-circle' }} text-sm {{ $activity['icon_color'] ?? 'text-gray-500' }}"></i>
                                                </div>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm text-gray-900">{{ $activity['message'] }}</p>
                                                <p class="text-xs text-gray-500 mt-1">
                                                    <i class="far fa-clock mr-1"></i>{{ $activity['time'] }}
                                                </p>
                                                @if(isset($activity['user_name']))
                                                    <p class="text-xs text-gray-500">
                                                        <i class="fas fa-user mr-1"></i>{{ $activity['user_name'] }}
                                                    </p>
                                                @endif
                                            </div>
                                            @if(isset($activity['status_badge']))
                                                <span class="ml-2 px-2 py-1 text-xs font-medium rounded-full {{ $activity['badge_color'] }}">
                                                    {{ $activity['status_badge'] }}
                                                </span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <i class="fas fa-inbox text-gray-300 text-4xl mb-3"></i>
                                    <p class="text-gray-500">
                                        @if(auth()->user()->isWarga())
                                            Belum ada aktivitas terbaru
                                        @else
                                            Belum ada pengaduan terbaru
                                        @endif
                                    </p>
                                    @if(auth()->user()->isWarga())
                                        <p class="text-sm text-gray-400 mt-1">Mulai dengan membuat pengaduan atau mengajukan surat</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Column: Status & Links -->
                <div class="space-y-6">
                    <!-- Status Summary -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-chart-pie text-blue-500 mr-2"></i>Status Summary
                            </h3>
                        </div>
                        <div class="p-6">
                            @if(auth()->user()->isWarga())
                                <!-- Warga Status -->
                                <div class="space-y-4">
                                    <div>
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-sm font-medium text-gray-700">Pengaduan</span>
                                            <span class="text-sm font-semibold text-gray-900">{{ $data['total_pengaduan'] ?? 0 }}</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            @php
                                                $total_peng = $data['total_pengaduan'] ?? 0;
                                                $selesai_peng = $data['pengaduan_selesai'] ?? 0;
                                                $percentage = $total_peng > 0 ? ($selesai_peng / $total_peng) * 100 : 0;
                                            @endphp
                                            <div class="bg-green-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <div class="flex justify-between text-xs text-gray-500 mt-1">
                                            <span>{{ $selesai_peng }} selesai</span>
                                            <span>{{ $total_peng - $selesai_peng }} dalam proses</span>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-sm font-medium text-gray-700">Surat</span>
                                            <span class="text-sm font-semibold text-gray-900">{{ $data['total_surat'] ?? 0 }}</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            @php
                                                $total_srt = $data['total_surat'] ?? 0;
                                                $selesai_srt = $data['surat_selesai'] ?? 0;
                                                $percentage_srt = $total_srt > 0 ? ($selesai_srt / $total_srt) * 100 : 0;
                                            @endphp
                                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $percentage_srt }}%"></div>
                                        </div>
                                        <div class="flex justify-between text-xs text-gray-500 mt-1">
                                            <span>{{ $selesai_srt }} selesai</span>
                                            <span>{{ $total_srt - $selesai_srt }} dalam proses</span>
                                        </div>
                                    </div>
                                </div>
                            @elseif(auth()->user()->isPetugas())
                                <!-- Petugas Status -->
                                <div class="space-y-4">
                                    <div>
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-sm font-medium text-gray-700">Tugas Anda</span>
                                            <span class="text-sm font-semibold text-gray-900">{{ $data['total_tugas'] ?? 0 }}</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            @php
                                                $total_tugas = $data['total_tugas'] ?? 0;
                                                $selesai_tugas = $data['tugas_selesai'] ?? 0;
                                                $percentage_tugas = $total_tugas > 0 ? ($selesai_tugas / $total_tugas) * 100 : 0;
                                            @endphp
                                            <div class="bg-green-600 h-2 rounded-full" style="width: {{ $percentage_tugas }}%"></div>
                                        </div>
                                        <div class="flex justify-between text-xs text-gray-500 mt-1">
                                            <span>{{ $selesai_tugas }} selesai</span>
                                            <span>{{ $total_tugas - $selesai_tugas }} dalam proses</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-link text-green-500 mr-2"></i>Quick Links
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                <a href="{{ route('profile.edit') }}" class="flex items-center text-gray-700 hover:text-blue-600 transition duration-200">
                                    <i class="fas fa-user-circle text-gray-400 mr-3"></i>
                                    <span>Profil Saya</span>
                                </a>
                                
                                @if(auth()->user()->isWarga())
                                    <!-- Warga Links -->
                                    <a href="{{ route('tracking.surat', ['nomor' => 'TRACK123']) }}" class="flex items-center text-gray-700 hover:text-blue-600 transition duration-200">
                                        <i class="fas fa-search text-gray-400 mr-3"></i>
                                        <span>Track Surat</span>
                                    </a>
                                    <a href="{{ route('tracking.pengaduan', ['kode' => 'PGD123']) }}" class="flex items-center text-gray-700 hover:text-blue-600 transition duration-200">
                                        <i class="fas fa-search-location text-gray-400 mr-3"></i>
                                        <span>Track Pengaduan</span>
                                    </a>
                                    <a href="{{ route('warga.pengaduan.track') }}" class="flex items-center text-gray-700 hover:text-blue-600 transition duration-200">
                                        <i class="fas fa-map-marker-alt text-gray-400 mr-3"></i>
                                        <span>Lokasi Pengaduan</span>
                                    </a>
                                @elseif(auth()->user()->isPetugas())
                                    <!-- Petugas Links -->
                                    <a href="{{ route('petugas.dashboard') }}" class="flex items-center text-gray-700 hover:text-blue-600 transition duration-200">
                                        <i class="fas fa-tachometer-alt text-gray-400 mr-3"></i>
                                        <span>Dashboard Petugas</span>
                                    </a>
                                    <a href="{{ route('petugas.surat.index') }}" class="flex items-center text-gray-700 hover:text-blue-600 transition duration-200">
                                        <i class="fas fa-file-alt text-gray-400 mr-3"></i>
                                        <span>Kelola Surat</span>
                                    </a>
                                @elseif(auth()->user()->isAdmin())
                                    <!-- Admin Links -->
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center text-gray-700 hover:text-blue-600 transition duration-200">
                                        <i class="fas fa-tachometer-alt text-gray-400 mr-3"></i>
                                        <span>Admin Dashboard</span>
                                    </a>
                                    <a href="{{ route('admin.statistik') }}" class="flex items-center text-gray-700 hover:text-blue-600 transition duration-200">
                                        <i class="fas fa-chart-bar text-gray-400 mr-3"></i>
                                        <span>Statistik</span>
                                    </a>
                                    <a href="{{ route('admin.laporan') }}" class="flex items-center text-gray-700 hover:text-blue-600 transition duration-200">
                                        <i class="fas fa-file-pdf text-gray-400 mr-3"></i>
                                        <span>Laporan</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- System Info -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-info-circle text-purple-500 mr-2"></i>System Info
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Role:</span>
                                    <span class="font-medium {{ 
                                        auth()->user()->isWarga() ? 'text-blue-600' : 
                                        (auth()->user()->isPetugas() ? 'text-green-600' : 'text-purple-600') 
                                    }}">
                                        {{ auth()->user()->role_display ?? ucfirst(auth()->user()->role) }}
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Status:</span>
                                    <span class="font-medium {{ 
                                        auth()->user()->status == 'active' ? 'text-green-600' : 'text-red-600' 
                                    }}">
                                        {{ auth()->user()->status_display ?? ucfirst(auth()->user()->status) }}
                                    </span>
                                </div>
                                @if(auth()->user()->isWarga())
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Verifikasi:</span>
                                        <span class="font-medium {{ 
                                            auth()->user()->is_verified ? 'text-green-600' : 'text-yellow-600' 
                                        }}">
                                            {{ auth()->user()->is_verified ? 'Terverifikasi' : 'Belum Diverifikasi' }}
                                        </span>
                                    </div>
                                @endif
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Bergabung:</span>
                                    <span class="font-medium text-gray-900">
                                        {{ auth()->user()->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .hover-shadow-lg {
            transition: all 0.3s ease;
        }
        .hover-shadow-lg:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .progress-bar {
            transition: width 0.6s ease;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        // Animate progress bars on load
        document.addEventListener('DOMContentLoaded', function() {
            const progressBars = document.querySelectorAll('.h-2.rounded-full > div');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0';
                setTimeout(() => {
                    bar.style.width = width;
                }, 300);
            });
        });
    </script>
    @endpush
</x-app-layout>