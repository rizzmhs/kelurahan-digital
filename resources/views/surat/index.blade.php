<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
                    <i class="fas fa-envelope mr-2 text-green-600"></i>Daftar Surat Saya
                </h2>
                <p class="text-sm text-gray-500 mt-1">Kelola dan pantau semua pengajuan surat Anda</p>
            </div>
            <div class="text-sm text-gray-500">
                {{ now()->format('d/m/Y') }}
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200 card-hover">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Total Surat</p>
                                <p class="text-3xl font-bold text-gray-900 stats-counter">{{ $surats->total() }}</p>
                            </div>
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                <i class="fas fa-file-alt text-xl"></i>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-sm text-gray-500">
                            <i class="fas fa-chart-bar mr-2"></i>
                            <span>Semua pengajuan</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200 card-hover">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Draft</p>
                                <p class="text-3xl font-bold text-gray-900 stats-counter">{{ $surats->where('status', 'draft')->count() }}</p>
                            </div>
                            <div class="p-3 rounded-full bg-gray-100 text-gray-600">
                                <i class="fas fa-pencil-alt text-xl"></i>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-sm text-gray-500">
                            <i class="fas fa-edit mr-2"></i>
                            <span>Belum diajukan</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200 card-hover">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Diproses</p>
                                <p class="text-3xl font-bold text-gray-900 stats-counter">{{ $surats->whereIn('status', ['diajukan', 'diproses'])->count() }}</p>
                            </div>
                            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                                <i class="fas fa-cog text-xl"></i>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-sm text-gray-500">
                            <i class="fas fa-spinner mr-2"></i>
                            <span>Dalam proses</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200 card-hover">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Selesai</p>
                                <p class="text-3xl font-bold text-gray-900 stats-counter">{{ $surats->where('status', 'selesai')->count() }}</p>
                            </div>
                            <div class="p-3 rounded-full bg-green-100 text-green-600">
                                <i class="fas fa-check-circle text-xl"></i>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-sm text-gray-500">
                            <i class="fas fa-check-double mr-2"></i>
                            <span>Telah selesai</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-history text-gray-500 mr-2"></i>Riwayat Pengajuan Surat
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Total: {{ $surats->total() }} surat
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('warga.surat.create') }}" 
                           class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-medium py-2.5 px-5 rounded-lg transition-all duration-200 flex items-center hover:shadow-lg card-hover">
                            <i class="fas fa-plus mr-2.5"></i>
                            Ajukan Surat Baru
                        </a>
                    </div>
                </div>

                <div class="p-6">
                    @if($surats->count() > 0)
                        <!-- Desktop Table -->
                        <div class="hidden md:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                            <div class="flex items-center">
                                                <i class="fas fa-hashtag mr-2 text-gray-500"></i>
                                                Nomor Surat
                                            </div>
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                            <div class="flex items-center">
                                                <i class="fas fa-file-signature mr-2 text-gray-500"></i>
                                                Jenis Surat
                                            </div>
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                            <div class="flex items-center">
                                                <i class="fas fa-info-circle mr-2 text-gray-500"></i>
                                                Status
                                            </div>
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                            <div class="flex items-center">
                                                <i class="fas fa-calendar-alt mr-2 text-gray-500"></i>
                                                Tanggal
                                            </div>
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                            <div class="flex items-center">
                                                <i class="fas fa-cogs mr-2 text-gray-500"></i>
                                                Aksi
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($surats as $surat)
                                    <tr class="hover:bg-gray-50 transition duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($surat->nomor_surat)
                                                <div class="text-sm font-medium text-blue-600 font-mono">
                                                    {{ $surat->nomor_surat }}
                                                </div>
                                            @else
                                                <div class="text-sm text-gray-500 italic">
                                                    <i class="fas fa-clock mr-1"></i>Belum ada nomor
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="min-w-0">
                                                <div class="text-sm font-semibold text-gray-900 truncate">
                                                    {{ $surat->jenisSurat->nama ?? '-' }}
                                                </div>
                                                <div class="text-xs text-gray-500 mt-1 truncate">
                                                    {{ Str::limit($surat->jenisSurat->deskripsi ?? '-', 70) }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
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
                                                    'draft' => 'fas fa-pencil-alt',
                                                    'diajukan' => 'fas fa-paper-plane',
                                                    'diproses' => 'fas fa-cog',
                                                    'siap_ambil' => 'fas fa-check',
                                                    'selesai' => 'fas fa-check-circle',
                                                    'ditolak' => 'fas fa-times-circle'
                                                ];
                                                $statusTexts = [
                                                    'draft' => 'Draft',
                                                    'diajukan' => 'Diajukan',
                                                    'diproses' => 'Diproses',
                                                    'siap_ambil' => 'Siap Ambil',
                                                    'selesai' => 'Selesai',
                                                    'ditolak' => 'Ditolak'
                                                ];
                                            @endphp
                                            <div class="flex items-center">
                                                <span class="px-3 py-1.5 text-xs font-semibold rounded-full {{ $statusClasses[$surat->status] }} flex items-center">
                                                    <i class="{{ $statusIcons[$surat->status] }} mr-1.5 text-xs"></i>
                                                    {{ $statusTexts[$surat->status] ?? ucfirst($surat->status) }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            <div class="flex flex-col">
                                                <div class="flex items-center">
                                                    <i class="far fa-calendar mr-2 text-gray-400"></i>
                                                    {{ $surat->created_at->format('d/m/Y') }}
                                                </div>
                                                <div class="text-xs text-gray-500 mt-1">
                                                    {{ $surat->created_at->format('H:i') }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <div class="flex items-center space-x-2">
                                                <a href="{{ route('warga.surat.show', $surat) }}" 
                                                   class="text-blue-600 hover:text-blue-800 transition duration-200 flex items-center"
                                                   title="Lihat Detail">
                                                    <i class="fas fa-eye mr-1.5"></i>
                                                    <span class="hidden lg:inline">Lihat</span>
                                                </a>
                                                
                                                @if(in_array($surat->status, ['draft', 'ditolak']))
                                                <a href="{{ route('warga.surat.edit', $surat) }}" 
                                                   class="text-yellow-600 hover:text-yellow-800 transition duration-200 flex items-center"
                                                   title="Edit Surat">
                                                    <i class="fas fa-edit mr-1.5"></i>
                                                    <span class="hidden lg:inline">Edit</span>
                                                </a>
                                                @endif
                                                
                                                @if($surat->status === 'siap_ambil')
                                                <a href="{{ route('warga.surat.download', $surat) }}" 
                                                   class="text-green-600 hover:text-green-800 transition duration-200 flex items-center"
                                                   title="Download Surat">
                                                    <i class="fas fa-download mr-1.5"></i>
                                                    <span class="hidden lg:inline">Download</span>
                                                </a>
                                                @endif
                                                
                                                @if($surat->status === 'draft')
                                                <form action="{{ route('warga.surat.destroy', $surat) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="text-red-600 hover:text-red-800 transition duration-200 flex items-center"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus surat ini?')"
                                                            title="Hapus Draft">
                                                        <i class="fas fa-trash mr-1.5"></i>
                                                        <span class="hidden lg:inline">Hapus</span>
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

                        <!-- Mobile Cards -->
                        <div class="md:hidden space-y-4">
                            @foreach($surats as $surat)
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition duration-200">
                                <div class="p-4">
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex-1">
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
                                                    'draft' => 'fas fa-pencil-alt',
                                                    'diajukan' => 'fas fa-paper-plane',
                                                    'diproses' => 'fas fa-cog',
                                                    'siap_ambil' => 'fas fa-check',
                                                    'selesai' => 'fas fa-check-circle',
                                                    'ditolak' => 'fas fa-times-circle'
                                                ];
                                            @endphp
                                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $statusClasses[$surat->status] }} mb-2 inline-block">
                                                <i class="{{ $statusIcons[$surat->status] }} mr-1.5"></i>
                                                {{ str_replace('_', ' ', ucfirst($surat->status)) }}
                                            </span>
                                            <h4 class="text-sm font-semibold text-gray-900">
                                                {{ $surat->jenisSurat->nama ?? '-' }}
                                            </h4>
                                            @if($surat->nomor_surat)
                                                <p class="text-xs text-gray-600 mt-1">
                                                    <i class="fas fa-hashtag mr-1"></i>{{ $surat->nomor_surat }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="text-xs text-gray-600 mb-3">
                                        <p class="mb-2">
                                            {{ Str::limit($surat->jenisSurat->deskripsi ?? '-', 100) }}
                                        </p>
                                        <div class="flex items-center text-gray-500">
                                            <i class="fas fa-calendar-alt mr-2"></i>
                                            <span>{{ $surat->created_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="flex flex-wrap gap-2 pt-3 border-t border-gray-100">
                                        <a href="{{ route('warga.surat.show', $surat) }}" 
                                           class="text-blue-600 hover:text-blue-800 text-xs font-medium px-3 py-1.5 bg-blue-50 rounded-lg transition duration-200 flex items-center">
                                            <i class="fas fa-eye mr-1.5"></i>Lihat
                                        </a>
                                        
                                        @if(in_array($surat->status, ['draft', 'ditolak']))
                                        <a href="{{ route('warga.surat.edit', $surat) }}" 
                                           class="text-yellow-600 hover:text-yellow-800 text-xs font-medium px-3 py-1.5 bg-yellow-50 rounded-lg transition duration-200 flex items-center">
                                            <i class="fas fa-edit mr-1.5"></i>Edit
                                        </a>
                                        @endif
                                        
                                        @if($surat->status === 'siap_ambil')
                                        <a href="{{ route('warga.surat.download', $surat) }}" 
                                           class="text-green-600 hover:text-green-800 text-xs font-medium px-3 py-1.5 bg-green-50 rounded-lg transition duration-200 flex items-center">
                                            <i class="fas fa-download mr-1.5"></i>Download
                                        </a>
                                        @endif
                                        
                                        @if($surat->status === 'draft')
                                        <form action="{{ route('warga.surat.destroy', $surat) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-800 text-xs font-medium px-3 py-1.5 bg-red-50 rounded-lg transition duration-200 flex items-center"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus surat ini?')">
                                                <i class="fas fa-trash mr-1.5"></i>Hapus
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        @if($surats->hasPages())
                        <div class="mt-6 border-t border-gray-200 pt-4">
                            <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                                <div class="text-sm text-gray-700">
                                    Menampilkan 
                                    <span class="font-medium">{{ $surats->firstItem() }}</span>
                                    hingga 
                                    <span class="font-medium">{{ $surats->lastItem() }}</span>
                                    dari 
                                    <span class="font-medium">{{ $surats->total() }}</span>
                                    hasil
                                </div>
                                <div class="flex space-x-1">
                                    {{ $surats->links('pagination::tailwind') }}
                                </div>
                            </div>
                        </div>
                        @endif

                    @else
                        <!-- Empty State -->
                        <div class="text-center py-12">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 mb-4">
                                <i class="fas fa-envelope-open-text text-green-600 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada pengajuan surat</h3>
                            <p class="text-gray-500 max-w-md mx-auto mb-6">
                                Anda belum mengajukan surat apapun. Mulai ajukan surat untuk kebutuhan administrasi Anda.
                            </p>
                            <div class="flex flex-wrap justify-center gap-3">
                                <a href="{{ route('warga.surat.create') }}" 
                                   class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-medium py-2.5 px-5 rounded-lg transition-all duration-200 flex items-center hover:shadow-lg card-hover">
                                    <i class="fas fa-plus mr-2.5"></i>
                                    Ajukan Surat Pertama
                                </a>
                                <a href="{{ route('dashboard') }}" 
                                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2.5 px-5 rounded-lg transition-all duration-200 flex items-center card-hover">
                                    <i class="fas fa-home mr-2.5"></i>
                                    Kembali ke Dashboard
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .stats-counter {
            font-feature-settings: "tnum";
            font-variant-numeric: tabular-nums;
        }
        
        /* Custom pagination styling */
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .page-item {
            margin: 0 2px;
        }
        
        .page-link {
            display: block;
            padding: 0.5rem 0.75rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            color: #374151;
            font-size: 0.875rem;
            transition: all 0.2s;
        }
        
        .page-link:hover {
            background-color: #f3f4f6;
            border-color: #d1d5db;
        }
        
        .page-item.active .page-link {
            background-color: #10b981; /* Green color for surat */
            border-color: #10b981;
            color: white;
        }
        
        .page-item.disabled .page-link {
            color: #9ca3af;
            background-color: #f9fafb;
            border-color: #e5e7eb;
            cursor: not-allowed;
        }
    </style>
    @endpush
</x-app-layout>