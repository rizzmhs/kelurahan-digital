<x-app-layout>
    @php
        $title = 'Jenis Surat';
    @endphp
    
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    <i class="fas fa-file-alt mr-2 text-blue-600"></i>Jenis Surat
                </h2>
                <!-- Status Filter -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" 
                            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <i class="fas fa-filter mr-2"></i>Filter Status
                        <i class="fas fa-chevron-down ml-2 text-xs" :class="{ 'rotate-180': open }"></i>
                    </button>
                    
                    <div x-show="open" @click.away="open = false" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                        <a href="{{ route('admin.jenis_surat.index') }}" 
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request('status') == '' ? 'bg-blue-50 text-blue-700' : '' }}">
                            Semua Jenis Surat
                        </a>
                        <a href="{{ route('admin.jenis_surat.index') }}?status=aktif" 
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request('status') == 'aktif' ? 'bg-green-50 text-green-700' : '' }}">
                            Aktif
                        </a>
                        <a href="{{ route('admin.jenis_surat.index') }}?status=nonaktif" 
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request('status') == 'nonaktif' ? 'bg-red-50 text-red-700' : '' }}">
                            Nonaktif
                        </a>
                    </div>
                </div>
            </div>
            
            <div>
                <a href="{{ route('admin.jenis_surat.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fas fa-plus-circle mr-2"></i>Tambah Jenis Surat
                </a>
            </div>
        </div>
    </x-slot>

    <!-- Main Content -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Total Jenis Surat -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="p-3 bg-blue-100 rounded-lg">
                                    <i class="fas fa-file-alt text-blue-600 text-xl"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total Jenis Surat</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $jenisSurat->total() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Aktif -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-green-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="p-3 bg-green-100 rounded-lg">
                                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Aktif</p>
                                <p class="text-2xl font-semibold text-gray-900">
                                    {{ $jenisSurat->where('is_active', true)->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Nonaktif -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-yellow-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="p-3 bg-yellow-100 rounded-lg">
                                    <i class="fas fa-times-circle text-yellow-600 text-xl"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Nonaktif</p>
                                <p class="text-2xl font-semibold text-gray-900">
                                    {{ $jenisSurat->where('is_active', false)->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Template Default -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-purple-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="p-3 bg-purple-100 rounded-lg">
                                    <i class="fas fa-code text-purple-600 text-xl"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Template Default</p>
                                <p class="text-2xl font-semibold text-gray-900">
                                    {{ $jenisSurat->where('template', 'default')->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                <span class="text-green-700 font-medium">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                                <span class="text-red-700 font-medium">{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Kode
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Jenis Surat
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Estimasi
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Biaya
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Jumlah Surat
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($jenisSurat as $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $loop->iteration + ($jenisSurat->currentPage() - 1) * $jenisSurat->perPage() }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $item->kode }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $item->nama }}</div>
                                            <div class="text-sm text-gray-500">{{ Str::limit($item->deskripsi, 50) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-clock mr-1"></i>{{ $item->estimasi_hari }} hari
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Rp {{ number_format($item->biaya, 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <form action="{{ route('admin.jenis_surat.update.status', $item->id) }}" 
                                                  method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                @if($item->is_active)
                                                    <button type="submit" 
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 hover:bg-green-200">
                                                        <i class="fas fa-toggle-on mr-1"></i>Aktif
                                                    </button>
                                                @else
                                                    <button type="submit" 
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 hover:bg-red-200">
                                                        <i class="fas fa-toggle-off mr-1"></i>Nonaktif
                                                    </button>
                                                @endif
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                {{ $item->surats_count ?? 0 }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center space-x-2">
                                                <!-- Detail -->
                                                <a href="{{ route('admin.jenis_surat.show', $item->id) }}" 
                                                   class="text-blue-600 hover:text-blue-900"
                                                   title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                
                                                <!-- Edit -->
                                                <a href="{{ route('admin.jenis_surat.edit', $item->id) }}" 
                                                   class="text-yellow-600 hover:text-yellow-900"
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                
                                                <!-- Template -->
                                                <a href="{{ route('admin.jenis_surat.edit.template', $item->id) }}" 
                                                   class="text-gray-600 hover:text-gray-900"
                                                   title="Template">
                                                    <i class="fas fa-code"></i>
                                                </a>
                                                
                                                <!-- Delete -->
                                                <form action="{{ route('admin.jenis_surat.destroy', $item->id) }}" 
                                                      method="POST" 
                                                      class="inline"
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus jenis surat ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="text-red-600 hover:text-red-900"
                                                            title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <i class="fas fa-inbox text-gray-400 text-4xl mb-4"></i>
                                                <p class="text-gray-500 text-lg">Belum ada jenis surat</p>
                                                <p class="text-gray-400 text-sm mt-1">Mulai dengan menambahkan jenis surat baru</p>
                                                <a href="{{ route('admin.jenis_surat.create') }}" 
                                                   class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                                    <i class="fas fa-plus-circle mr-2"></i>Tambah Jenis Surat
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($jenisSurat->hasPages())
                        <div class="mt-6">
                            {{ $jenisSurat->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Filter status active indicator
        document.addEventListener('DOMContentLoaded', function() {
            const statusFilter = new URLSearchParams(window.location.search).get('status');
            const filterButton = document.querySelector('[x-data] button');
            
            if (statusFilter) {
                let filterText = 'Filter Status';
                switch(statusFilter) {
                    case 'aktif':
                        filterText = 'Aktif';
                        break;
                    case 'nonaktif':
                        filterText = 'Nonaktif';
                        break;
                }
                
                filterButton.innerHTML = `<i class="fas fa-filter mr-2"></i>${filterText}<i class="fas fa-chevron-down ml-2 text-xs"></i>`;
            }
            
            // Confirm before deleting
            const deleteForms = document.querySelectorAll('form[onsubmit*="confirm"]');
            deleteForms.forEach(form => {
                const submitButton = form.querySelector('button[type="submit"]');
                submitButton.addEventListener('click', function(e) {
                    if (!confirm('Apakah Anda yakin ingin menghapus jenis surat ini?')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
    @endpush
</x-app-layout>