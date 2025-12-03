<x-app-layout>
    @php
        $title = 'Template Tidak Ditemukan';
    @endphp
    
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fas fa-exclamation-triangle mr-2 text-yellow-600"></i>Template Tidak Ditemukan
            </h2>
            <a href="{{ route('admin.jenis_surat.show', $jenisSurat->id) }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-yellow-100 rounded-full mb-4">
                            <i class="fas fa-exclamation-triangle text-yellow-600 text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">
                            Template Tidak Ditemukan
                        </h3>
                        <p class="text-gray-600">
                            Template untuk jenis surat ini tidak tersedia di sistem.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Informasi Jenis Surat -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4">
                                <i class="fas fa-info-circle mr-2 text-blue-600"></i>Informasi Jenis Surat
                            </h4>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Nama Jenis Surat</label>
                                    <p class="font-semibold text-gray-900">{{ $jenisSurat->nama }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Kode</label>
                                    <p class="font-semibold text-gray-900">{{ $jenisSurat->kode }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Template yang Dicari</label>
                                    <p class="font-semibold text-red-600">{{ $templateName }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Template yang Tersedia -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4">
                                <i class="fas fa-list mr-2 text-green-600"></i>Template yang Tersedia
                            </h4>
                            <div class="space-y-2">
                                @foreach($availableTemplates as $template)
                                    <div class="flex items-center justify-between p-3 bg-white rounded border">
                                        <span class="font-medium {{ $templateName == $template ? 'text-blue-600' : 'text-gray-700' }}">
                                            {{ $template }}
                                        </span>
                                        @if($templateName == $template)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Tidak Ditemukan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Tersedia
                                            </span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Lokasi yang Dicari -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">
                            <i class="fas fa-search mr-2 text-purple-600"></i>Lokasi Template yang Dicari
                        </h4>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <ul class="space-y-2">
                                @foreach($viewPaths as $path)
                                    <li class="flex items-center p-3 bg-white rounded border">
                                        <i class="fas {{ view()->exists($path) ? 'fa-check text-green-600' : 'fa-times text-red-600' }} mr-3"></i>
                                        <code class="text-sm {{ view()->exists($path) ? 'text-green-700' : 'text-red-700' }}">
                                            resources/views/{{ str_replace('.', '/', $path) }}.blade.php
                                        </code>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Data Dummy -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">
                            <i class="fas fa-database mr-2 text-indigo-600"></i>Data Dummy untuk Preview
                        </h4>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Field</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Value</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($dummyData as $key => $value)
                                            <tr>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ $key }}</td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $value }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.jenis_surat.edit.template', $jenisSurat->id) }}" 
                           class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <i class="fas fa-edit mr-3"></i>Ubah Template
                        </a>
                        
                        <a href="{{ route('admin.jenis_surat.edit', $jenisSurat->id) }}" 
                           class="inline-flex items-center px-6 py-3 bg-yellow-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-yellow-700 focus:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <i class="fas fa-cog mr-3"></i>Edit Jenis Surat
                        </a>
                        
                        <a href="{{ route('admin.jenis_surat.index') }}" 
                           class="inline-flex items-center px-6 py-3 bg-gray-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <i class="fas fa-list mr-3"></i>Daftar Jenis Surat
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>