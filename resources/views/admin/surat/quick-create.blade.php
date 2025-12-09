<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Buat Surat Cepat (Admin)
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if($errors->any())
                        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded">
                            <ul class="text-sm text-red-600 list-disc pl-5">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form id="quickCreateForm" action="{{ route('admin.surat.quick.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Warga <span class="text-red-500">*</span></label>
                                <select id="user_id" name="user_id" required class="mt-1 block w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">-- Pilih Warga --</option>
                                    @foreach($users as $u)
                                        <option value="{{ $u->id }}" {{ old('user_id') == $u->id ? 'selected' : '' }}>
                                            {{ $u->name }} ({{ $u->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="jenis_surat_id" class="block text-sm font-medium text-gray-700 mb-1">Jenis Surat <span class="text-red-500">*</span></label>
                                <select id="jenis_surat_id" name="jenis_surat_id" required class="mt-1 block w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">-- Pilih Jenis Surat --</option>
                                    @foreach($jenisSurat as $j)
                                        <option value="{{ $j->id }}" data-template="{{ $j->template }}" {{ old('jenis_surat_id') == $j->id ? 'selected' : '' }}>
                                            {{ $j->nama }} ({{ $j->kode }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Dynamic Fields Container -->
                        <div id="dynamicFields" class="mb-4 p-4 bg-gray-50 rounded border border-gray-200">
                            <p class="text-gray-500 text-sm">Pilih jenis surat untuk menampilkan field yang diperlukan...</p>
                        </div>

                        <div class="flex items-center space-x-4 mb-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="generate_pdf" value="1" class="rounded border-gray-300" {{ old('generate_pdf') ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700">Generate PDF langsung setelah membuat</span>
                            </label>
                        </div>

                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('admin.surat.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded-md text-sm font-medium">
                                Batal
                            </a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md text-sm font-medium">
                                Buat Surat
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const jenisSuratSelect = document.getElementById('jenis_surat_id');
        const dynamicFieldsContainer = document.getElementById('dynamicFields');
        
        // Sample persyaratan data for each jenis surat
        const jenisSuratData = @json($jenisSurat->keyBy('id')->map(fn($j) => [
            'id' => $j->id,
            'nama' => $j->nama,
            'persyaratan' => json_decode($j->persyaratan, true) ?? []
        ]).values());

        function renderDynamicFields() {
            const selectedId = jenisSuratSelect.value;
            
            if (!selectedId) {
                dynamicFieldsContainer.innerHTML = '<p class="text-gray-500 text-sm">Pilih jenis surat untuk menampilkan field yang diperlukan...</p>';
                return;
            }

            const selectedJenis = jenisSuratData.find(j => j.id == selectedId);
            if (!selectedJenis) return;

            const persyaratan = selectedJenis.persyaratan;
            let html = '<div class="space-y-4">';

            if (persyaratan.length === 0) {
                html += '<p class="text-gray-600 text-sm">Tidak ada field tambahan untuk jenis surat ini.</p>';
            } else {
                persyaratan.forEach(field => {
                    const required = field.required ? '<span class="text-red-500">*</span>' : '';
                    const requiredAttr = field.required ? 'required' : '';

                    if (field.type === 'file') {
                        html += `
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    ${field.label} ${required}
                                </label>
                                <input type="file" name="file[${field.field}]" ${requiredAttr} 
                                       class="mt-1 block w-full border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-sm">
                                <p class="text-xs text-gray-500 mt-1">Maksimal 5MB (pdf, jpg, jpeg, png)</p>
                            </div>
                        `;
                    } else if (field.type === 'textarea') {
                        html += `
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    ${field.label} ${required}
                                </label>
                                <textarea name="data[${field.field}]" ${requiredAttr} rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm"></textarea>
                            </div>
                        `;
                    } else if (field.type === 'date') {
                        html += `
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    ${field.label} ${required}
                                </label>
                                <input type="date" name="data[${field.field}]" ${requiredAttr}
                                       class="mt-1 block w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            </div>
                        `;
                    } else if (field.type === 'number') {
                        html += `
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    ${field.label} ${required}
                                </label>
                                <input type="number" name="data[${field.field}]" ${requiredAttr}
                                       class="mt-1 block w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            </div>
                        `;
                    } else {
                        html += `
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    ${field.label} ${required}
                                </label>
                                <input type="text" name="data[${field.field}]" ${requiredAttr}
                                       class="mt-1 block w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            </div>
                        `;
                    }
                });
            }

            html += '</div>';
            dynamicFieldsContainer.innerHTML = html;
        }

        jenisSuratSelect.addEventListener('change', renderDynamicFields);

        // Initial render jika ada data lama
        if (jenisSuratSelect.value) {
            renderDynamicFields();
        }
    </script>
</x-app-layout>
