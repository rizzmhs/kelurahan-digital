<x-app-layout>
    <x-slot name="title">Edit Kategori Pengaduan</x-slot>
    
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Header -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-800">Edit Kategori Pengaduan</h2>
                                <p class="text-gray-600 mt-1">Perbarui informasi kategori</p>
                            </div>
                            <a href="{{ route('admin.kategori_pengaduan.index') }}" 
                               class="text-gray-600 hover:text-gray-900 flex items-center transition duration-200">
                                <i class="fas fa-arrow-left mr-2"></i> Kembali
                            </a>
                        </div>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('admin.kategori_pengaduan.update', $kategori->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-6">
                            <!-- Kategori Info -->
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                <h3 class="text-lg font-medium text-gray-700 mb-3">Informasi Kategori</h3>
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-500">ID Kategori</p>
                                        <p class="font-medium">{{ $kategori->id }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Tanggal Dibuat</p>
                                        <p class="font-medium">{{ $kategori->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Nama Kategori -->
                            <div>
                                <label for="nama_kategori" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Kategori <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="nama_kategori" 
                                       id="nama_kategori" 
                                       value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="Masukkan nama kategori"
                                       required>
                                @error('nama_kategori')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Deskripsi -->
                            <div>
                                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                                    Deskripsi Kategori
                                </label>
                                <textarea name="deskripsi" 
                                          id="deskripsi" 
                                          rows="4"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                          placeholder="Tambahkan deskripsi singkat tentang kategori ini">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <div class="flex justify-between mt-1">
                                    <p class="text-xs text-gray-500">Maksimal 500 karakter</p>
                                    <p id="charCount" class="text-xs text-gray-500">{{ strlen(old('deskripsi', $kategori->deskripsi)) }}/500</p>
                                </div>
                            </div>

                            <!-- Icon Preview & Input -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Icon Kategori
                                </label>
                                <div class="flex items-center space-x-4">
                                    <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center">
                                        @if($kategori->icon)
                                            <i class="{{ $kategori->icon }} text-blue-600 text-2xl"></i>
                                        @else
                                            <i class="fas fa-folder text-blue-600 text-2xl"></i>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <input type="text" 
                                               name="icon" 
                                               id="icon" 
                                               value="{{ old('icon', $kategori->icon) }}"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                               placeholder="Contoh: fas fa-road">
                                        <p class="mt-1 text-xs text-gray-500">Gunakan class icon Font Awesome</p>
                                    </div>
                                </div>
                                @error('icon')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
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
                                               {{ old('is_active', $kategori->is_active) ? 'checked' : '' }}
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
                                               {{ !old('is_active', $kategori->is_active) ? 'checked' : '' }}
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

                            <!-- Danger Zone -->
                            @if($kategori->pengaduans()->exists())
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                <h3 class="text-lg font-medium text-red-700 mb-2">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>Peringatan
                                </h3>
                                <p class="text-sm text-red-600">
                                    Kategori ini memiliki {{ $kategori->pengaduans()->count() }} pengaduan yang terkait.
                                    Mengubah atau menonaktifkan kategori dapat mempengaruhi data pengaduan.
                                </p>
                            </div>
                            @endif

                            <!-- Form Actions -->
                            <div class="pt-6 border-t border-gray-200">
                                <div class="flex justify-between items-center">
                                    <div>
                                        @if($kategori->pengaduans()->exists())
                                            <span class="text-sm text-gray-500">
                                                <i class="fas fa-link mr-1"></i>
                                                Terhubung dengan {{ $kategori->pengaduans()->count() }} pengaduan
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex space-x-3">
                                        <a href="{{ route('admin.kategori_pengaduan.index') }}" 
                                           class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                                            Batal
                                        </a>
                                        <button type="submit" 
                                                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                                            <i class="fas fa-save mr-2"></i> Perbarui Kategori
                                        </button>
                                    </div>
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
    });
    </script>
    @endpush
</x-app-layout>