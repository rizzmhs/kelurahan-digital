<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <a href="{{ route('petugas.surat.show', $surat) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        <i class="fas fa-history mr-2 text-blue-600"></i>Riwayat Surat
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Nomor: {{ $surat->nomor_surat ?? 'Belum ada' }} - {{ $surat->jenisSurat->nama ?? 'Tidak diketahui' }}
                    </p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Riwayat Timeline -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                @if($riwayat->count() > 0)
                    <div class="flow-root p-6">
                        <ul class="-mb-8">
                            @foreach($riwayat as $index => $item)
                                <li>
                                    <div class="relative pb-8">
                                        @if(!$loop->last)
                                            <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                        @endif
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                                    <i class="fas fa-{{ getStatusIcon($item->status) }} text-white text-sm"></i>
                                                </span>
                                            </div>
                                            <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                                <div class="min-w-0 flex-1">
                                                    <p class="text-sm text-gray-500">
                                                        Status diubah menjadi 
                                                        <span class="font-medium text-gray-900">{{ $item->status_display ?? ucfirst($item->status) }}</span>
                                                        oleh {{ $item->user->name ?? 'Sistem' }}
                                                    </p>
                                                    @if($item->catatan)
                                                        <p class="mt-1 text-sm text-gray-600 bg-gray-50 p-2 rounded">{{ $item->catatan }}</p>
                                                    @endif
                                                    
                                                    <!-- Status Badge -->
                                                    <div class="mt-2">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                            {{ $item->status == 'diajukan' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                            {{ $item->status == 'diproses' ? 'bg-purple-100 text-purple-800' : '' }}
                                                            {{ $item->status == 'siap_ambil' ? 'bg-green-100 text-green-800' : '' }}
                                                            {{ $item->status == 'selesai' ? 'bg-gray-100 text-gray-800' : '' }}
                                                            {{ $item->status == 'ditolak' ? 'bg-red-100 text-red-800' : '' }}">
                                                            <i class="fas fa-{{ getStatusIcon($item->status) }} mr-1"></i>
                                                            {{ $item->status_display ?? ucfirst($item->status) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="whitespace-nowrap text-right text-sm text-gray-500">
                                                    <div class="flex flex-col items-end">
                                                        <time datetime="{{ $item->created_at->format('Y-m-d') }}" class="font-medium">
                                                            {{ $item->created_at->format('d/m/Y') }}
                                                        </time>
                                                        <time datetime="{{ $item->created_at->format('H:i') }}" class="text-xs text-gray-400">
                                                            {{ $item->created_at->format('H:i') }}
                                                        </time>
                                                        <span class="text-xs text-gray-400 mt-1">
                                                            {{ $item->created_at->diffForHumans() }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-history text-gray-400 text-5xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada riwayat</h3>
                        <p class="text-gray-500">Belum ada perubahan status pada surat ini.</p>
                        <a href="{{ route('petugas.surat.show', $surat) }}" 
                           class="inline-flex items-center mt-4 px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Detail Surat
                        </a>
                    </div>
                @endif
            </div>

            <!-- Summary Card -->
            @if($riwayat->count() > 0)
            <div class="mt-6 bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-chart-bar mr-2 text-blue-600"></i>Ringkasan Riwayat
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-yellow-600">{{ $riwayat->where('status', 'diajukan')->count() }}</div>
                        <div class="text-sm text-gray-500">Diajukan</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-purple-600">{{ $riwayat->where('status', 'diproses')->count() }}</div>
                        <div class="text-sm text-gray-500">Diproses</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600">{{ $riwayat->where('status', 'siap_ambil')->count() }}</div>
                        <div class="text-sm text-gray-500">Siap Ambil</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-600">{{ $riwayat->where('status', 'selesai')->count() }}</div>
                        <div class="text-sm text-gray-500">Selesai</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-red-600">{{ $riwayat->where('status', 'ditolak')->count() }}</div>
                        <div class="text-sm text-gray-500">Ditolak</div>
                    </div>
                </div>
                
                <!-- Timeline Stats -->
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <div class="flex justify-between text-sm text-gray-500">
                        <div>
                            <i class="fas fa-calendar mr-1"></i>
                            Periode: {{ $riwayat->last()->created_at->format('d/m/Y') }} - {{ $riwayat->first()->created_at->format('d/m/Y') }}
                        </div>
                        <div>
                            <i class="fas fa-clock mr-1"></i>
                            Total: {{ $riwayat->count() }} perubahan
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="mt-6 flex justify-between">
                <a href="{{ route('petugas.surat.show', $surat) }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Detail Surat
                </a>
                
                @if($riwayat->count() > 0)
                <div class="flex space-x-2">
                    <button onclick="window.print()" 
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-print mr-2"></i>Cetak Riwayat
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: white !important;
            }
            .bg-white {
                background: white !important;
                box-shadow: none !important;
            }
        }
    </style>
    @endpush
</x-app-layout>

@php
    function getStatusIcon($status) {
        switch($status) {
            case 'diajukan': return 'paper-plane';
            case 'diproses': return 'cog';
            case 'siap_ambil': return 'check-circle';
            case 'selesai': return 'archive';
            case 'ditolak': return 'times-circle';
            default: return 'envelope';
        }
    }
@endphp