<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <a href="{{ route('petugas.pengaduan.show', $pengaduan) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        <i class="fas fa-history mr-2 text-blue-600"></i>Riwayat Pengaduan
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Kode: {{ $pengaduan->kode_pengaduan }}</p>
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
                                                    <i class="fas fa-{{ $item->status == 'diajukan' ? 'paper-plane' : ($item->status == 'diproses' ? 'cog' : ($item->status == 'selesai' ? 'check-circle' : 'times-circle')) }} text-white text-sm"></i>
                                                </span>
                                            </div>
                                            <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                                <div>
                                                    <p class="text-sm text-gray-500">
                                                        Status diubah menjadi 
                                                        <span class="font-medium text-gray-900">{{ ucfirst($item->status) }}</span>
                                                        oleh {{ $item->user->name }}
                                                    </p>
                                                    @if($item->catatan)
                                                        <p class="mt-1 text-sm text-gray-600">{{ $item->catatan }}</p>
                                                    @endif
                                                </div>
                                                <div class="whitespace-nowrap text-right text-sm text-gray-500">
                                                    <time datetime="{{ $item->created_at->format('Y-m-d') }}">
                                                        {{ $item->created_at->format('d/m/Y H:i') }}
                                                    </time>
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
                        <p class="text-gray-500">Belum ada perubahan status pada pengaduan ini.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
