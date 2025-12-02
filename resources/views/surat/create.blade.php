<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ajukan Surat Baru
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="text-center mb-8">
                        <h1 class="text-2xl font-bold text-gray-900">Pilih Jenis Surat</h1>
                        <p class="text-gray-600 mt-2">Pilih jenis surat yang ingin Anda ajukan</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($jenisSurat as $jenis)
                        <div class="border border-gray-200 rounded-lg hover:shadow-md transition-shadow duration-200">
                            <div class="p-6">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $jenis->nama }}</h3>
                                <p class="text-gray-600 text-sm mb-4">{{ $jenis->deskripsi }}</p>
                                
                                <div class="space-y-2 text-sm text-gray-500 mb-4">
                                    <div class="flex justify-between">
                                        <span>Estimasi:</span>
                                        <span>{{ $jenis->estimasi_hari }} hari</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Biaya:</span>
                                        <span>Rp {{ number_format($jenis->biaya, 0, ',', '.') }}</span>
                                    </div>
                                </div>

                                <form action="{{ route('warga.surat.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="jenis_surat_id" value="{{ $jenis->id }}">
                                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-md text-sm font-medium transition duration-200">
                                        Ajukan Sekarang
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Informasi Umum -->
                    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Informasi Penting</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Pastikan data yang diisi akurat dan sesuai dengan dokumen asli</span>
                            </div>
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Upload dokumen persyaratan dalam format PDF, JPG, atau PNG</span>
                            </div>
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Surat akan diproses setelah admin memverifikasi kelengkapan berkas</span>
                            </div>
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Anda akan mendapat notifikasi ketika surat siap diambil/didownload</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>