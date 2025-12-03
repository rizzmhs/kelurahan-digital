<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    <i class="fas fa-tasks mr-2 text-blue-600"></i>Kelola Pengaduan
                </h2>
                <p class="text-sm text-gray-500 mt-1">Kelola pengaduan dari warga</p>
            </div>
            <div class="flex space-x-2">
                <button onclick="toggleFilter()" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
                <a href="{{ route('petugas.pengaduan.tugas-saya') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                    <i class="fas fa-user-check mr-2"></i>Tugas Saya
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter Section -->
            <div id="filterSection" class="bg-white p-4 rounded-lg shadow mb-6 hidden">
                <form method="GET" action="{{ route('petugas.pengaduan.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Status Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Semua Status</option>
                            <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                            <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>

                    <!-- Prioritas Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Prioritas</label>
                        <select name="prioritas" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Semua Prioritas</option>
                            <option value="rendah" {{ request('prioritas') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                            <option value="sedang" {{ request('prioritas') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="tinggi" {{ request('prioritas') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                            <option value="darurat" {{ request('prioritas') == 'darurat' ? 'selected' : '' }}>Darurat</option>
                        </select>
                    </div>

                    <!-- Search -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Cari judul atau nama..." 
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-end space-x-2">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <i class="fas fa-search mr-2"></i>Terapkan
                        </button>
                        <a href="{{ route('petugas.pengaduan.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                            <i class="fas fa-refresh mr-2"></i>Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <i class="fas fa-tasks text-blue-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Pengaduan</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $pengaduans->total() }}</p>
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
                            <p class="text-2xl font-bold text-gray-900">{{ $pengaduans->where('status', 'diajukan')->count() }}</p>
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
                            <p class="text-2xl font-bold text-gray-900">{{ $pengaduans->where('status', 'diproses')->count() }}</p>
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
                            <p class="text-2xl font-bold text-gray-900">{{ $pengaduans->where('status', 'selesai')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                @if($pengaduans->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Kode
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Judul Pengaduan
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Pemohon
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Prioritas
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($pengaduans as $pengaduan)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-mono text-gray-900 font-bold">
                                                {{ $pengaduan->kode_pengaduan }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $pengaduan->judul }}</div>
                                            <div class="text-sm text-gray-500 truncate max-w-xs">{{ $pengaduan->deskripsi }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $pengaduan->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $pengaduan->user->nik }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $pengaduan->status == 'diajukan' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $pengaduan->status == 'diproses' ? 'bg-purple-100 text-purple-800' : '' }}
                                                {{ $pengaduan->status == 'selesai' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $pengaduan->status == 'ditolak' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ ucfirst($pengaduan->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $pengaduan->prioritas == 'rendah' ? 'bg-gray-100 text-gray-800' : '' }}
                                                {{ $pengaduan->prioritas == 'sedang' ? 'bg-blue-100 text-blue-800' : '' }}
                                                {{ $pengaduan->prioritas == 'tinggi' ? 'bg-orange-100 text-orange-800' : '' }}
                                                {{ $pengaduan->prioritas == 'darurat' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ ucfirst($pengaduan->prioritas) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $pengaduan->created_at->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end space-x-2">
                                                <a href="{{ route('petugas.pengaduan.show', $pengaduan) }}" 
                                                   class="text-blue-600 hover:text-blue-900"
                                                   title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                
                                                @if($pengaduan->status == 'diajukan')
                                                    <form action="{{ route('petugas.pengaduan.update.status', $pengaduan) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="diproses">
                                                        <button type="submit" class="text-purple-600 hover:text-purple-900" title="Proses Pengaduan">
                                                            <i class="fas fa-cog"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                                @if($pengaduan->status == 'diproses')
                                                    <form action="{{ route('petugas.pengaduan.update.status', $pengaduan) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="selesai">
                                                        <button type="submit" class="text-green-600 hover:text-green-900" title="Tandai Selesai">
                                                            <i class="fas fa-check"></i>
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
                        {{ $pengaduans->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-tasks text-gray-400 text-5xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada pengaduan</h3>
                        <p class="text-gray-500">Belum ada pengaduan yang ditemukan.</p>
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
    </script>
    @endpush
</x-app-layout>