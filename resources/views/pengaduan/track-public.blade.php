<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lacak Pengaduan - {{ $pengaduan->kode_pengaduan }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Lacak Pengaduan</h1>
                <p class="text-gray-600 mt-2">Sistem Layanan Kelurahan Terpadu</p>
            </div>

            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Pengaduan Info -->
                <div class="bg-blue-600 text-white p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div>
                            <h2 class="text-xl font-bold">{{ $pengaduan->judul }}</h2>
                            <p class="mt-1 opacity-90">Kode: {{ $pengaduan->kode_pengaduan }}</p>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <span class="px-4 py-2 bg-white bg-opacity-20 rounded-full text-sm font-semibold">
                                Status: {{ ucfirst($pengaduan->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <!-- Basic Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Informasi Pengaduan</h3>
                            <dl class="space-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-600">Kategori</dt>
                                    <dd class="text-sm text-gray-900">{{ $pengaduan->kategori->nama_kategori }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-600">Lokasi</dt>
                                    <dd class="text-sm text-gray-900">{{ $pengaduan->lokasi }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-600">Tanggal Dilaporkan</dt>
                                    <dd class="text-sm text-gray-900">{{ $pengaduan->created_at->format('d F Y H:i') }}</dd>
                                </div>
                            </dl>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Pelapor</h3>
                            <dl class="space-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-600">Nama</dt>
                                    <dd class="text-sm text-gray-900">{{ $pengaduan->user->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-600">Tanggal Kejadian</dt>
                                    <dd class="text-sm text-gray-900">{{ $pengaduan->tanggal_kejadian->format('d F Y') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Progress Timeline -->
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Progress Penanganan</h3>
                        
                        <div class="space-y-6">
                            @php
                                $timeline = [
                                    'menunggu' => [
                                        'icon' => '📝',
                                        'title' => 'Pengaduan Diterima',
                                        'time' => $pengaduan->created_at,
                                        'description' => 'Pengaduan telah berhasil diterima sistem dan sedang menunggu verifikasi.'
                                    ],
                                    'diverifikasi' => [
                                        'icon' => '✅', 
                                        'title' => 'Terverifikasi',
                                        'time' => $pengaduan->diverifikasi_at,
                                        'description' => 'Pengaduan telah diverifikasi dan sedang diproses lebih lanjut.'
                                    ],
                                    'diproses' => [
                                        'icon' => '🔄',
                                        'title' => 'Sedang Diproses',
                                        'time' => $pengaduan->diproses_at,
                                        'description' => 'Pengaduan sedang ditangani oleh petugas terkait.'
                                    ],
                                    'selesai' => [
                                        'icon' => '🎉',
                                        'title' => 'Selesai',
                                        'time' => $pengaduan->selesai_at,
                                        'description' => 'Pengaduan telah selesai ditangani.'
                                    ]
                                ];
                                
                                $currentStatus = $pengaduan->status;
                            @endphp

                            @foreach($timeline as $status => $data)
                                @php
                                    $isCompleted = array_search($status, array_keys($timeline)) <= array_search($currentStatus, array_keys($timeline));
                                    $isCurrent = $status === $currentStatus;
                                @endphp
                                
                                <div class="flex items-start {{ !$isCompleted ? 'opacity-50' : '' }}">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center 
                                            {{ $isCompleted ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-500' }}">
                                            {{ $data['icon'] }}
                                        </div>
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <div class="flex items-center justify-between">
                                            <h4 class="text-base font-medium {{ $isCompleted ? 'text-gray-900' : 'text-gray-500' }}">
                                                {{ $data['title'] }}
                                            </h4>
                                            @if($data['time'])
                                                <span class="text-sm {{ $isCompleted ? 'text-gray-500' : 'text-gray-400' }}">
                                                    {{ $data['time']->format('d M Y H:i') }}
                                                </span>
                                            @endif
                                        </div>
                                        <p class="mt-1 text-sm {{ $isCompleted ? 'text-gray-600' : 'text-gray-400' }}">
                                            {{ $data['description'] }}
                                        </p>
                                        
                                        <!-- Additional Info for Specific Steps -->
                                        @if($status === 'diproses' && $pengaduan->petugas && $isCompleted)
                                        <div class="mt-2 flex items-center text-sm text-gray-600">
                                            <span class="font-medium">Petugas:</span>
                                            <span class="ml-2">{{ $pengaduan->petugas->name }}</span>
                                        </div>
                                        @endif
                                        
                                        @if($status === 'selesai' && $pengaduan->foto_penanganan && $isCompleted)
                                        <div class="mt-2">
                                            <p class="text-sm font-medium text-gray-700">Foto Penanganan:</p>
                                            <div class="mt-1 grid grid-cols-2 gap-2">
                                                @foreach($pengaduan->foto_penanganan as $foto)
                                                <img src="{{ Storage::url($foto) }}" alt="Penanganan" class="w-full h-20 object-cover rounded">
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                
                                @if(!$loop->last)
                                    <div class="ml-5 border-l-2 border-gray-300 h-6"></div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Additional Notes -->
                    @if($pengaduan->catatan_admin)
                    <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-yellow-800">Catatan dari Admin:</h4>
                        <p class="mt-1 text-sm text-yellow-700">{{ $pengaduan->catatan_admin }}</p>
                    </div>
                    @endif

                    @if($pengaduan->tindakan)
                    <div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-blue-800">Tindakan yang Dilakukan:</h4>
                        <p class="mt-1 text-sm text-blue-700">{{ $pengaduan->tindakan }}</p>
                    </div>
                    @endif

                    <!-- Call to Action -->
                    <div class="mt-8 text-center">
                        <p class="text-sm text-gray-600 mb-4">Butuh bantuan lebih lanjut?</p>
                        <a href="/" class="inline-block bg-blue-600 hover:bg-blue-700 text-white py-2 px-6 rounded-md text-sm font-medium">
                            Kunjungi Website Kami
                        </a>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center text-sm text-gray-500">
                <p>&copy; {{ date('Y') }} Sistem Layanan Kelurahan Terpadu. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>