<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Pengajuan Surat - {{ $surat->nomor_surat ?? 'Belum ada nomor' }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Header -->
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $surat->jenisSurat->nama }}</h1>
                            <p class="text-gray-600 mt-1">Nomor: {{ $surat->nomor_surat ?? 'Belum ada nomor' }}</p>
                        </div>
                        <div class="text-right">
                            @php
                                $statusClasses = [
                                    'draft' => 'bg-gray-100 text-gray-800',
                                    'diajukan' => 'bg-yellow-100 text-yellow-800',
                                    'diproses' => 'bg-blue-100 text-blue-800',
                                    'siap_ambil' => 'bg-green-100 text-green-800',
                                    'selesai' => 'bg-green-100 text-green-800',
                                    'ditolak' => 'bg-red-100 text-red-800'
                                ];
                            @endphp
                            <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $statusClasses[$surat->status] }}">
                                {{ str_replace('_', ' ', ucfirst($surat->status)) }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Main Content -->
                        <div class="lg:col-span-2 space-y-6">
                            <!-- Data Pengajuan -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-3">Data Pengajuan</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @php
                                        $dataPengajuan = $surat->data_pengajuan;
                                    @endphp
                                    @foreach(json_decode($surat->jenisSurat->persyaratan, true) as $syarat)
                                    <div>
                                        <label class="text-sm font-medium text-gray-600">{{ $syarat['label'] }}</label>
                                        @if($syarat['type'] === 'file')
                                            <p class="text-sm text-gray-900 mt-1">
                                                @if(isset($surat->file_persyaratan[$syarat['field']]))
                                                    <a href="{{ Storage::url($surat->file_persyaratan[$syarat['field']]) }}" 
                                                       target="_blank" 
                                                       class="text-blue-600 hover:text-blue-900 flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                        </svg>
                                                        Lihat File
                                                    </a>
                                                @else
                                                    <span class="text-gray-500">File tidak tersedia</span>
                                                @endif
                                            </p>
                                        @else
                                            <p class="text-sm text-gray-900 mt-1">{{ $dataPengajuan[$syarat['field']] ?? '-' }}</p>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Riwayat Status -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-3">Riwayat Status</h3>
                                <div class="space-y-4">
                                    @foreach($surat->riwayat as $riwayat)
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-3 flex-1">
                                            <div class="flex items-center justify-between">
                                                <p class="text-sm font-medium text-gray-900">
                                                    {{ str_replace('_', ' ', ucfirst($riwayat->status)) }}
                                                </p>
                                                <span class="text-xs text-gray-500">{{ $riwayat->created_at->format('d M Y H:i') }}</span>
                                            </div>
                                            <p class="text-sm text-gray-600 mt-1">{{ $riwayat->catatan }}</p>
                                            @if($riwayat->user)
                                            <p class="text-xs text-gray-500 mt-1">Oleh: {{ $riwayat->user->name }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="space-y-6">
                            <!-- Informasi Surat -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-3">Informasi Surat</h3>
                                <dl class="space-y-2">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-600">Jenis Surat</dt>
                                        <dd class="text-sm text-gray-900">{{ $surat->jenisSurat->nama }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-600">Tanggal Pengajuan</dt>
                                        <dd class="text-sm text-gray-900">{{ $surat->created_at->format('d F Y H:i') }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-600">Estimasi Selesai</dt>
                                        <dd class="text-sm text-gray-900">
                                            {{ $surat->created_at->addDays($surat->jenisSurat->estimasi_hari)->format('d F Y') }}
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-600">Biaya</dt>
                                        <dd class="text-sm text-gray-900">Rp {{ number_format($surat->jenisSurat->biaya, 0, ',', '.') }}</dd>
                                    </div>
                                </dl>
                            </div>

                            <!-- Action Buttons -->
                            <div class="space-y-3">
                                @if($surat->status === 'draft')
                                <form action="{{ route('warga.surat.ajukan.verifikasi', $surat) }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-md text-sm font-medium">
                                        Ajukan Verifikasi
                                    </button>
                                </form>
                                @endif

                                @if($surat->status === 'siap_ambil' && $surat->file_surat)
                                <a href="{{ route('warga.surat.download', $surat) }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md text-sm font-medium text-center block">
                                    Download Surat
                                </a>
                                @endif

                                @if(in_array($surat->status, ['draft', 'ditolak']))
                                <a href="{{ route('warga.surat.edit', $surat) }}" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white py-2 px-4 rounded-md text-sm font-medium text-center block">
                                    Edit Pengajuan
                                </a>
                                @endif

                                @if($surat->status === 'diajukan')
                                <form action="{{ route('warga.surat.batalkan', $surat) }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-md text-sm font-medium" onclick="return confirm('Apakah Anda yakin ingin membatalkan pengajuan?')">
                                        Batalkan Pengajuan
                                    </button>
                                </form>
                                @endif

                                <a href="{{ route('warga.surat.index') }}" class="w-full bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded-md text-sm font-medium text-center block">
                                    Kembali ke Daftar
                                </a>
                            </div>

                            <!-- Preview Surat -->
                            @if($surat->file_surat)
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <h4 class="text-sm font-medium text-green-800 mb-2">Surat Tersedia</h4>
                                <p class="text-sm text-green-700 mb-3">Surat Anda sudah siap dan dapat diunduh.</p>
                                <a href="{{ route('warga.surat.preview', $surat) }}" target="_blank" class="text-sm text-green-600 hover:text-green-800 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Preview Surat
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>