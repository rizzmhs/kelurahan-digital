<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <a href="{{ route('petugas.surat.index') }}" class="text-blue-600 hover:text-blue-900 mr-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        <i class="fas fa-envelope mr-2 text-blue-600"></i>Detail Surat
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Nomor: {{ $surat->nomor_surat ?? 'Belum ada nomor' }}</p>
                </div>
            </div>
            <div class="flex space-x-2">
                @if($surat->file_surat)
                    <a href="{{ route('petugas.surat.preview', $surat) }}" target="_blank" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-eye mr-2"></i>Preview PDF
                    </a>
                @endif
                <a href="{{ route('petugas.surat.riwayat', $surat) }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    <i class="fas fa-history mr-2"></i>Riwayat
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert-auto-hide bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="alert-auto-hide bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column - Surat Info -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Status Card -->
                    <div class="bg-white shadow rounded-lg p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Status Surat</h3>
                            <div class="text-sm text-gray-500">
                                ID: #{{ $surat->id }}
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-4">
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                                    @if($surat->status == 'draft') bg-gray-100 text-gray-800
                                    @elseif($surat->status == 'diajukan') bg-yellow-100 text-yellow-800
                                    @elseif($surat->status == 'diproses') bg-purple-100 text-purple-800
                                    @elseif($surat->status == 'siap_ambil') bg-green-100 text-green-800
                                    @elseif($surat->status == 'selesai') bg-blue-100 text-blue-800
                                    @elseif($surat->status == 'ditolak') bg-red-100 text-red-800
                                    @endif">
                                    <i class="fas fa-circle text-xs mr-1"></i>
                                    {{ $surat->status_display ?? ucfirst($surat->status) }}
                                </span>
                                
                                @if($surat->file_surat)
                                    <span class="px-2 py-1 inline-flex text-xs leading-4 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        <i class="fas fa-file-pdf mr-1"></i>PDF Tersedia
                                    </span>
                                @endif
                                
                                @if($surat->isVerified())
                                    <span class="px-2 py-1 inline-flex text-xs leading-4 font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>Terverifikasi
                                    </span>
                                @endif
                            </div>
                            <div class="text-sm text-gray-500">
                                Terakhir diupdate: {{ $surat->updated_at->format('d/m/Y H:i') }}
                            </div>
                        </div>

                        <!-- Timeline Status -->
                        <div class="mt-4">
                            <div class="flex items-center justify-between text-xs text-gray-500 mb-1">
                                <div class="text-center {{ $surat->status == 'diajukan' ? 'text-yellow-600 font-medium' : '' }}">
                                    <div class="w-8 h-8 rounded-full border-2 flex items-center justify-center mx-auto mb-1
                                        @if($surat->status == 'diajukan') border-yellow-600 bg-yellow-50
                                        @elseif(in_array($surat->status, ['diproses', 'siap_ambil', 'selesai', 'ditolak'])) border-green-600 bg-green-50 text-green-600
                                        @else border-gray-300 @endif">
                                        <i class="fas fa-paper-plane text-xs"></i>
                                    </div>
                                    Diajukan
                                    @if($surat->tanggal_verifikasi)
                                        <div class="text-xs mt-1">{{ $surat->tanggal_verifikasi->format('d/m') }}</div>
                                    @endif
                                </div>
                                
                                <div class="flex-1 h-1 mx-2
                                    @if(in_array($surat->status, ['diproses', 'siap_ambil', 'selesai'])) bg-green-600
                                    @else bg-gray-200 @endif">
                                </div>
                                
                                <div class="text-center {{ $surat->status == 'diproses' ? 'text-purple-600 font-medium' : '' }}">
                                    <div class="w-8 h-8 rounded-full border-2 flex items-center justify-center mx-auto mb-1
                                        @if($surat->status == 'diproses') border-purple-600 bg-purple-50
                                        @elseif(in_array($surat->status, ['siap_ambil', 'selesai'])) border-green-600 bg-green-50 text-green-600
                                        @else border-gray-300 @endif">
                                        <i class="fas fa-cog text-xs"></i>
                                    </div>
                                    Diproses
                                    @if($surat->tanggal_proses)
                                        <div class="text-xs mt-1">{{ $surat->tanggal_proses->format('d/m') }}</div>
                                    @endif
                                </div>
                                
                                <div class="flex-1 h-1 mx-2
                                    @if(in_array($surat->status, ['siap_ambil', 'selesai'])) bg-green-600
                                    @else bg-gray-200 @endif">
                                </div>
                                
                                <div class="text-center {{ $surat->status == 'siap_ambil' ? 'text-green-600 font-medium' : '' }}">
                                    <div class="w-8 h-8 rounded-full border-2 flex items-center justify-center mx-auto mb-1
                                        @if($surat->status == 'siap_ambil') border-green-600 bg-green-50
                                        @elseif($surat->status == 'selesai') border-green-600 bg-green-50 text-green-600
                                        @else border-gray-300 @endif">
                                        <i class="fas fa-check-circle text-xs"></i>
                                    </div>
                                    Siap Ambil
                                    @if($surat->tanggal_siap)
                                        <div class="text-xs mt-1">{{ $surat->tanggal_siap->format('d/m') }}</div>
                                    @endif
                                </div>
                                
                                <div class="flex-1 h-1 mx-2
                                    @if($surat->status == 'selesai') bg-green-600
                                    @else bg-gray-200 @endif">
                                </div>
                                
                                <div class="text-center {{ $surat->status == 'selesai' ? 'text-blue-600 font-medium' : '' }}">
                                    <div class="w-8 h-8 rounded-full border-2 flex items-center justify-center mx-auto mb-1
                                        @if($surat->status == 'selesai') border-blue-600 bg-blue-50
                                        @else border-gray-300 @endif">
                                        <i class="fas fa-archive text-xs"></i>
                                    </div>
                                    Selesai
                                    @if($surat->tanggal_selesai)
                                        <div class="text-xs mt-1">{{ $surat->tanggal_selesai->format('d/m') }}</div>
                                    @endif
                                </div>
                            </div>
                            
                            @if($surat->status == 'ditolak')
                                <div class="mt-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                                    <div class="flex items-center">
                                        <i class="fas fa-times-circle text-red-600 mr-2"></i>
                                        <span class="text-sm font-medium text-red-800">Surat Ditolak</span>
                                    </div>
                                    @if($surat->alasan_penolakan)
                                        <p class="text-sm text-red-700 mt-1">{{ $surat->alasan_penolakan }}</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Data Pemohon -->
                    <div class="bg-white shadow rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            <i class="fas fa-user mr-2 text-blue-600"></i>Data Pemohon
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Nama Lengkap</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $surat->user->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">NIK</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $surat->user->nik ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Tempat, Tanggal Lahir</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $surat->user->tempat_lahir ?? '-' }}, 
                                    {{ $surat->user->tanggal_lahir ? $surat->user->tanggal_lahir->format('d/m/Y') : '-' }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Jenis Kelamin</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    @if($surat->user->jenis_kelamin == 'L')
                                        Laki-laki
                                    @elseif($surat->user->jenis_kelamin == 'P')
                                        Perempuan
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Alamat</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $surat->user->alamat ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Telepon</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $surat->user->telepon ?? '-' }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-500">Email</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $surat->user->email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Data Pengajuan -->
                    <div class="bg-white shadow rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            <i class="fas fa-file-alt mr-2 text-blue-600"></i>Data Pengajuan
                        </h3>
                        
                        <!-- Info Jenis Surat -->
                        <div class="mb-4 p-3 bg-blue-50 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="flex items-center">
                                        <i class="fas fa-tag text-blue-600 mr-2"></i>
                                        <span class="text-sm font-medium text-blue-800">Jenis Surat:</span>
                                        <span class="text-sm text-blue-700 ml-2">{{ $surat->jenisSurat->nama ?? 'Tidak diketahui' }}</span>
                                    </div>
                                    @if($surat->jenisSurat->keterangan ?? false)
                                        <p class="text-xs text-blue-600 mt-1">{{ $surat->jenisSurat->keterangan }}</p>
                                    @endif
                                </div>
                                <span class="text-xs text-gray-500">
                                    Kode: {{ $surat->jenisSurat->kode ?? '-' }}
                                </span>
                            </div>
                        </div>

                        <div class="space-y-3">
                            @if($surat->data_pengajuan && count($surat->data_pengajuan) > 0)
                                @foreach($surat->data_pengisian as $key => $value)
                                    <div class="flex justify-between items-start border-b border-gray-100 pb-3">
                                        <span class="text-sm font-medium text-gray-500 flex-1">
                                            {{ $key }}
                                        </span>
                                        <span class="text-sm text-gray-900 text-right flex-1">
                                            @if(is_array($value))
                                                {{ implode(', ', $value) }}
                                            @elseif(is_bool($value))
                                                {{ $value ? 'Ya' : 'Tidak' }}
                                            @elseif($value instanceof \Carbon\Carbon)
                                                {{ $value->format('d/m/Y') }}
                                            @else
                                                {{ $value ?? '-' }}
                                            @endif
                                        </span>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-info-circle text-gray-400 text-2xl mb-2"></i>
                                    <p class="text-sm text-gray-500">Tidak ada data tambahan.</p>
                                </div>
                            @endif
                        </div>
                        
                        <!-- File Persyaratan -->
                        @if($surat->file_persyaratan && count($surat->file_persyaratan) > 0)
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <h4 class="text-md font-medium text-gray-900 mb-2">
                                    <i class="fas fa-paperclip mr-2"></i>File Persyaratan
                                </h4>
                                <div class="space-y-2">
                                    @foreach($surat->file_persyaratan as $key => $path)
                                        @if($path)
                                            <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                                                <div class="flex items-center">
                                                    <i class="fas fa-file text-gray-400 mr-2"></i>
                                                    <span class="text-sm text-gray-700">{{ $key }}</span>
                                                </div>
                                                <a href="{{ Storage::url($path) }}" target="_blank" 
                                                   class="text-blue-600 hover:text-blue-800 text-sm">
                                                    <i class="fas fa-download mr-1"></i>Download
                                                </a>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Catatan Admin -->
                    @if($surat->catatan_admin)
                    <div class="bg-white shadow rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            <i class="fas fa-sticky-note mr-2 text-blue-600"></i>Catatan Admin/Petugas
                        </h3>
                        <div class="p-3 bg-yellow-50 border-l-4 border-yellow-400 rounded">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle text-yellow-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700 whitespace-pre-line">{{ $surat->catatan_admin }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Right Column - Actions -->
                <div class="space-y-6">
                    <!-- Quick Actions -->
                    <div class="bg-white shadow rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            <i class="fas fa-bolt mr-2 text-blue-600"></i>Aksi Cepat
                        </h3>
                        <div class="space-y-3">
                            @if($surat->status == 'diajukan' && auth()->user()->dapatMemprosesSurat())
                                <form action="{{ route('petugas.surat.proses', $surat) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" 
                                            class="w-full flex items-center justify-center px-4 py-3 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500"
                                            onclick="return confirm('Ambil surat ini untuk diproses? Anda akan ditugaskan sebagai petugas.')">
                                        <i class="fas fa-hand-paper mr-2"></i>Ambil Surat
                                    </button>
                                </form>
                            @endif

                            @if($surat->status == 'diproses' && $surat->petugas_id == auth()->id())
                                
                                
                                <form action="{{ route('petugas.surat.generate', $surat) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full flex items-center justify-center px-4 py-3 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                                            onclick="return confirm('Generate surat dalam format PDF?')">
                                        <i class="fas fa-file-pdf mr-2"></i>Generate PDF
                                    </button>
                                </form>
                            @endif

                            @if($surat->status == 'siap_ambil' && $surat->petugas_id == auth()->id())
                                <form action="{{ route('petugas.surat.selesai', $surat) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" 
                                            class="w-full flex items-center justify-center px-4 py-3 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                            onclick="return confirm('Tandai surat sebagai selesai?')">
                                        <i class="fas fa-check-double mr-2"></i>Tandai Selesai
                                    </button>
                                </form>
                            @endif

                            @if($surat->file_surat)
                                <div class="grid grid-cols-2 gap-2">
                                    <a href="{{ route('petugas.surat.preview', $surat) }}" target="_blank"
                                       class="flex items-center justify-center px-4 py-3 border border-orange-300 rounded-md shadow-sm text-sm font-medium text-orange-700 bg-orange-50 hover:bg-orange-100">
                                        <i class="fas fa-eye mr-2"></i>Preview
                                    </a>
                                    <a href="{{ route('petugas.surat.download', $surat) }}"
                                       class="flex items-center justify-center px-4 py-3 border border-indigo-300 rounded-md shadow-sm text-sm font-medium text-indigo-700 bg-indigo-50 hover:bg-indigo-100">
                                        <i class="fas fa-download mr-2"></i>Download
                                    </a>
                                </div>
                            @endif
                            
                            @if(in_array($surat->status, ['diajukan', 'diproses']) && auth()->user()->isAdmin())
                                <button onclick="showRejectModal()"
                                        class="w-full flex items-center justify-center px-4 py-3 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-red-50 hover:bg-red-100">
                                    <i class="fas fa-times-circle mr-2"></i>Tolak Surat
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Update Status -->
<div class="bg-white shadow rounded-lg p-6">
    <h3 class="text-lg font-medium text-gray-900 mb-4">
        <i class="fas fa-sync-alt mr-2 text-blue-600"></i>Update Status
    </h3>
    <form action="{{ route('petugas.surat.update.status', $surat) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="space-y-3">
            <div>
                <label class="block text-sm font-medium text-gray-700">Status Baru</label>
                <select name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    <option value="">Pilih Status</option>
                    <option value="diajukan" {{ $surat->status == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                    <option value="diproses" {{ $surat->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="siap_ambil" {{ $surat->status == 'siap_ambil' ? 'selected' : '' }}>Siap Ambil</option>
                    <option value="selesai" {{ $surat->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Catatan</label>
                <textarea name="catatan" rows="3" 
                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                          placeholder="Tambahkan catatan perubahan status..."></textarea>
            </div>
            <button type="submit" 
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Update Status
            </button>
        </div>
    </form>
</div>

                    <!-- Informasi Surat -->
                    <div class="bg-white shadow rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            <i class="fas fa-info-circle mr-2 text-blue-600"></i>Informasi
                        </h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Tanggal Dibuat:</span>
                                <span class="text-gray-900">{{ $surat->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Tanggal Update:</span>
                                <span class="text-gray-900">{{ $surat->updated_at->format('d/m/Y H:i') }}</span>
                            </div>
                            
                            @if($surat->tanggal_verifikasi)
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Terverifikasi:</span>
                                    <span class="text-gray-900">{{ $surat->tanggal_verifikasi->format('d/m/Y H:i') }}</span>
                                </div>
                                @if($surat->verifikator)
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Oleh:</span>
                                        <span class="text-gray-900">{{ $surat->verifikator->name }}</span>
                                    </div>
                                @endif
                            @endif
                            
                            @if($surat->tanggal_proses)
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Mulai Diproses:</span>
                                    <span class="text-gray-900">{{ $surat->tanggal_proses->format('d/m/Y H:i') }}</span>
                                </div>
                            @endif
                            
                            @if($surat->tanggal_siap)
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Siap Diambil:</span>
                                    <span class="text-gray-900">{{ $surat->tanggal_siap->format('d/m/Y H:i') }}</span>
                                </div>
                            @endif
                            
                            @if($surat->tanggal_selesai)
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Selesai:</span>
                                    <span class="text-gray-900">{{ $surat->tanggal_selesai->format('d/m/Y H:i') }}</span>
                                </div>
                            @endif
                            
                            @if($surat->petugas)
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Petugas:</span>
                                    <span class="text-gray-900">{{ $surat->petugas->name }}</span>
                                </div>
                            @else
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Petugas:</span>
                                    <span class="text-gray-500 italic">Belum ditugaskan</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tolak Surat -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4 hidden z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Tolak Surat</h3>
            </div>
            <form action="{{ route('petugas.surat.tolak', $surat) }}" method="POST" id="rejectForm">
                @csrf
                @method('PUT')
                <div class="px-6 py-4">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan</label>
                        <textarea name="alasan_penolakan" rows="4" 
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500" 
                                  placeholder="Masukkan alasan penolakan surat..." required></textarea>
                    </div>
                    <div class="text-sm text-gray-500 mb-4">
                        <i class="fas fa-info-circle mr-1"></i>
                        Surat yang ditolak tidak dapat diproses kembali.
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
                    <button type="button" onclick="hideRejectModal()" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700">
                        Tolak Surat
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        // Auto hide success/error messages
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert-auto-hide');
                alerts.forEach(alert => {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                });
            }, 5000);
        });

        // Modal functions
        function showRejectModal() {
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function hideRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('rejectModal').addEventListener('click', function(e) {
            if (e.target === this) {
                hideRejectModal();
            }
        });

        // Confirm before rejecting
        document.getElementById('rejectForm').addEventListener('submit', function(e) {
            if (!confirm('Apakah Anda yakin ingin menolak surat ini? Aksi ini tidak dapat dibatalkan.')) {
                e.preventDefault();
            }
        });
    </script>
    @endpush
</x-app-layout>