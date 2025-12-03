<x-app-layout>
    @php
        $title = 'Edit Jenis Surat';
    @endphp
    
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fas fa-edit mr-2 text-blue-600"></i>Edit Jenis Surat
            </h2>
            <a href="{{ route('admin.jenis_surat.show', $jenisSurat->id) }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </x-slot>

    <!-- Main Content -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Card Header -->
                    <div class="mb-6 pb-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">
                            <i class="fas fa-edit mr-2 text-blue-600"></i>Form Edit Jenis Surat
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Perbarui informasi jenis surat di bawah ini.</p>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('admin.jenis_surat.update', $jenisSurat->id) }}" method="POST" id="jenisSuratForm">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <!-- Kode & Nama -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Kode Surat -->
                                <div>
                                    <label for="kode" class="block text-sm font-medium text-gray-700 mb-1">
                                        Kode Surat <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('kode') border-red-300 @enderror" 
                                           id="kode" 
                                           name="kode" 
                                           value="{{ old('kode', $jenisSurat->kode) }}" 
                                           placeholder="Contoh: SKTM"
                                           required 
                                           maxlength="10">
                                    @error('kode')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">Kode unik untuk jenis surat (maks 10 karakter)</p>
                                </div>

                                <!-- Nama Jenis Surat -->
                                <div>
                                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">
                                        Nama Jenis Surat <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('nama') border-red-300 @enderror" 
                                           id="nama" 
                                           name="nama" 
                                           value="{{ old('nama', $jenisSurat->nama) }}" 
                                           placeholder="Contoh: Surat Keterangan Tidak Mampu"
                                           required>
                                    @error('nama')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Deskripsi -->
                            <div>
                                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">
                                    Deskripsi
                                </label>
                                <textarea class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('deskripsi') border-red-300 @enderror" 
                                          id="deskripsi" 
                                          name="deskripsi" 
                                          rows="3" 
                                          placeholder="Deskripsi jenis surat...">{{ old('deskripsi', $jenisSurat->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Maksimal 500 karakter</p>
                            </div>

                            <!-- Estimasi & Biaya -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Estimasi Proses -->
                                <div>
                                    <label for="estimasi_hari" class="block text-sm font-medium text-gray-700 mb-1">
                                        Estimasi Proses (hari) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('estimasi_hari') border-red-300 @enderror" 
                                           id="estimasi_hari" 
                                           name="estimasi_hari" 
                                           value="{{ old('estimasi_hari', $jenisSurat->estimasi_hari) }}" 
                                           min="1" 
                                           max="30" 
                                           required>
                                    @error('estimasi_hari')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">Estimasi lama proses dalam hari (1-30)</p>
                                </div>

                                <!-- Biaya -->
                                <div>
                                    <label for="biaya" class="block text-sm font-medium text-gray-700 mb-1">
                                        Biaya (Rp) <span class="text-red-500">*</span>
                                    </label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">Rp</span>
                                        </div>
                                        <input type="number" 
                                               class="block w-full pl-10 pr-3 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('biaya') border-red-300 @enderror" 
                                               id="biaya" 
                                               name="biaya" 
                                               value="{{ old('biaya', $jenisSurat->biaya) }}" 
                                               min="0" 
                                               required>
                                    </div>
                                    @error('biaya')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">Biaya administrasi (0 untuk gratis)</p>
                                </div>
                            </div>

                            <!-- Persyaratan Section -->
                            <div x-data="{ persyaratanCount: {{ $counter ?? 1 }} }">
                                <div class="border rounded-lg overflow-hidden">
                                    <!-- Card Header -->
                                    <div class="bg-gray-50 px-4 py-3 border-b">
                                        <h4 class="text-sm font-medium text-gray-900">
                                            <i class="fas fa-list-check mr-2 text-blue-600"></i>Persyaratan <span class="text-red-500">*</span>
                                        </h4>
                                        <p class="text-xs text-gray-600 mt-1">Tambahkan field yang diperlukan untuk pengajuan surat</p>
                                    </div>

                                    <!-- Card Body -->
                                    <div class="p-4">
                                        <div id="persyaratan-container">
                                            @php
                                                $persyaratan = json_decode($jenisSurat->persyaratan, true);
                                                $counter = 0;
                                            @endphp
                                            
                                            @if($persyaratan && count($persyaratan) > 0)
                                                @foreach($persyaratan as $index => $syarat)
                                                    <div class="persyaratan-item mb-4 p-4 border rounded-lg bg-gray-50">
                                                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                                                            <!-- Field Name -->
                                                            <div>
                                                                <label class="block text-xs font-medium text-gray-700 mb-1">
                                                                    Field Name
                                                                </label>
                                                                <input type="text" 
                                                                       name="persyaratan[{{ $counter }}][field]" 
                                                                       class="field-name w-full text-sm rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                                                       value="{{ $syarat['field'] }}" 
                                                                       required>
                                                                <p class="mt-1 text-xs text-gray-500">nama_field (tanpa spasi)</p>
                                                            </div>

                                                            <!-- Label Display -->
                                                            <div>
                                                                <label class="block text-xs font-medium text-gray-700 mb-1">
                                                                    Label Display
                                                                </label>
                                                                <input type="text" 
                                                                       name="persyaratan[{{ $counter }}][label]" 
                                                                       class="w-full text-sm rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                                                       value="{{ $syarat['label'] }}" 
                                                                       required>
                                                                <p class="mt-1 text-xs text-gray-500">Label yang ditampilkan</p>
                                                            </div>

                                                            <!-- Tipe Input -->
                                                            <div>
                                                                <label class="block text-xs font-medium text-gray-700 mb-1">
                                                                    Tipe Input
                                                                </label>
                                                                <select name="persyaratan[{{ $counter }}][type]" 
                                                                        class="w-full text-sm rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                                                        required>
                                                                    <option value="text" {{ $syarat['type'] == 'text' ? 'selected' : '' }}>Text</option>
                                                                    <option value="number" {{ $syarat['type'] == 'number' ? 'selected' : '' }}>Number</option>
                                                                    <option value="date" {{ $syarat['type'] == 'date' ? 'selected' : '' }}>Date</option>
                                                                    <option value="file" {{ $syarat['type'] == 'file' ? 'selected' : '' }}>File Upload</option>
                                                                </select>
                                                            </div>

                                                            <!-- Wajib? -->
                                                            <div>
                                                                <label class="block text-xs font-medium text-gray-700 mb-1">
                                                                    Wajib?
                                                                </label>
                                                                <select name="persyaratan[{{ $counter }}][required]" 
                                                                        class="w-full text-sm rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                                                        required>
                                                                    <option value="1" {{ $syarat['required'] ? 'selected' : '' }}>Ya</option>
                                                                    <option value="0" {{ !$syarat['required'] ? 'selected' : '' }}>Tidak</option>
                                                                </select>
                                                            </div>

                                                            <!-- Remove Button -->
                                                            <div class="flex items-end">
                                                                <button type="button" 
                                                                        class="remove-field inline-flex items-center px-3 py-2 bg-red-100 border border-transparent rounded-md text-xs text-red-700 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                                                    <i class="fas fa-trash mr-1"></i> Hapus
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @php $counter++; @endphp
                                                @endforeach
                                            @else
                                                <!-- Default field if no requirements -->
                                                <div class="persyaratan-item mb-4 p-4 border rounded-lg bg-gray-50">
                                                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                                                        <!-- Field Name -->
                                                        <div>
                                                            <label class="block text-xs font-medium text-gray-700 mb-1">
                                                                Field Name
                                                            </label>
                                                            <input type="text" 
                                                                   name="persyaratan[0][field]" 
                                                                   class="field-name w-full text-sm rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                                                   placeholder="nama_ktp" 
                                                                   required>
                                                            <p class="mt-1 text-xs text-gray-500">nama_field (tanpa spasi)</p>
                                                        </div>

                                                        <!-- Label Display -->
                                                        <div>
                                                            <label class="block text-xs font-medium text-gray-700 mb-1">
                                                                Label Display
                                                            </label>
                                                            <input type="text" 
                                                                   name="persyaratan[0][label]" 
                                                                   class="w-full text-sm rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                                                   placeholder="Nama sesuai KTP" 
                                                                   required>
                                                            <p class="mt-1 text-xs text-gray-500">Label yang ditampilkan</p>
                                                        </div>

                                                        <!-- Tipe Input -->
                                                        <div>
                                                            <label class="block text-xs font-medium text-gray-700 mb-1">
                                                                Tipe Input
                                                            </label>
                                                            <select name="persyaratan[0][type]" 
                                                                    class="w-full text-sm rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                                                    required>
                                                                <option value="text">Text</option>
                                                                <option value="number">Number</option>
                                                                <option value="date">Date</option>
                                                                <option value="file">File Upload</option>
                                                            </select>
                                                        </div>

                                                        <!-- Wajib? -->
                                                        <div>
                                                            <label class="block text-xs font-medium text-gray-700 mb-1">
                                                                Wajib?
                                                            </label>
                                                            <select name="persyaratan[0][required]" 
                                                                    class="w-full text-sm rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                                                    required>
                                                                <option value="1">Ya</option>
                                                                <option value="0">Tidak</option>
                                                            </select>
                                                        </div>

                                                        <!-- Remove Button -->
                                                        <div class="flex items-end">
                                                            <button type="button" 
                                                                    class="remove-field inline-flex items-center px-3 py-2 bg-red-100 border border-transparent rounded-md text-xs text-red-700 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                                                <i class="fas fa-trash mr-1"></i> Hapus
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Add More Button -->
                                        <button type="button" 
                                                @click="persyaratanCount++; addPersyaratanField(persyaratanCount)" 
                                                class="inline-flex items-center px-4 py-2 bg-blue-100 border border-transparent rounded-md text-sm text-blue-700 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                            <i class="fas fa-plus mr-2"></i>Tambah Field
                                        </button>

                                        @error('persyaratan')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                                <a href="{{ route('admin.jenis_surat.show', $jenisSurat->id) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-gray-100 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:bg-gray-200 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <i class="fas fa-times mr-2"></i>Batal
                                </a>
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <i class="fas fa-save mr-2"></i>Update Jenis Surat
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
        let persyaratanCounter = {{ $counter ?? 1 }};

        // Function to add new persyaratan field
        function addPersyaratanField(counter) {
            const html = `
                <div class="persyaratan-item mb-4 p-4 border rounded-lg bg-gray-50">
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <div>
                            <input type="text" 
                                   name="persyaratan[${counter}][field]" 
                                   class="field-name w-full text-sm rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                   placeholder="field_name" 
                                   required>
                            <p class="mt-1 text-xs text-gray-500">nama_field (tanpa spasi)</p>
                        </div>
                        <div>
                            <input type="text" 
                                   name="persyaratan[${counter}][label]" 
                                   class="w-full text-sm rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                   placeholder="Label Display" 
                                   required>
                        </div>
                        <div>
                            <select name="persyaratan[${counter}][type]" 
                                    class="w-full text-sm rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                    required>
                                <option value="text">Text</option>
                                <option value="number">Number</option>
                                <option value="date">Date</option>
                                <option value="file">File Upload</option>
                            </select>
                        </div>
                        <div>
                            <select name="persyaratan[${counter}][required]" 
                                    class="w-full text-sm rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                    required>
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="button" 
                                    class="remove-field inline-flex items-center px-3 py-2 bg-red-100 border border-transparent rounded-md text-xs text-red-700 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                <i class="fas fa-trash mr-1"></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            document.getElementById('persyaratan-container').insertAdjacentHTML('beforeend', html);
        }

        // Auto format field name
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('field-name')) {
                let value = e.target.value;
                value = value.toLowerCase().replace(/[^a-z0-9_]/g, '_');
                e.target.value = value;
            }
        });

        // Remove persyaratan field
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-field') || e.target.closest('.remove-field')) {
                const persyaratanItem = e.target.closest('.persyaratan-item');
                const allItems = document.querySelectorAll('.persyaratan-item');
                
                if (allItems.length > 1) {
                    persyaratanItem.remove();
                } else {
                    alert('Minimal harus ada 1 persyaratan');
                }
            }
        });

        // Form validation
        document.getElementById('jenisSuratForm').addEventListener('submit', function(e) {
            const persyaratanItems = document.querySelectorAll('.persyaratan-item');
            
            if (persyaratanItems.length === 0) {
                e.preventDefault();
                alert('Minimal 1 persyaratan diperlukan');
                return false;
            }
            
            // Validasi setiap field
            let isValid = true;
            persyaratanItems.forEach((item, index) => {
                const fieldInput = item.querySelector('input[name*="[field]"]');
                const labelInput = item.querySelector('input[name*="[label]"]');
                
                if (!fieldInput.value.trim() || !labelInput.value.trim()) {
                    isValid = false;
                    fieldInput.classList.add('border-red-300');
                    labelInput.classList.add('border-red-300');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Harap isi semua field persyaratan');
                return false;
            }
            
            return true;
        });
    </script>
    @endpush
</x-app-layout>