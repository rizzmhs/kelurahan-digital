<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Pengaduan - {{ $pengaduan->kode_pengaduan }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if($pengaduan->status !== 'menunggu')
                    <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Pengaduan Tidak Dapat Diedit</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>Pengaduan dengan status "{{ ucfirst($pengaduan->status) }}" tidak dapat diedit. Hanya pengaduan dengan status "Menunggu" yang dapat diubah.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <form action="{{ route('warga.pengaduan.update', $pengaduan) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <!-- Kategori Pengaduan -->
                            <div>
                                <label for="kategori_pengaduan_id" class="block text-sm font-medium text-gray-700">Kategori Pengaduan *</label>
                                <select id="kategori_pengaduan_id" name="kategori_pengaduan_id" required
                                    {{ $pengaduan->status !== 'menunggu' ? 'disabled' : '' }}
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md {{ $pengaduan->status !== 'menunggu' ? 'bg-gray-100' : '' }}">
                                    @foreach($kategories as $kategori)
                                        <option value="{{ $kategori->id }}" {{ $pengaduan->kategori_pengaduan_id == $kategori->id ? 'selected' : '' }}>
                                            {{ $kategori->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Judul Pengaduan -->
                            <div>
                                <label for="judul" class="block text-sm font-medium text-gray-700">Judul Pengaduan *</label>
                                <input type="text" name="judul" id="judul" required
                                    value="{{ old('judul', $pengaduan->judul) }}"
                                    {{ $pengaduan->status !== 'menunggu' ? 'disabled' : '' }}
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md {{ $pengaduan->status !== 'menunggu' ? 'bg-gray-100' : '' }}">
                            </div>

                            <!-- Deskripsi Pengaduan -->
                            <div>
                                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi Lengkap *</label>
                                <textarea name="deskripsi" id="deskripsi" rows="4" required
                                    {{ $pengaduan->status !== 'menunggu' ? 'disabled' : '' }}
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md {{ $pengaduan->status !== 'menunggu' ? 'bg-gray-100' : '' }}">{{ old('deskripsi', $pengaduan->deskripsi) }}</textarea>
                            </div>

                            <!-- Lokasi Kejadian -->
                            <div>
                                <label for="lokasi" class="block text-sm font-medium text-gray-700">Lokasi Kejadian *</label>
                                <input type="text" name="lokasi" id="lokasi" required
                                    value="{{ old('lokasi', $pengaduan->lokasi) }}"
                                    {{ $pengaduan->status !== 'menunggu' ? 'disabled' : '' }}
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md {{ $pengaduan->status !== 'menunggu' ? 'bg-gray-100' : '' }}">
                            </div>

                            <!-- Tanggal Kejadian -->
                            <div>
                                <label for="tanggal_kejadian" class="block text-sm font-medium text-gray-700">Tanggal Kejadian *</label>
                                <input type="date" name="tanggal_kejadian" id="tanggal_kejadian" required
                                    value="{{ old('tanggal_kejadian', $pengaduan->tanggal_kejadian->format('Y-m-d')) }}"
                                    {{ $pengaduan->status !== 'menunggu' ? 'disabled' : '' }}
                                    max="{{ date('Y-m-d') }}"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md {{ $pengaduan->status !== 'menunggu' ? 'bg-gray-100' : '' }}">
                            </div>

                            <!-- Current Photos -->
                            @if($pengaduan->foto_bukti && count($pengaduan->foto_bukti) > 0)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Foto Bukti Saat Ini</label>
                                <div class="mt-2 grid grid-cols-2 md:grid-cols-3 gap-3">
                                    @foreach($pengaduan->foto_bukti as $foto)
                                    <div class="relative">
                                        <img src="{{ Storage::url($foto) }}" alt="Foto bukti" class="w-full h-32 object-cover rounded-lg">
                                        <div class="absolute top-1 right-1">
                                            <a href="{{ Storage::url($foto) }}" target="_blank" class="bg-white bg-opacity-90 p-1 rounded-full">
                                                <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m0 0l3-3m-3 3l-3-3"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Untuk mengubah foto, hapus pengaduan ini dan buat yang baru.</p>
                            </div>
                            @endif

                            <!-- Submit Buttons -->
                            <div class="flex justify-end space-x-3">
                                <a href="{{ route('warga.pengaduan.show', $pengaduan) }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Batal
                                </a>
                                @if($pengaduan->status === 'menunggu')
                                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Update Pengaduan
                                </button>
                                @endif
                            </div>
                        </div>
                    </form>

                    <!-- Delete Form -->
                    @if($pengaduan->status === 'menunggu')
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="bg-red-50 border border-red-200 rounded-md p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">Hapus Pengaduan</h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <p>Setelah dihapus, pengaduan ini tidak dapat dikembalikan. Pastikan Anda yakin ingin menghapusnya.</p>
                                    </div>
                                    <div class="mt-3">
                                        <form action="{{ route('warga.pengaduan.destroy', $pengaduan) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-md text-sm font-medium" onclick="return confirm('Apakah Anda yakin ingin menghapus pengaduan ini?')">
                                                Hapus Pengaduan
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Set max date to today
        document.getElementById('tanggal_kejadian').max = new Date().toISOString().split('T')[0];
    </script>
    @endpush
</x-app-layout>