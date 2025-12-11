<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    <i class="fas fa-envelope mr-2 text-blue-600"></i>Kelola Surat
                </h2>
                <p class="text-sm text-gray-500 mt-1">Kelola pengajuan surat dari warga</p>
            </div>
            <div class="flex space-x-2">
                <button onclick="toggleFilter()" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter Section -->
            <div id="filterSection" class="bg-white p-4 rounded-lg shadow mb-6 hidden">
                <form method="GET" action="{{ route('petugas.surat.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Status Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Semua Status</option>
                            @foreach($statuses as $value => $label)
                                <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Jenis Surat Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Surat</label>
                        <select name="jenis_surat" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Semua Jenis</option>
                            @foreach($jenisSurat as $jenis)
                                <option value="{{ $jenis->id }}" {{ request('jenis_surat') == $jenis->id ? 'selected' : '' }}>
                                    {{ $jenis->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Search -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Cari nomor surat atau nama..." 
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-end space-x-2">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <i class="fas fa-search mr-2"></i>Terapkan
                        </button>
                        <a href="{{ route('petugas.surat.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                            <i class="fas fa-refresh mr-2"></i>Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <i class="fas fa-envelope text-blue-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Surat</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] ?? $surats->total() }}</p>
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
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['diajukan'] ?? $surats->where('status', 'diajukan')->count() }}</p>
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
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['diproses'] ?? $surats->where('status', 'diproses')->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center">
                        <div class="p-2 bg-green-100 rounded-lg">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Siap Ambil</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['siap_ambil'] ?? $surats->where('status', 'siap_ambil')->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center">
                        <div class="p-2 bg-gray-100 rounded-lg">
                            <i class="fas fa-archive text-gray-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Selesai</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['selesai'] ?? $surats->where('status', 'selesai')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert-auto-hide bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="alert-auto-hide bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Table -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                @if($surats->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nomor Surat
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Pemohon
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Jenis Surat
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Petugas
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal Pengajuan
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($surats as $surat)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $surat->nomor_surat ?? 'Belum ada' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $surat->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $surat->user->nik }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $surat->jenisSurat->nama }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($surat->status == 'draft') bg-gray-100 text-gray-800
                                                @elseif($surat->status == 'diajukan') bg-yellow-100 text-yellow-800
                                                @elseif($surat->status == 'diproses') bg-purple-100 text-purple-800
                                                @elseif($surat->status == 'siap_ambil') bg-green-100 text-green-800
                                                @elseif($surat->status == 'selesai') bg-gray-100 text-gray-800
                                                @elseif($surat->status == 'ditolak') bg-red-100 text-red-800
                                                @endif">
                                                {{ $statuses[$surat->status] ?? $surat->status }}
                                            </span>
                                            @if($surat->tanggal_verifikasi)
                                                <div class="text-xs text-gray-500 mt-1">
                                                    <i class="fas fa-check-circle text-green-500 mr-1"></i>
                                                    Tervifikasi: {{ $surat->tanggal_verifikasi->format('d/m/Y') }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($surat->petugas)
                                                <div class="text-sm text-gray-900">{{ $surat->petugas->name }}</div>
                                            @else
                                                <span class="text-sm text-gray-500">Belum ditugaskan</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $surat->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end space-x-2">
                                                <a href="{{ route('petugas.surat.show', $surat) }}" 
                                                   class="text-blue-600 hover:text-blue-900 p-1 rounded hover:bg-blue-50"
                                                   title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                
                                                @if($surat->status == 'diajukan' && auth()->user()->dapatMemprosesSurat())
                                                    <form action="{{ route('petugas.surat.proses', $surat) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" 
                                                                class="text-purple-600 hover:text-purple-900 p-1 rounded hover:bg-purple-50" 
                                                                title="Ambil Surat untuk Diproses"
                                                                onclick="return confirm('Apakah Anda yakin ingin mengambil surat ini untuk diproses?')">
                                                            <i class="fas fa-hand-paper"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                                @if($surat->status == 'diproses' && $surat->petugas_id == auth()->id())
                                                    <a href="{{ route('petugas.surat.edit', $surat) }}" 
                                                       class="text-yellow-600 hover:text-yellow-900 p-1 rounded hover:bg-yellow-50"
                                                       title="Proses Surat">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    
                                                    <form action="{{ route('petugas.surat.generate', $surat) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" 
                                                                class="text-green-600 hover:text-green-900 p-1 rounded hover:bg-green-50" 
                                                                title="Generate Surat"
                                                                onclick="return confirm('Apakah Anda yakin ingin generate surat ini?')">
                                                            <i class="fas fa-file-pdf"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                                @if($surat->status == 'siap_ambil' && $surat->petugas_id == auth()->id())
                                                    <form action="{{ route('petugas.surat.selesai', $surat) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" 
                                                                class="text-gray-600 hover:text-gray-900 p-1 rounded hover:bg-gray-50" 
                                                                title="Tandai Selesai"
                                                                onclick="return confirm('Apakah Anda yakin ingin menandai surat ini sebagai selesai?')">
                                                            <i class="fas fa-check-double"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                                @if($surat->file_surat)
                                                    <a href="{{ route('petugas.surat.preview', $surat) }}" 
                                                       target="_blank"
                                                       class="text-orange-600 hover:text-orange-900 p-1 rounded hover:bg-orange-50"
                                                       title="Preview PDF">
                                                        <i class="fas fa-search"></i>
                                                    </a>
                                                    <a href="{{ route('petugas.surat.download', $surat) }}" 
                                                       class="text-indigo-600 hover:text-indigo-900 p-1 rounded hover:bg-indigo-50"
                                                       title="Download PDF">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                @endif

                                                @if(in_array($surat->status, ['diajukan', 'diproses']) && auth()->user()->isAdmin())
                                                    <form action="{{ route('petugas.surat.tolak', $surat) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" 
                                                                class="text-red-600 hover:text-red-900 p-1 rounded hover:bg-red-50" 
                                                                title="Tolak Surat"
                                                                onclick="return confirm('Apakah Anda yakin ingin menolak surat ini?')">
                                                            <i class="fas fa-times-circle"></i>
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

                    <!-- Pagination -->
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        {{ $surats->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-envelope-open text-gray-400 text-5xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada surat</h3>
                        <p class="text-gray-500">
                            @if(request()->hasAny(['status', 'jenis_surat', 'search']))
                                Tidak ada surat yang sesuai dengan filter yang dipilih.
                            @else
                                Belum ada pengajuan surat yang ditemukan.
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function toggleFilter() {
            const filterSection = document.getElementById('filterSection');
            filterSection.classList.toggle('hidden');
        }

        // Auto hide success/error messages after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert-auto-hide');
                alerts.forEach(alert => {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                });
            }, 5000);
        });

        // Confirm sebelum tolak surat
        document.addEventListener('submit', function(e) {
            if (e.target.closest('form[action*="tolak"]')) {
                e.preventDefault();
                if (confirm('Apakah Anda yakin ingin menolak surat ini? Pastikan sudah memberikan alasan penolakan.')) {
                    const alasan = prompt('Masukkan alasan penolakan:');
                    if (alasan && alasan.trim() !== '') {
                        const form = e.target.closest('form');
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'alasan_penolakan';
                        input.value = alasan;
                        form.appendChild(input);
                        form.submit();
                    } else {
                        alert('Alasan penolakan harus diisi!');
                    }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>