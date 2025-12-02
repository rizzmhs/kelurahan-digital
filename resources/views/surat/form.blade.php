<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ajukan {{ $jenisSurat->nama }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Progress Steps -->
                    <div class="mb-8">
                        <div class="flex items-center">
                            <div class="flex items-center text-blue-600">
                                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm font-semibold">1</div>
                                <span class="ml-2 text-sm font-medium">Pilih Jenis Surat</span>
                            </div>
                            <div class="flex-1 h-1 bg-blue-600 mx-2"></div>
                            <div class="flex items-center text-blue-600">
                                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm font-semibold">2</div>
                                <span class="ml-2 text-sm font-medium">Isi Formulir</span>
                            </div>
                            <div class="flex-1 h-1 bg-gray-300 mx-2"></div>
                            <div class="flex items-center text-gray-500">
                                <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-gray-500 text-sm font-semibold">3</div>
                                <span class="ml-2 text-sm font-medium">Preview & Submit</span>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('warga.surat.draft.store', $jenisSurat) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="space-y-6">
                            <!-- Informasi Jenis Surat -->
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <h3 class="text-lg font-semibold text-green-800 mb-2">{{ $jenisSurat->nama }}</h3>
                                <p class="text-green-700">{{ $jenisSurat->deskripsi }}</p>
                                <div class="mt-2 flex space-x-4 text-sm text-green-600">
                                    <span>Estimasi: {{ $jenisSurat->estimasi_hari }} hari</span>
                                    <span>Biaya: Rp {{ number_format($jenisSurat->biaya, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <!-- Form Fields -->
                            @php
                                $persyaratan = json_decode($jenisSurat->persyaratan, true);
                            @endphp

                            @foreach($persyaratan as $syarat)
                            <div>
                                <label for="{{ $syarat['field'] }}" class="block text-sm font-medium text-gray-700">
                                    {{ $syarat['label'] }}
                                    @if($syarat['required'])
                                    <span class="text-red-500">*</span>
                                    @endif
                                </label>
                                
                                @if($syarat['type'] === 'file')
                                <div class="mt-1">
                                    <input type="file" 
                                           name="file_{{ $syarat['field'] }}" 
                                           id="{{ $syarat['field'] }}"
                                           {{ $syarat['required'] ? 'required' : '' }}
                                           accept=".pdf,.jpg,.jpeg,.png"
                                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                    <p class="mt-1 text-xs text-gray-500">Format: PDF, JPG, PNG (maks. 5MB)</p>
                                </div>
                                @else
                                <input type="{{ $syarat['type'] }}" 
                                       name="{{ $syarat['field'] }}" 
                                       id="{{ $syarat['field'] }}"
                                       {{ $syarat['required'] ? 'required' : '' }}
                                       class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @endif
                                
                                @error($syarat['type'] === 'file' ? "file_{$syarat['field']}" : $syarat['field'])
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            @endforeach

                            <!-- Informasi Tambahan -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <h4 class="text-sm font-medium text-blue-800 mb-2">Persyaratan yang Perlu Disiapkan:</h4>
                                <ul class="text-sm text-blue-700 space-y-1">
                                    @foreach($persyaratan as $syarat)
                                    <li class="flex items-start">
                                        <svg class="w-4 h-4 text-blue-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        {{ $syarat['label'] }} 
                                        @if($syarat['type'] === 'file')
                                        <span class="text-blue-600 ml-1">(File)</span>
                                        @endif
                                    </li>
                                    @endforeach
                                </ul>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex justify-between pt-6">
                                <a href="{{ route('warga.surat.create') }}" class="bg-gray-600 hover:bg-gray-700 text-white py-2 px-6 rounded-md text-sm font-medium">
                                    Kembali
                                </a>
                                <div class="space-x-3">
                                    <button type="submit" name="action" value="draft" class="bg-yellow-600 hover:bg-yellow-700 text-white py-2 px-6 rounded-md text-sm font-medium">
                                        Simpan Draft
                                    </button>
                                    <button type="submit" name="action" value="submit" class="bg-green-600 hover:bg-green-700 text-white py-2 px-6 rounded-md text-sm font-medium">
                                        Ajukan Sekarang
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>