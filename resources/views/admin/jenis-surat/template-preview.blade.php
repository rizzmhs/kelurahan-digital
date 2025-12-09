<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Preview Template: {{ $jenisSurat->nama }}
            </h2>
            <a href="{{ route('admin.jenis_surat.show', $jenisSurat->id) }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Preview -->
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Preview PDF</h3>
                            
                            <!-- Preview Content -->
                            <div class="bg-gray-50 p-8 rounded border border-gray-200 min-h-96">
                                <div class="max-w-3xl mx-auto bg-white p-8 shadow">
                                    <div style="font-family: DejaVu Sans, sans-serif; line-height: 1.6;">
                                        <!-- Header -->
                                        <div style="text-align: center; margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 10px;">
                                            <h2 style="margin: 0; font-size: 16px; font-weight: bold;">{{ $jenisSurat->nama }}</h2>
                                            <p style="margin: 5px 0; font-size: 12px;">Nomor: {{ $surat->nomor_surat }} | Tanggal: {{ $tanggal }}</p>
                                        </div>

                                        <!-- Content -->
                                        <p style="margin-bottom: 15px;">Yang bertanda tangan di bawah ini menerangkan bahwa:</p>
                                        
                                        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                                            @foreach($dummyData as $key => $value)
                                                @if(!is_array($value) && !empty($value))
                                                    <tr>
                                                        <td style="padding: 5px 10px; border: 1px solid #ddd; font-weight: bold; width: 40%;">
                                                            {{ ucwords(str_replace('_', ' ', $key)) }}
                                                        </td>
                                                        <td style="padding: 5px 10px; border: 1px solid #ddd;">
                                                            {{ $value }}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </table>

                                        <!-- Footer -->
                                        <p style="margin-top: 30px;">Demikian surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya.</p>
                                        
                                        <div style="margin-top: 40px; display: grid; grid-template-columns: 1fr 1fr; gap: 40px;">
                                            <div style="text-align: center;">
                                                <p style="margin-bottom: 60px;">Mengetahui,</p>
                                                <p style="border-top: 1px solid #000; padding-top: 5px;">Kepala Kelurahan</p>
                                            </div>
                                            <div style="text-align: center;">
                                                <p style="margin-bottom: 60px;">Pemohon,</p>
                                                <p style="border-top: 1px solid #000; padding-top: 5px;">{{ $dummyData['nama'] ?? 'Nama Pemohon' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded">
                                <p class="text-sm text-blue-800">
                                    <strong>Catatan:</strong> Ini adalah preview dengan data dummy. Template sebenarnya akan menampilkan data yang sesuai dengan file view di 
                                    <code class="bg-blue-100 px-2 py-1 rounded">resources/views/surat/templates/{{ $templateName }}.blade.php</code>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Info -->
                <div class="space-y-4">
                    <!-- Jenis Surat Info -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4">Informasi</h4>
                            <div class="space-y-3 text-sm">
                                <div>
                                    <label class="text-gray-600 font-medium">Nama Jenis Surat</label>
                                    <p class="text-gray-900">{{ $jenisSurat->nama }}</p>
                                </div>
                                <div>
                                    <label class="text-gray-600 font-medium">Kode</label>
                                    <p class="text-gray-900">{{ $jenisSurat->kode }}</p>
                                </div>
                                <div>
                                    <label class="text-gray-600 font-medium">Template File</label>
                                    <p class="text-gray-900 font-mono text-xs">{{ $templateName }}.blade.php</p>
                                </div>
                                <div>
                                    <label class="text-gray-600 font-medium">Estimasi Hari</label>
                                    <p class="text-gray-900">{{ $jenisSurat->estimasi_hari }} hari</p>
                                </div>
                                <div>
                                    <label class="text-gray-600 font-medium">Biaya</label>
                                    <p class="text-gray-900">Rp {{ number_format($jenisSurat->biaya, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Template Status -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4">Status Template</h4>
                            <div class="space-y-2 text-sm">
                                @php
                                    $templateExists = in_array($templateName, $availableTemplates);
                                @endphp
                                @if($templateExists)
                                    <div class="flex items-center p-3 bg-green-50 rounded border border-green-200">
                                        <i class="fas fa-check-circle text-green-600 mr-2"></i>
                                        <span class="text-green-800"><strong>Template Ditemukan</strong></span>
                                    </div>
                                @else
                                    <div class="flex items-center p-3 bg-yellow-50 rounded border border-yellow-200">
                                        <i class="fas fa-exclamation-circle text-yellow-600 mr-2"></i>
                                        <span class="text-yellow-800"><strong>Template Tidak Ditemukan</strong></span>
                                    </div>
                                    <p class="text-gray-600 mt-2">Template akan dibuat ketika Anda mengedit jenis surat ini dan mengatur template custom.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Available Templates -->
                    @if(count($availableTemplates) > 0)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 bg-white border-b border-gray-200">
                                <h4 class="text-lg font-semibold text-gray-800 mb-4">Template Tersedia</h4>
                                <div class="space-y-2 text-sm">
                                    @foreach($availableTemplates as $template)
                                        <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                                            <span class="{{ $templateName == $template ? 'font-bold text-blue-600' : 'text-gray-700' }}">
                                                {{ $template }}
                                            </span>
                                            @if($templateName == $template)
                                                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">Current</span>
                                            @else
                                                <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">Tersedia</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
