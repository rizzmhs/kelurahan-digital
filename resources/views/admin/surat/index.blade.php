<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-gray-900">
                    Kelola Pengajuan Surat
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    Manajemen semua pengajuan surat warga
                </p>
            </div>
            <div class="flex items-center space-x-2 text-sm text-gray-500">
                <i class="fas fa-file-alt text-blue-500"></i>
                <span>Total: <span class="font-semibold text-gray-900">{{ $surats->total() }}</span> pengajuan</span>
            </div>
        </div>
    </x-slot>

    <div class="py-4 md:py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 md:gap-4 mb-6">
                <!-- Total -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="p-4">
                        <div class="text-center">
                            <div class="text-xl md:text-2xl font-bold text-blue-600">{{ $surats->total() }}</div>
                            <div class="text-xs md:text-sm text-gray-600 mt-1">Total</div>
                        </div>
                    </div>
                </div>

                <!-- Diajukan -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="p-4">
                        <div class="text-center">
                            <div class="text-xl md:text-2xl font-bold text-yellow-600">{{ $surats->where('status', 'diajukan')->count() }}</div>
                            <div class="text-xs md:text-sm text-gray-600 mt-1">Diajukan</div>
                        </div>
                    </div>
                </div>

                <!-- Diproses -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="p-4">
                        <div class="text-center">
                            <div class="text-xl md:text-2xl font-bold text-blue-600">{{ $surats->where('status', 'diproses')->count() }}</div>
                            <div class="text-xs md:text-sm text-gray-600 mt-1">Diproses</div>
                        </div>
                    </div>
                </div>

                <!-- Siap Diambil -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="p-4">
                        <div class="text-center">
                            <div class="text-xl md:text-2xl font-bold text-green-600">{{ $surats->where('status', 'siap_ambil')->count() }}</div>
                            <div class="text-xs md:text-sm text-gray-600 mt-1">Siap Diambil</div>
                        </div>
                    </div>
                </div>

                <!-- Selesai -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="p-4">
                        <div class="text-center">
                            <div class="text-xl md:text-2xl font-bold text-green-600">{{ $surats->where('status', 'selesai')->count() }}</div>
                            <div class="text-xs md:text-sm text-gray-600 mt-1">Selesai</div>
                        </div>
                    </div>
                </div>

                <!-- Ditolak -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="p-4">
                        <div class="text-center">
                            <div class="text-xl md:text-2xl font-bold text-red-600">{{ $surats->where('status', 'ditolak')->count() }}</div>
                            <div class="text-xs md:text-sm text-gray-600 mt-1">Ditolak</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
                <!-- Filter Panel -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 sticky top-6">
                        <div class="px-5 py-4 border-b border-gray-100">
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
                                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors">
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
                                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors">
                                        <option value="">Semua Jenis</option>
                                        @foreach($jenisSurat as $jenis)
                                            <option value="{{ $jenis->id }}" {{ request('jenis_surat') == $jenis->id ? 'selected' : '' }}>
                                                {{ $jenis->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Date Range -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                                        <i class="fas fa-calendar text-gray-500 text-sm"></i>
                                        Tanggal Dari
                                    </label>
                                    <input type="date" 
                                           id="tanggal_dari" 
                                           name="tanggal_dari" 
                                           value="{{ request('tanggal_dari') }}"
                                           class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors">
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
                                        <i class="fas fa-plus"></i>
                                        Buat Surat Cepat
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
                        <div class="px-5 py-4 border-b border-gray-100">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                        <i class="fas fa-list-alt text-gray-500"></i>
                                        Daftar Pengajuan Surat
                                    </h3>
                                    @if(request()->anyFilled(['status', 'jenis_surat', 'tanggal_dari']))
                                    <p class="text-sm text-gray-500 mt-1">
                                        Filter aktif: 
                                        @if(request('status')) <span class="font-medium text-blue-600">{{ request('status') }}</span> @endif
                                        @if(request('jenis_surat')) <span class="font-medium text-purple-600">{{ $jenisSurat->where('id', request('jenis_surat'))->first()->nama ?? '' }}</span> @endif
                                        @if(request('tanggal_dari')) <span class="font-medium text-orange-600">{{ request('tanggal_dari') }}</span> @endif
                                    </p>
                                    @endif
                                </div>
                                
                                <div class="flex items-center space-x-3">
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
                                                Nomor Surat
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Jenis Surat
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Pemohon
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
                                        @foreach($surats as $surat)
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <!-- Nomor Surat -->
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-semibold text-gray-900">
                                                    {{ $surat->nomor_surat ?? 'Belum ada nomor' }}
                                                </div>
                                                <div class="text-xs text-gray-500 mt-0.5">
                                                    ID: {{ $surat->id }}
                                                </div>
                                            </td>
                                            
                                            <!-- Jenis Surat -->
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $surat->jenisSurat->nama }}</div>
                                                <div class="text-xs text-gray-500 mt-0.5 truncate max-w-xs">
                                                    {{ $surat->jenisSurat->deskripsi }}
                                                </div>
                                            </td>
                                            
                                            <!-- Pemohon -->
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $surat->user->name }}</div>
                                                <div class="text-xs text-gray-500 mt-0.5">{{ $surat->user->nik }}</div>
                                            </td>
                                            
                                            <!-- Status -->
                                            <td class="px-6 py-4">
                                                @php
                                                    $statusClasses = [
                                                        'draft' => 'bg-gray-100 text-gray-800',
                                                        'diajukan' => 'bg-yellow-100 text-yellow-800',
                                                        'diproses' => 'bg-blue-100 text-blue-800',
                                                        'siap_ambil' => 'bg-green-100 text-green-800',
                                                        'selesai' => 'bg-green-100 text-green-800',
                                                        'ditolak' => 'bg-red-100 text-red-800'
                                                    ];
                                                    $statusIcons = [
                                                        'draft' => 'fa-file',
                                                        'diajukan' => 'fa-clock',
                                                        'diproses' => 'fa-cog',
                                                        'siap_ambil' => 'fa-check-circle',
                                                        'selesai' => 'fa-check',
                                                        'ditolak' => 'fa-times'
                                                    ];
                                                @endphp
                                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium {{ $statusClasses[$surat->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                    <i class="fas {{ $statusIcons[$surat->status] ?? 'fa-file' }} mr-1.5 text-xs"></i>
                                                    {{ str_replace('_', ' ', ucfirst($surat->status)) }}
                                                </span>
                                            </td>
                                            
                                            <!-- Tanggal -->
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 font-medium">{{ $surat->created_at->format('d M Y') }}</div>
                                                <div class="text-xs text-gray-500">{{ $surat->created_at->format('H:i') }}</div>
                                            </td>
                                            
                                            <!-- Actions -->
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center space-x-1.5">
                                                    <!-- View -->
                                                    <a href="{{ route('admin.surat.show', $surat) }}" 
                                                       class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200"
                                                       title="Lihat Detail">
                                                        <i class="fas fa-eye text-sm"></i>
                                                    </a>
                                                    
                                                    <!-- Quick Actions -->
                                                    @if($surat->status === 'diajukan')
                                                    <form action="{{ route('admin.surat.verifikasi', $surat) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" 
                                                                class="p-2 text-gray-500 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors duration-200"
                                                                title="Verifikasi"
                                                                onclick="return confirm('Verifikasi pengajuan surat ini?')">
                                                            <i class="fas fa-check-circle text-sm"></i>
                                                        </button>
                                                    </form>
                                                    @endif
                                                    
                                                    <!-- More Actions Dropdown -->
                                                    <div class="relative group">
                                                        <button class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                                                            <i class="fas fa-ellipsis-h text-sm"></i>
                                                        </button>
                                                        
                                                        <div class="absolute right-0 mt-1 w-40 bg-white rounded-lg shadow-lg border border-gray-200 z-10 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                                            <div class="py-1">
                                                                <form action="{{ route('admin.surat.destroy', $surat) }}" method="POST" 
                                                                      onsubmit="return confirm('Hapus pengajuan surat ini?')"
                                                                      class="border-t border-gray-100">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" 
                                                                            class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center">
                                                                        <i class="fas fa-trash mr-2 text-xs"></i>
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
                                                <div class="flex items-center gap-3">
                                                    <div class="flex-shrink-0">
                                                        <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                                                            <i class="fas fa-envelope text-blue-600"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <h4 class="text-sm font-semibold text-gray-900 truncate">
                                                            {{ $surat->jenisSurat->nama }}
                                                        </h4>
                                                        <p class="text-xs text-gray-500 mt-0.5 truncate">
                                                            Nomor: {{ $surat->nomor_surat ?? 'Belum ada nomor' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex items-center space-x-1">
                                                <a href="{{ route('admin.surat.show', $surat) }}" 
                                                   class="p-1.5 text-gray-500 hover:text-blue-600">
                                                    <i class="fas fa-eye text-sm"></i>
                                                </a>
                                            </div>
                                        </div>
                                        
                                        <!-- Card Details -->
                                        <div class="space-y-3 text-sm">
                                            <!-- Status & Pemohon -->
                                            <div class="flex items-center justify-between">
                                                <div>
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
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $statusClasses[$surat->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                        {{ str_replace('_', ' ', ucfirst($surat->status)) }}
                                                    </span>
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $surat->created_at->format('d M Y') }}
                                                </div>
                                            </div>
                                            
                                            <!-- Info -->
                                            <div class="grid grid-cols-2 gap-3">
                                                <div>
                                                    <p class="text-xs text-gray-500 mb-1">Pemohon</p>
                                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $surat->user->name }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-xs text-gray-500 mb-1">NIK</p>
                                                    <p class="text-sm font-medium text-gray-900">{{ $surat->user->nik }}</p>
                                                </div>
                                            </div>
                                            
                                            <!-- Quick Actions -->
                                            @if($surat->status === 'diajukan')
                                            <div class="pt-3 border-t border-gray-200">
                                                <form action="{{ route('admin.surat.verifikasi', $surat) }}" method="POST" class="inline w-full">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="w-full px-3 py-1.5 bg-green-50 hover:bg-green-100 text-green-700 text-xs font-medium rounded-lg transition-colors duration-200 flex items-center justify-center"
                                                            onclick="return confirm('Verifikasi pengajuan surat ini?')">
                                                        <i class="fas fa-check-circle mr-1.5 text-xs"></i>
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
                            <div class="px-4 sm:px-5 py-4 border-t border-gray-200 bg-gray-50">
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
                        @else
                            <!-- Empty State -->
                            <div class="p-8 sm:p-10 text-center">
                                <div class="mx-auto w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                                    <i class="fas fa-inbox text-gray-400 text-xl"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                    Tidak ada pengajuan surat ditemukan
                                </h3>
                                <p class="text-gray-500 max-w-md mx-auto mb-6">
                                    @if(request()->anyFilled(['status', 'jenis_surat', 'tanggal_dari']))
                                        Tidak ada pengajuan surat yang sesuai dengan filter yang Anda pilih.
                                    @else
                                        Belum ada pengajuan surat dari warga.
                                    @endif
                                </p>
                                @if(request()->anyFilled(['status', 'jenis_surat', 'tanggal_dari']))
                                <div class="space-x-3">
                                    <a href="{{ route('admin.surat.index') }}" 
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm transition-colors duration-200">
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
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-bolt text-yellow-500"></i>
                        Aksi Cepat
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">Aksi cepat untuk manajemen pengajuan surat</p>
                </div>
                <div class="p-4 sm:p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                        <!-- Buat Surat Baru -->
                        <a href="{{ route('admin.surat.quick.create') }}" 
                           class="group p-4 sm:p-5 border border-gray-200 rounded-xl hover:border-blue-300 hover:shadow-sm transition-all duration-200 text-center sm:text-left">
                            <div class="flex flex-col items-center sm:items-start gap-3">
                                <div class="p-3 rounded-lg bg-blue-50 group-hover:bg-blue-100 transition-colors duration-200">
                                    <i class="fas fa-plus text-blue-600 text-lg"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900 group-hover:text-blue-600 transition-colors duration-200">
                                        Buat Surat Baru
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1 hidden sm:block">
                                        Buat surat untuk warga
                                    </p>
                                </div>
                                <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-blue-500 mt-1 sm:mt-0"></i>
                            </div>
                        </a>

                        <!-- Export Data -->
                        <a href="#" 
                           class="group p-4 sm:p-5 border border-gray-200 rounded-xl hover:border-green-300 hover:shadow-sm transition-all duration-200 text-center sm:text-left">
                            <div class="flex flex-col items-center sm:items-start gap-3">
                                <div class="p-3 rounded-lg bg-green-50 group-hover:bg-green-100 transition-colors duration-200">
                                    <i class="fas fa-file-export text-green-600 text-lg"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900 group-hover:text-green-600 transition-colors duration-200">
                                        Export Data
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1 hidden sm:block">
                                        Export surat ke Excel/PDF
                                    </p>
                                </div>
                                <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-green-500 mt-1 sm:mt-0"></i>
                            </div>
                        </a>

                        <!-- Kelola Jenis Surat -->
                        <a href="#" 
                           class="group p-4 sm:p-5 border border-gray-200 rounded-xl hover:border-purple-300 hover:shadow-sm transition-all duration-200 text-center sm:text-left">
                            <div class="flex flex-col items-center sm:items-start gap-3">
                                <div class="p-3 rounded-lg bg-purple-50 group-hover:bg-purple-100 transition-colors duration-200">
                                    <i class="fas fa-envelope-open-text text-purple-600 text-lg"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900 group-hover:text-purple-600 transition-colors duration-200">
                                        Kelola Jenis Surat
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1 hidden sm:block">
                                        Tambah/edit jenis surat
                                    </p>
                                </div>
                                <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-purple-500 mt-1 sm:mt-0"></i>
                            </div>
                        </a>

                        <!-- Laporan Surat -->
                        <a href="#" 
                           class="group p-4 sm:p-5 border border-gray-200 rounded-xl hover:border-orange-300 hover:shadow-sm transition-all duration-200 text-center sm:text-left">
                            <div class="flex flex-col items-center sm:items-start gap-3">
                                <div class="p-3 rounded-lg bg-orange-50 group-hover:bg-orange-100 transition-colors duration-200">
                                    <i class="fas fa-chart-bar text-orange-600 text-lg"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900 group-hover:text-orange-600 transition-colors duration-200">
                                        Laporan Surat
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1 hidden sm:block">
                                        Lihat laporan statistik surat
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