<x-app-layout>
    @php
        $title = 'Detail Jenis Surat';
    @endphp
    
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fas fa-file-alt mr-2"></i>Detail Jenis Surat
            </h2>
            <div class="flex items-center space-x-2">
                <a href="{{ route('admin.jenis_surat.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
                <a href="{{ route('admin.jenis_surat.edit', $jenisSurat->id) }}" 
                   class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
            </div>
        </div>
    </x-slot>

    <!-- Main Content -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column: Detail -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Informasi Jenis Surat -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <!-- Card Header -->
                            <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-800">
                                    <i class="fas fa-info-circle mr-2 text-blue-600"></i>Informasi Jenis Surat
                                </h3>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $jenisSurat->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $jenisSurat->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </div>

                            <!-- Kode & Nama -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-2">
                                        Kode Surat
                                    </label>
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            {{ $jenisSurat->kode }}
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-2">
                                        Nama Jenis Surat
                                    </label>
                                    <p class="text-lg font-semibold text-gray-900">{{ $jenisSurat->nama }}</p>
                                </div>
                            </div>

                            <!-- Estimasi & Biaya -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-2">
                                        Estimasi Proses
                                    </label>
                                    <p class="text-lg font-semibold text-gray-900">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-2"></i>{{ $jenisSurat->estimasi_hari }} hari
                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-2">
                                        Biaya Administrasi
                                    </label>
                                    <p class="text-lg font-semibold text-gray-900">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            Rp {{ number_format($jenisSurat->biaya, 0, ',', '.') }}
                                        </span>
                                    </p>
                                </div>
                            </div>

                            <!-- Deskripsi -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-500 mb-2">
                                    Deskripsi
                                </label>
                                <div class="mt-1 p-4 bg-gray-50 rounded-lg">
                                    <p class="text-gray-700">{{ $jenisSurat->deskripsi ?: 'Tidak ada deskripsi' }}</p>
                                </div>
                            </div>

                            <!-- Template -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-500 mb-2">
                                    Template Surat
                                </label>
                                <div class="flex items-center space-x-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                        {{ $jenisSurat->template }}
                                    </span>
                                    <a href="{{ route('admin.jenis_surat.preview.template', $jenisSurat->id) }}" 
                                       class="inline-flex items-center px-3 py-1 rounded-md text-sm font-medium text-blue-600 hover:text-blue-800 hover:bg-blue-50"
                                       target="_blank">
                                        <i class="fas fa-eye mr-2"></i>Preview Template
                                    </a>
                                    <a href="{{ route('admin.jenis_surat.edit.template', $jenisSurat->id) }}" 
                                       class="inline-flex items-center px-3 py-1 rounded-md text-sm font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50">
                                        <i class="fas fa-edit mr-2"></i>Edit Template
                                    </a>
                                </div>
                            </div>

                            <!-- Statistik -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-500 mb-4">
                                    Statistik
                                </label>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <!-- Total Surat -->
                                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <div class="p-2 bg-blue-100 rounded-lg">
                                                    <i class="fas fa-file-alt text-blue-600"></i>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm font-medium text-gray-600">Total Surat</p>
                                                <p class="text-2xl font-semibold text-gray-900">
                                                    {{ $jenisSurat->surats_count ?? 0 }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Diproses -->
                                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <div class="p-2 bg-yellow-100 rounded-lg">
                                                    <i class="fas fa-spinner text-yellow-600"></i>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm font-medium text-gray-600">Diproses</p>
                                                <p class="text-2xl font-semibold text-gray-900">
                                                    {{ $jenisSurat->surats()->where('status', 'diproses')->count() }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Selesai -->
                                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <div class="p-2 bg-green-100 rounded-lg">
                                                    <i class="fas fa-check-circle text-green-600"></i>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm font-medium text-gray-600">Selesai</p>
                                                <p class="text-2xl font-semibold text-gray-900">
                                                    {{ $jenisSurat->surats()->where('status', 'selesai')->count() }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                                <form action="{{ route('admin.jenis_surat.update.status', $jenisSurat->id) }}" 
                                      method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    @if($jenisSurat->is_active)
                                        <button type="submit" 
                                                class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            <i class="fas fa-toggle-off mr-2"></i>Nonaktifkan
                                        </button>
                                    @else
                                        <button type="submit" 
                                                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            <i class="fas fa-toggle-on mr-2"></i>Aktifkan
                                        </button>
                                    @endif
                                </form>
                                
                                <form action="{{ route('admin.jenis_surat.destroy', $jenisSurat->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus jenis surat ini?')"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        <i class="fas fa-trash mr-2"></i>Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Persyaratan & Quick Actions -->
                <div class="space-y-6">
                    <!-- Persyaratan -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <!-- Card Header -->
                            <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-800">
                                    <i class="fas fa-list-check mr-2 text-blue-600"></i>Persyaratan
                                </h3>
                            </div>

                            @php
                                $persyaratan = json_decode($jenisSurat->persyaratan, true);
                            @endphp
                            
                            @if($persyaratan && count($persyaratan) > 0)
                                <div class="space-y-3">
                                    @foreach($persyaratan as $index => $syarat)
                                        <div class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                                            <div class="flex items-center justify-between mb-2">
                                                <h4 class="text-sm font-medium text-gray-900">
                                                    {{ $syarat['label'] }}
                                                </h4>
                                                <div class="flex items-center space-x-2">
                                                    @if($syarat['required'])
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                                            Wajib
                                                        </span>
                                                    @endif
                                                    <span class="text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded">
                                                        {{ $syarat['type'] }}
                                                    </span>
                                                </div>
                                            </div>
                                            <p class="text-xs text-gray-500">
                                                Field: <code class="px-1 py-0.5 bg-gray-100 rounded">{{ $syarat['field'] }}</code>
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <i class="fas fa-exclamation-circle text-gray-400 text-4xl mb-4"></i>
                                    <p class="text-gray-500">Belum ada persyaratan yang ditentukan</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <!-- Card Header -->
                            <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-800">
                                    <i class="fas fa-bolt mr-2 text-blue-600"></i>Aksi Cepat
                                </h3>
                            </div>

                            <div class="space-y-3">
                                <a href="{{ route('admin.surat.index') }}?jenis_surat={{ $jenisSurat->id }}" 
                                   class="w-full inline-flex items-center justify-center px-4 py-3 bg-blue-50 border border-blue-200 rounded-lg text-blue-700 hover:bg-blue-100 hover:text-blue-800 transition-colors">
                                    <i class="fas fa-list mr-3"></i>
                                    <span>Lihat Semua Surat</span>
                                </a>
                                
                                <a href="{{ route('admin.jenis_surat.preview.template', $jenisSurat->id) }}" 
                                   class="w-full inline-flex items-center justify-center px-4 py-3 bg-purple-50 border border-purple-200 rounded-lg text-purple-700 hover:bg-purple-100 hover:text-purple-800 transition-colors"
                                   target="_blank">
                                    <i class="fas fa-file-alt mr-3"></i>
                                    <span>Preview Template</span>
                                </a>
                                
                                <button type="button" 
                                        x-data="{ open: false }"
                                        @click="open = true"
                                        class="w-full inline-flex items-center justify-center px-4 py-3 bg-green-50 border border-green-200 rounded-lg text-green-700 hover:bg-green-100 hover:text-green-800 transition-colors">
                                    <i class="fas fa-copy mr-3"></i>
                                    <span>Duplikat Jenis Surat</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Duplikat -->
    <div x-data="{ open: false }" 
         x-show="open" 
         x-on:keydown.escape.window="open = false"
         class="fixed inset-0 overflow-y-auto z-50"
         style="display: none;">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div x-show="open" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                 @click="open = false"></div>

            <!-- Modal panel -->
            <div x-show="open"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                <i class="fas fa-copy mr-2 text-green-600"></i>Duplikat Jenis Surat
                            </h3>
                            
                            <form action="{{ route('admin.jenis_surat.store') }}" method="POST">
                                @csrf
                                <div class="space-y-4">
                                    <p class="text-sm text-gray-500 mb-4">
                                        Jenis surat ini akan diduplikat dengan data yang sama.
                                    </p>
                                    
                                    <div>
                                        <label for="new_kode" class="block text-sm font-medium text-gray-700 mb-1">
                                            Kode Baru
                                        </label>
                                        <input type="text" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                               id="new_kode" 
                                               name="kode" 
                                               value="{{ $jenisSurat->kode }}_COPY" 
                                               required>
                                    </div>
                                    
                                    <div>
                                        <label for="new_nama" class="block text-sm font-medium text-gray-700 mb-1">
                                            Nama Baru
                                        </label>
                                        <input type="text" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                               id="new_nama" 
                                               name="nama" 
                                               value="{{ $jenisSurat->nama }} (Copy)" 
                                               required>
                                    </div>
                                    
                                    <input type="hidden" name="deskripsi" value="{{ $jenisSurat->deskripsi }}">
                                    <input type="hidden" name="estimasi_hari" value="{{ $jenisSurat->estimasi_hari }}">
                                    <input type="hidden" name="biaya" value="{{ $jenisSurat->biaya }}">
                                    <input type="hidden" name="persyaratan" value="{{ $jenisSurat->persyaratan }}">
                                    <input type="hidden" name="template" value="{{ $jenisSurat->template }}">
                                </div>
                                
                                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                    <button type="submit" 
                                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                                        <i class="fas fa-copy mr-2"></i>Duplikat
                                    </button>
                                    <button type="button" 
                                            @click="open = false"
                                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm">
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Confirm before deleting
        document.addEventListener('DOMContentLoaded', function() {
            const deleteForm = document.querySelector('form[onsubmit*="confirm"]');
            if (deleteForm) {
                const submitButton = deleteForm.querySelector('button[type="submit"]');
                submitButton.addEventListener('click', function(e) {
                    if (!confirm('Apakah Anda yakin ingin menghapus jenis surat ini?')) {
                        e.preventDefault();
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>