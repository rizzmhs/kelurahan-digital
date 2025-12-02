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
                    <p class="text-sm text-gray-500 mt-1">Nomor: {{ $surat->nomor_surat ?? 'Belum ada' }}</p>
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
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Status Surat</h3>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                                    {{ $surat->status == 'diajukan' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $surat->status == 'diproses' ? 'bg-purple-100 text-purple-800' : '' }}
                                    {{ $surat->status == 'siap_ambil' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $surat->status == 'selesai' ? 'bg-gray-100 text-gray-800' : '' }}
                                    {{ $surat->status == 'ditolak' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ $surat->status_display ?? ucfirst($surat->status) }}
                                </span>
                                
                                @if($surat->file_surat)
                                    <span class="px-2 py-1 inline-flex text-xs leading-4 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        <i class="fas fa-file-pdf mr-1"></i>PDF Tersedia
                                    </span>
                                @endif
                            </div>
                            <div class="text-sm text-gray-500">
                                Terakhir diupdate: {{ $surat->updated_at->format('d/m/Y H:i') }}
                            </div>
                        </div>

                        <!-- Timeline Status -->
                        <div class="mt-4 flex items-center justify-between text-xs text-gray-500">
                            <div class="text-center {{ $surat->status == 'diajukan' ? 'text-yellow-600 font-medium' : '' }}">
                                <i class="fas fa-paper-plane block mb-1"></i>
                                Diajukan
                            </div>
                            <div class="flex-1 h-1 bg-gray-200 mx-2"></div>
                            <div class="text-center {{ $surat->status == 'diproses' ? 'text-purple-600 font-medium' : '' }}">
                                <i class="fas fa-cog block mb-1"></i>
                                Diproses
                            </div>
                            <div class="flex-1 h-1 bg-gray-200 mx-2"></div>
                            <div class="text-center {{ $surat->status == 'siap_ambil' ? 'text-green-600 font-medium' : '' }}">
                                <i class="fas fa-check-circle block mb-1"></i>
                                Siap Ambil
                            </div>
                            <div class="flex-1 h-1 bg-gray-200 mx-2"></div>
                            <div class="text-center {{ $surat->status == 'selesai' ? 'text-gray-600 font-medium' : '' }}">
                                <i class="fas fa-archive block mb-1"></i>
                                Selesai
                            </div>
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
                            <div class="flex items-center">
                                <i class="fas fa-tag text-blue-600 mr-2"></i>
                                <span class="text-sm font-medium text-blue-800">Jenis Surat:</span>
                                <span class="text-sm text-blue-700 ml-2">{{ $surat->jenisSurat->nama ?? 'Tidak diketahui' }}</span>
                            </div>
                        </div>

                        <div class="space-y-3">
                            @if($surat->data_pengajuan && count($surat->data_pengajuan) > 0)
                                @foreach($surat->data_pengajuan as $key => $value)
                                    <div class="flex justify-between items-start border-b border-gray-100 pb-3">
                                        <span class="text-sm font-medium text-gray-500 capitalize flex-1">
                                            {{ str_replace('_', ' ', $key) }}
                                        </span>
                                        <span class="text-sm text-gray-900 text-right flex-1">
                                            @if(is_array($value))
                                                {{ implode(', ', $value) }}
                                            @elseif(is_bool($value))
                                                {{ $value ? 'Ya' : 'Tidak' }}
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
                    </div>

                    <!-- Keterangan Tambahan -->
                    @if($surat->keterangan || $surat->alasan_penolakan)
                    <div class="bg-white shadow rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            <i class="fas fa-sticky-note mr-2 text-blue-600"></i>Keterangan
                        </h3>
                        <div class="space-y-3">
                            @if($surat->keterangan)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Keterangan</label>
                                    <p class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $surat->keterangan }}</p>
                                </div>
                            @endif
                            @if($surat->alasan_penolakan)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 text-red-600">Alasan Penolakan</label>
                                    <p class="mt-1 text-sm text-red-700 whitespace-pre-line">{{ $surat->alasan_penolakan }}</p>
                                </div>
                            @endif
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
                            @if($surat->status == 'diajukan')
                                <form action="{{ route('petugas.surat.proses', $surat) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full flex items-center justify-center px-4 py-3 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500"
                                            onclick="return confirm('Apakah Anda yakin ingin memproses surat ini?')">
                                        <i class="fas fa-cog mr-2"></i>Proses Surat
                                    </button>
                                </form>
                            @endif

                            @if($surat->status == 'diproses')
                                <form action="{{ route('petugas.surat.generate.pdf', $surat) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full flex items-center justify-center px-4 py-3 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                                            onclick="return confirm('Apakah Anda yakin ingin generate PDF surat ini?')">
                                        <i class="fas fa-file-pdf mr-2"></i>Generate PDF
                                    </button>
                                </form>
                            @endif

                            @if($surat->status == 'siap_ambil')
                                <form action="{{ route('petugas.surat.update.status', $surat) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="selesai">
                                    <input type="hidden" name="catatan" value="Surat telah diambil oleh pemohon">
                                    <button type="submit" 
                                            class="w-full flex items-center justify-center px-4 py-3 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                                            onclick="return confirm('Apakah Anda yakin ingin menandai surat sebagai selesai?')">
                                        <i class="fas fa-check mr-2"></i>Tandai Selesai
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
                                    <label class="block text-sm font-medium text-gray-700">Status</label>
                                    <select name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="diajukan" {{ $surat->status == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                                        <option value="diproses" {{ $surat->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                        <option value="siap_ambil" {{ $surat->status == 'siap_ambil' ? 'selected' : '' }}>Siap Ambil</option>
                                        <option value="selesai" {{ $surat->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="ditolak" {{ $surat->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
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
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Dibuat:</span>
                                <span class="text-gray-900">{{ $surat->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Diupdate:</span>
                                <span class="text-gray-900">{{ $surat->updated_at->format('d/m/Y H:i') }}</span>
                            </div>
                            @if($surat->verifikator)
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Diverifikasi oleh:</span>
                                    <span class="text-gray-900">{{ $surat->verifikator->name }}</span>
                                </div>
                            @endif
                            @if($surat->petugas)
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Ditangani oleh:</span>
                                    <span class="text-gray-900">{{ $surat->petugas->name }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
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
    </script>
    @endpush
</x-app-layout>