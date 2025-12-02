<x-app-layout>
    <x-slot name="title">Tambah Kategori Pengaduan Baru</x-slot>
    
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Header -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-800">Tambah Kategori Pengaduan Baru</h2>
                                <p class="text-gray-600 mt-1">Tambahkan kategori baru untuk pengaduan warga</p>
                            </div>
                            <a href="{{ route('admin.kategori_pengaduan.index') }}" 
                               class="text-gray-600 hover:text-gray-900 flex items-center transition duration-200">
                                <i class="fas fa-arrow-left mr-2"></i> Kembali
                            </a>
                        </div>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('admin.kategori_pengaduan.store') }}" method="POST">
                        @csrf
                        
                        <div class="space-y-6">
                            <!-- Nama Kategori -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <label for="nama_kategori" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Kategori <span class="text-red-500">*</span>
                                </label>
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-100 rounded-l-md flex items-center justify-center">
                                        <i class="fas fa-tag text-blue-600"></i>
                                    </div>
                                    <input type="text" 
                                           name="nama_kategori" 
                                           id="nama_kategori" 
                                           value="{{ old('nama_kategori') }}"
                                           class="flex-1 px-3 py-2 border border-l-0 border-gray-300 rounded-r-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="Contoh: Infrastruktur, Kebersihan, Keamanan"
                                           required
                                           autofocus>
                                </div>
                                @error('nama_kategori')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-xs text-gray-500">Nama kategori harus unik dan deskriptif</p>
                            </div>

                            <!-- Deskripsi -->
                            <div>
                                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                                    Deskripsi Kategori
                                </label>
                                <div class="flex">
                                    <div class="w-10 h-32 bg-gray-100 rounded-l-md flex items-start justify-center pt-3">
                                        <i class="fas fa-align-left text-gray-600"></i>
                                    </div>
                                    <textarea name="deskripsi" 
                                              id="deskripsi" 
                                              rows="4"
                                              class="flex-1 px-3 py-2 border border-l-0 border-gray-300 rounded-r-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                              placeholder="Tambahkan deskripsi singkat tentang kategori ini (opsional)">{{ old('deskripsi') }}</textarea>
                                </div>
                                @error('deskripsi')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <div class="flex justify-between mt-1">
                                    <p class="text-xs text-gray-500">Maksimal 500 karakter</p>
                                    <p id="charCount" class="text-xs text-gray-500">0/500</p>
                                </div>
                            </div>

                            <!-- Icon -->
                            <div>
                                <label for="icon" class="block text-sm font-medium text-gray-700 mb-2">
                                    Icon Kategori (Opsional)
                                </label>
                                <div class="flex">
                                    <div class="w-10 h-10 bg-gray-100 rounded-l-md flex items-center justify-center">
                                        <i class="fas fa-icons text-gray-600"></i>
                                    </div>
                                    <input type="text" 
                                           name="icon" 
                                           id="icon" 
                                           value="{{ old('icon') }}"
                                           class="flex-1 px-3 py-2 border border-l-0 border-gray-300 rounded-r-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="Contoh: fas fa-road, fas fa-trash, fas fa-shield-alt">
                                </div>
                                @error('icon')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <div class="mt-3">
                                    <p class="text-sm font-medium text-gray-700 mb-2">Pilih Icon:</p>
                                    <div class="grid grid-cols-6 sm:grid-cols-8 gap-2">
                                        @php
                                            $commonIcons = [
                                                'fas fa-road' => 'Infrastruktur',
                                                'fas fa-trash' => 'Kebersihan',
                                                'fas fa-shield-alt' => 'Keamanan',
                                                'fas fa-lightbulb' => 'Penerangan',
                                                'fas fa-tint' => 'Air',
                                                'fas fa-tree' => 'Lingkungan',
                                                'fas fa-car' => 'Parkir',
                                                'fas fa-users' => 'Sosial',
                                                'fas fa-school' => 'Pendidikan',
                                                'fas fa-heartbeat' => 'Kesehatan',
                                                'fas fa-gavel' => 'Hukum',
                                                'fas fa-wrench' => 'Perbaikan',
                                            ];
                                        @endphp
                                        @foreach($commonIcons as $icon => $title)
                                            <button type="button" 
                                                    class="p-3 border border-gray-300 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition duration-200"
                                                    onclick="document.getElementById('icon').value = '{{ $icon }}'"
                                                    title="{{ $title }}">
                                                <i class="{{ $icon }} text-gray-600 text-lg"></i>
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Status Kategori
                                </label>
                                <div class="space-y-3">
                                    <div class="flex items-center">
                                        <input type="radio" 
                                               name="is_active" 
                                               id="status_active" 
                                               value="1" 
                                               {{ old('is_active', 1) ? 'checked' : '' }}
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <label for="status_active" class="ml-3 flex items-center">
                                            <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                                            <span class="text-sm font-medium text-gray-700">Aktif</span>
                                            <span class="text-sm text-gray-500 ml-2">(Kategori dapat digunakan)</span>
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="radio" 
                                               name="is_active" 
                                               id="status_inactive" 
                                               value="0" 
                                               {{ old('is_active') == '0' ? 'checked' : '' }}
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <label for="status_inactive" class="ml-3 flex items-center">
                                            <span class="w-3 h-3 bg-red-500 rounded-full mr-2"></span>
                                            <span class="text-sm font-medium text-gray-700">Nonaktif</span>
                                            <span class="text-sm text-gray-500 ml-2">(Kategori tidak dapat digunakan)</span>
                                        </label>
                                    </div>
                                </div>
                                @error('is_active')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Form Actions -->
                            <div class="pt-6 border-t border-gray-200">
                                <div class="flex justify-end space-x-3">
                                    <a href="{{ route('admin.kategori_pengaduan.index') }}" 
                                       class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                                        Batal
                                    </a>
                                    <button type="submit" 
                                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                                        <i class="fas fa-save mr-2"></i> Simpan Kategori
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Character counter for description
        const textarea = document.getElementById('deskripsi');
        const charCount = document.getElementById('charCount');
        
        textarea.addEventListener('input', function() {
            const length = this.value.length;
            charCount.textContent = length + '/500';
            
            if (length > 500) {
                charCount.classList.remove('text-gray-500');
                charCount.classList.add('text-red-500');
            } else {
                charCount.classList.remove('text-red-500');
                charCount.classList.add('text-gray-500');
            }
        });
        
        // Initialize counter
        charCount.textContent = textarea.value.length + '/500';
    });
    </script>
    @endpush
</x-app-layout>