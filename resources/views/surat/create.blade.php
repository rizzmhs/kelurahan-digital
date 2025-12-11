<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
                    <i class="fas fa-file-signature mr-2 text-green-600"></i>Ajukan Surat Baru
                </h2>
                <p class="text-sm text-gray-500 mt-1">Pilih jenis surat yang ingin Anda ajukan</p>
            </div>
            <div class="text-sm text-gray-500">
                {{ now()->format('d/m/Y') }}
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <!-- Header Section -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="text-center mb-2">
                        <h1 class="text-2xl font-bold text-gray-900">Pilih Jenis Surat</h1>
                        <p class="text-gray-600 mt-2 max-w-2xl mx-auto">
                            Pilih jenis surat yang sesuai dengan kebutuhan administrasi Anda
                        </p>
                    </div>
                </div>

                <!-- Jenis Surat Grid -->
                <div class="p-6">
                    @if($jenisSurat->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($jenisSurat as $jenis)
                            <div class="border border-gray-200 rounded-lg hover:shadow-lg transition-all duration-200 card-hover">
                                <div class="p-6">
                                    <!-- Icon Section -->
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="w-14 h-14 bg-gradient-to-br from-green-100 to-green-50 rounded-xl flex items-center justify-center">
                                            <i class="fas fa-file-contract text-green-600 text-xl"></i>
                                        </div>
                                        @if($jenis->is_active)
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle mr-1"></i>Aktif
                                            </span>
                                        @else
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                                <i class="fas fa-pause-circle mr-1"></i>Tidak Aktif
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Content -->
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $jenis->nama }}</h3>
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                        {{ $jenis->deskripsi }}
                                    </p>
                                    
                                    <!-- Details -->
                                    <div class="space-y-3 mb-6">
                                        <div class="flex items-center text-sm text-gray-500">
                                            <i class="fas fa-clock text-gray-400 mr-3 w-5"></i>
                                            <span>Estimasi:</span>
                                            <span class="ml-auto font-medium text-gray-900">
                                                {{ $jenis->estimasi_hari }} hari
                                            </span>
                                        </div>
                                        <div class="flex items-center text-sm text-gray-500">
                                            <i class="fas fa-money-bill-wave text-gray-400 mr-3 w-5"></i>
                                            <span>Biaya:</span>
                                            <span class="ml-auto font-medium text-gray-900">
                                                Rp {{ number_format($jenis->biaya, 0, ',', '.') }}
                                            </span>
                                        </div>
                                        @if($jenis->persyaratan)
                                        <div class="flex items-start text-sm text-gray-500">
                                            <i class="fas fa-list-check text-gray-400 mr-3 w-5 mt-0.5"></i>
                                            <span>Syarat: {{ Str::limit($jenis->persyaratan, 60) }}</span>
                                        </div>
                                        @endif
                                    </div>

                                    <!-- Action Button -->
                                    @if($jenis->is_active)
                                    <form action="{{ route('warga.surat.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="jenis_surat_id" value="{{ $jenis->id }}">
                                        <button type="submit" 
                                                class="w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white py-2.5 px-4 rounded-lg text-sm font-medium transition-all duration-200 flex items-center justify-center hover:shadow-md">
                                            <i class="fas fa-paper-plane mr-2.5"></i>
                                            Ajukan Sekarang
                                        </button>
                                    </form>
                                    @else
                                    <button type="button" 
                                            class="w-full bg-gray-100 text-gray-400 py-2.5 px-4 rounded-lg text-sm font-medium cursor-not-allowed flex items-center justify-center">
                                        <i class="fas fa-ban mr-2.5"></i>
                                        Sementara Tidak Tersedia
                                    </button>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-12">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                                <i class="fas fa-file-exclamation text-gray-400 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada jenis surat tersedia</h3>
                            <p class="text-gray-500 max-w-md mx-auto mb-6">
                                Saat ini belum ada jenis surat yang dapat diajukan. Silakan hubungi admin untuk informasi lebih lanjut.
                            </p>
                            <div class="flex flex-wrap justify-center gap-3">
                                <a href="{{ route('dashboard') }}" 
                                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2.5 px-5 rounded-lg transition-all duration-200 flex items-center card-hover">
                                    <i class="fas fa-home mr-2.5"></i>
                                    Kembali ke Dashboard
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Information Section -->
                <div class="border-t border-gray-200 bg-gradient-to-r from-blue-50 to-blue-50 px-6 py-8">
                    <div class="max-w-4xl mx-auto">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-info-circle text-blue-600 mr-3"></i>Informasi Penting
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-white rounded-lg p-5 border border-blue-100 hover:border-blue-200 transition duration-200">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-check-circle text-blue-600"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-sm font-semibold text-gray-900 mb-2">Data yang Akurat</h4>
                                        <p class="text-sm text-gray-600">
                                            Pastikan data yang diisi akurat dan sesuai dengan dokumen asli untuk mempercepat proses verifikasi.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-lg p-5 border border-blue-100 hover:border-blue-200 transition duration-200">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-file-upload text-blue-600"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-sm font-semibold text-gray-900 mb-2">Format Dokumen</h4>
                                        <p class="text-sm text-gray-600">
                                            Upload dokumen persyaratan dalam format PDF, JPG, atau PNG dengan ukuran maksimal 5MB per file.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-lg p-5 border border-blue-100 hover:border-blue-200 transition duration-200">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-user-check text-blue-600"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-sm font-semibold text-gray-900 mb-2">Proses Verifikasi</h4>
                                        <p class="text-sm text-gray-600">
                                            Surat akan diproses setelah admin memverifikasi kelengkapan berkas. Proses verifikasi memakan waktu 1-2 hari kerja.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-lg p-5 border border-blue-100 hover:border-blue-200 transition duration-200">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-bell text-blue-600"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-sm font-semibold text-gray-900 mb-2">Notifikasi Status</h4>
                                        <p class="text-sm text-gray-600">
                                            Anda akan mendapat notifikasi melalui email dan aplikasi ketika surat siap diambil atau didownload.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Tips -->
                        <div class="mt-8 bg-gradient-to-r from-green-50 to-green-50 border border-green-100 rounded-lg p-5">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-lightbulb text-green-600"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-sm font-semibold text-gray-900 mb-2">Tips Cepat Disetujui</h4>
                                    <ul class="text-sm text-gray-600 space-y-2">
                                        <li class="flex items-start">
                                            <i class="fas fa-check text-green-500 mr-2 mt-0.5"></i>
                                            <span>Lengkapi semua dokumen persyaratan sesuai jenis surat</span>
                                        </li>
                                        <li class="flex items-start">
                                            <i class="fas fa-check text-green-500 mr-2 mt-0.5"></i>
                                            <span>Pastikan foto dokumen jelas dan terbaca</span>
                                        </li>
                                        <li class="flex items-start">
                                            <i class="fas fa-check text-green-500 mr-2 mt-0.5"></i>
                                            <span>Isi formulir dengan data yang valid dan terbaru</span>
                                        </li>
                                        <li class="flex items-start">
                                            <i class="fas fa-check text-green-500 mr-2 mt-0.5"></i>
                                            <span>Pantau status pengajuan melalui dashboard secara berkala</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Back Navigation -->
            <div class="mt-6">
                <a href="{{ route('warga.surat.index') }}" 
                   class="text-gray-600 hover:text-gray-900 transition duration-200 flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Daftar Surat
                </a>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
        }
    </style>
    @endpush
</x-app-layout>