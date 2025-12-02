<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Buat Pengaduan Baru
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('warga.pengaduan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="space-y-6">
                            <!-- Kategori Pengaduan -->
                            <div>
                                <label for="kategori_pengaduan_id" class="block text-sm font-medium text-gray-700">Kategori Pengaduan *</label>
                                <select id="kategori_pengaduan_id" name="kategori_pengaduan_id" required
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($kategories as $kategori)
                                        <option value="{{ $kategori->id }}" {{ old('kategori_pengaduan_id') == $kategori->id ? 'selected' : '' }}>
                                            {{ $kategori->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kategori_pengaduan_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Judul Pengaduan -->
                            <div>
                                <label for="judul" class="block text-sm font-medium text-gray-700">Judul Pengaduan *</label>
                                <input type="text" name="judul" id="judul" required
                                    value="{{ old('judul') }}"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                    placeholder="Contoh: Jalan Berlubang di RT 05">
                                @error('judul')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Deskripsi Pengaduan -->
                            <div>
                                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi Lengkap *</label>
                                <textarea name="deskripsi" id="deskripsi" rows="4" required
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                    placeholder="Jelaskan secara detail masalah yang Anda laporkan...">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Lokasi Kejadian -->
                            <div>
                                <label for="lokasi" class="block text-sm font-medium text-gray-700">Lokasi Kejadian *</label>
                                <input type="text" name="lokasi" id="lokasi" required
                                    value="{{ old('lokasi') }}"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                    placeholder="Contoh: Jl. Merdeka No. 10, RT 05/RW 02">
                                @error('lokasi')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tanggal Kejadian -->
                            <div>
                                <label for="tanggal_kejadian" class="block text-sm font-medium text-gray-700">Tanggal Kejadian *</label>
                                <input type="date" name="tanggal_kejadian" id="tanggal_kejadian" required
                                    value="{{ old('tanggal_kejadian') }}"
                                    max="{{ date('Y-m-d') }}"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('tanggal_kejadian')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Upload Foto Bukti -->
                            <div>
                                <label for="foto_bukti" class="block text-sm font-medium text-gray-700">Foto Bukti (Opsional)</label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="foto_bukti" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                <span>Upload file</span>
                                                <input id="foto_bukti" name="foto_bukti[]" type="file" multiple class="sr-only" accept="image/*">
                                            </label>
                                            <p class="pl-1">atau drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF maksimal 5MB per file</p>
                                        <p class="text-xs text-gray-500">Maksimal 5 file</p>
                                    </div>
                                </div>
                                <div id="file-preview" class="mt-2 grid grid-cols-2 md:grid-cols-3 gap-2 hidden"></div>
                                @error('foto_bukti.*')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Informasi Tambahan -->
                            <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-blue-800">Informasi Penting</h3>
                                        <div class="mt-2 text-sm text-blue-700">
                                            <ul class="list-disc list-inside space-y-1">
                                                <li>Pastikan data yang diisi akurat dan dapat dipertanggungjawabkan</li>
                                                <li>Foto bukti akan membantu petugas dalam menangani pengaduan</li>
                                                <li>Pengaduan akan diverifikasi terlebih dahulu oleh admin</li>
                                                <li>Anda dapat melacak status pengaduan kapan saja</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="flex justify-end space-x-3">
                                <a href="{{ route('warga.pengaduan.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Batal
                                </a>
                                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Kirim Pengaduan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // File preview functionality
        document.getElementById('foto_bukti').addEventListener('change', function(e) {
            const previewContainer = document.getElementById('file-preview');
            previewContainer.innerHTML = '';
            previewContainer.classList.remove('hidden');

            const files = e.target.files;
            
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'relative';
                        div.innerHTML = `
                            <img src="${e.target.result}" class="w-full h-32 object-cover rounded-lg">
                            <button type="button" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs" onclick="this.parentElement.remove()">
                                ×
                            </button>
                        `;
                        previewContainer.appendChild(div);
                    }
                    reader.readAsDataURL(file);
                }
            }

            // Hide preview if no files
            if (files.length === 0) {
                previewContainer.classList.add('hidden');
            }
        });

        // Set max date to today
        document.getElementById('tanggal_kejadian').max = new Date().toISOString().split('T')[0];
    </script>
    @endpush
</x-app-layout>