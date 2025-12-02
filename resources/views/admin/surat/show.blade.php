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
                    <!-- Header & Actions -->
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $surat->jenisSurat->nama }}</h1>
                            <p class="text-gray-600 mt-1">Nomor: {{ $surat->nomor_surat ?? 'Belum ada nomor' }}</p>
                        </div>
                        <div>
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
                                        $persyaratan = json_decode($surat->jenisSurat->persyaratan, true);
                                    @endphp
                                    @foreach($persyaratan as $syarat)
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

                            <!-- Management Actions -->
                            <div class="bg-white border border-gray-200 rounded-lg p-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Kelola Pengajuan Surat</h3>
                                
                                <!-- Status Update -->
                                <form action="{{ route('admin.surat.update.status', $surat) }}" method="POST" class="mb-4">
                                    @csrf
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="status" class="block text-sm font-medium text-gray-700">Ubah Status</label>
                                            <select id="status" name="status" required
                                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                                <option value="draft" {{ $surat->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                                <option value="diajukan" {{ $surat->status == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                                                <option value="diproses" {{ $surat->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                                <option value="siap_ambil" {{ $surat->status == 'siap_ambil' ? 'selected' : '' }}>Siap Diambil</option>
                                                <option value="selesai" {{ $surat->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                                <option value="ditolak" {{ $surat->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                            </select>
                                        </div>
                                        <div class="flex items-end">
                                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md text-sm font-medium">
                                                Update Status
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                                        <textarea id="catatan" name="catatan" rows="3"
                                                  class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                  placeholder="Berikan catatan untuk status ini...">{{ old('catatan') }}</textarea>
                                    </div>
                                </form>

                                <!-- Quick Actions -->
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-2">
                                    @if($surat->status === 'diajukan')
                                    <form action="{{ route('admin.surat.verifikasi', $surat) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-3 rounded-md text-sm font-medium">
                                            Verifikasi
                                        </button>
                                    </form>
                                    @endif

                                    @if($surat->status === 'diproses')
                                    <form action="{{ route('admin.surat.proses', $surat) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-3 rounded-md text-sm font-medium">
                                            Proses
                                        </button>
                                    </form>
                                    @endif

                                    @if(in_array($surat->status, ['diproses', 'siap_ambil']))
                                    <form action="{{ route('admin.surat.siap.ambil', $surat) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-3 rounded-md text-sm font-medium">
                                            Siap Diambil
                                        </button>
                                    </form>
                                    @endif

                                    @if($surat->status === 'siap_ambil')
                                    <form action="{{ route('admin.surat.selesai', $surat) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-3 rounded-md text-sm font-medium">
                                            Selesai
                                        </button>
                                    </form>
                                    @endif
                                </div>

                                <!-- Generate PDF -->
                                @if(in_array($surat->status, ['diproses', 'siap_ambil', 'selesai']))
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <form action="{{ route('admin.surat.generate.pdf', $surat) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white py-2 px-4 rounded-md text-sm font-medium">
                                            Generate PDF Surat
                                        </button>
                                    </form>
                                    @if($surat->file_surat)
                                    <div class="mt-2 flex space-x-2">
                                        <a href="{{ route('admin.surat.preview', $surat) }}" target="_blank" 
                                           class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md text-sm font-medium text-center">
                                            Preview Surat
                                        </a>
                                    </div>
                                    @endif
                                </div>
                                @endif

                                <!-- Reject Form -->
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <form action="{{ route('admin.surat.tolak', $surat) }}" method="POST">
                                        @csrf
                                        <div class="flex space-x-2">
                                            <input type="text" name="catatan" required
                                                   class="flex-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                   placeholder="Alasan penolakan...">
                                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-md text-sm font-medium" 
                                                    onclick="return confirm('Apakah Anda yakin ingin menolak pengajuan surat ini?')">
                                                Tolak
                                            </button>
                                        </div>
                                    </form>
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

                            <!-- Informasi Pemohon -->
                            <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                                <h3 class="text-lg font-medium text-gray-900 mb-3">Informasi Pemohon</h3>
                                <div class="flex items-center mb-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-semibold">
                                            {{ substr($surat->user->name, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $surat->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $surat->user->email }}</p>
                                    </div>
                                </div>
                                <dl class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <dt class="text-gray-600">NIK:</dt>
                                        <dd class="text-gray-900">{{ $surat->user->nik }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-gray-600">Telepon:</dt>
                                        <dd class="text-gray-900">{{ $surat->user->telepon }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-gray-600">Alamat:</dt>
                                        <dd class="text-gray-900">{{ $surat->user->alamat }}</dd>
                                    </div>
                                </dl>
                            </div>

                            <!-- Action Buttons -->
                            <div class="space-y-3">
                                <a href="{{ route('admin.surat.index') }}" class="w-full bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded-md text-sm font-medium text-center block">
                                    Kembali ke Daftar
                                </a>
                                
                                @if($surat->file_surat)
                                <a href="{{ route('admin.surat.preview', $surat) }}" target="_blank" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-md text-sm font-medium text-center block">
                                    Preview Surat
                                </a>
                                @endif

                                <form action="{{ route('admin.surat.destroy', $surat) }}" method="POST" class="w-full">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-md text-sm font-medium" 
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus pengajuan surat ini?')">
                                        Hapus Surat
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>