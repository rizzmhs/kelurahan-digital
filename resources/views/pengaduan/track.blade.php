<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lacak Pengaduan - {{ $pengaduan->kode_pengaduan }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Header -->
                    <div class="text-center mb-8">
                        <h1 class="text-2xl font-bold text-gray-900">{{ $pengaduan->judul }}</h1>
                        <p class="text-gray-600 mt-2">Kode Pengaduan: {{ $pengaduan->kode_pengaduan }}</p>
                        <div class="mt-4">
                            <span class="px-4 py-2 text-lg font-semibold rounded-full {{ $pengaduan->getStatusBadgeClass() }}">
                                Status: {{ ucfirst($pengaduan->status) }}
                            </span>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="mb-8">
                        <div class="flex justify-between mb-2">
                            @php
                                $steps = [
                                    'menunggu' => 'Menunggu',
                                    'diverifikasi' => 'Diverifikasi', 
                                    'diproses' => 'Diproses',
                                    'selesai' => 'Selesai'
                                ];
                                $currentStep = array_search($pengaduan->status, array_keys($steps));
                                $progress = ($currentStep + 1) / count($steps) * 100;
                            @endphp
                            
                            @foreach($steps as $key => $label)
                                <span class="text-sm font-medium {{ $key === $pengaduan->status ? 'text-blue-600' : 'text-gray-500' }}">
                                    {{ $label }}
                                </span>
                            @endforeach
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $progress }}%"></div>
                        </div>
                    </div>

                    <!-- Detailed Timeline -->
                    <div class="space-y-8">
                        <!-- Step 1: Menunggu -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center 
                                    {{ $pengaduan->status !== 'menunggu' ? 'bg-green-500 text-white' : 'bg-blue-500 text-white' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-medium text-gray-900">Pengaduan Diterima</h3>
                                    <span class="text-sm text-gray-500">{{ $pengaduan->created_at->format('d M Y H:i') }}</span>
                                </div>
                                <p class="mt-1 text-gray-600">Pengaduan Anda telah berhasil diterima sistem dan sedang menunggu verifikasi dari admin.</p>
                            </div>
                        </div>

                        <!-- Step 2: Diverifikasi -->
                        @if($pengaduan->diverifikasi_at)
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center bg-green-500 text-white">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-medium text-gray-900">Pengaduan Diverifikasi</h3>
                                    <span class="text-sm text-gray-500">{{ $pengaduan->diverifikasi_at->format('d M Y H:i') }}</span>
                                </div>
                                <p class="mt-1 text-gray-600">Pengaduan Anda telah diverifikasi oleh admin dan sedang diproses lebih lanjut.</p>
                                @if($pengaduan->catatan_admin)
                                <div class="mt-2 bg-yellow-50 border border-yellow-200 rounded-md p-3">
                                    <p class="text-sm text-yellow-800"><strong>Catatan Admin:</strong> {{ $pengaduan->catatan_admin }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                        @else
                        <div class="flex items-start opacity-50">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center bg-gray-300 text-gray-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <h3 class="text-lg font-medium text-gray-500">Menunggu Verifikasi</h3>
                                <p class="mt-1 text-gray-500">Pengaduan Anda sedang menunggu verifikasi dari admin.</p>
                            </div>
                        </div>
                        @endif

                        <!-- Step 3: Diproses -->
                        @if($pengaduan->diproses_at)
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center bg-green-500 text-white">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-medium text-gray-900">Sedang Diproses</h3>
                                    <span class="text-sm text-gray-500">{{ $pengaduan->diproses_at->format('d M Y H:i') }}</span>
                                </div>
                                <p class="mt-1 text-gray-600">Pengaduan Anda sedang ditangani oleh petugas.</p>
                                @if($pengaduan->petugas)
                                <div class="mt-2 flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                                            {{ substr($pengaduan->petugas->name, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Petugas: {{ $pengaduan->petugas->name }}</p>
                                    </div>
                                </div>
                                @endif
                                @if($pengaduan->tindakan)
                                <div class="mt-2 bg-blue-50 border border-blue-200 rounded-md p-3">
                                    <p class="text-sm text-blue-800"><strong>Tindakan:</strong> {{ $pengaduan->tindakan }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                        @else
                        <div class="flex items-start opacity-50">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center bg-gray-300 text-gray-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <h3 class="text-lg font-medium text-gray-500">Proses Penanganan</h3>
                                <p class="mt-1 text-gray-500">Pengaduan Anda akan segera ditangani oleh petugas.</p>
                            </div>
                        </div>
                        @endif

                        <!-- Step 4: Selesai -->
                        @if($pengaduan->selesai_at)
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center bg-green-500 text-white">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-medium text-gray-900">Selesai</h3>
                                    <span class="text-sm text-gray-500">{{ $pengaduan->selesai_at->format('d M Y H:i') }}</span>
                                </div>
                                <p class="mt-1 text-gray-600">Pengaduan Anda telah selesai ditangani.</p>
                                @if($pengaduan->foto_penanganan && count($pengaduan->foto_penanganan) > 0)
                                <div class="mt-3">
                                    <p class="text-sm font-medium text-gray-700 mb-2">Foto Penanganan:</p>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                                        @foreach($pengaduan->foto_penanganan as $foto)
                                        <img src="{{ Storage::url($foto) }}" alt="Foto penanganan" class="w-full h-24 object-cover rounded-lg">
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @else
                        <div class="flex items-start opacity-50">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center bg-gray-300 text-gray-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <h3 class="text-lg font-medium text-gray-500">Penyelesaian</h3>
                                <p class="mt-1 text-gray-500">Pengaduan Anda akan segera diselesaikan.</p>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 flex justify-center space-x-4">
                        <a href="{{ route('warga.pengaduan.show', $pengaduan) }}" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-6 rounded-md">
                            Lihat Detail Lengkap
                        </a>
                        <a href="{{ route('warga.pengaduan.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white py-2 px-6 rounded-md">
                            Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>