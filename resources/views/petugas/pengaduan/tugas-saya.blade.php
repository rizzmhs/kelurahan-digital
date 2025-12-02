<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <a href="{{ route('petugas.pengaduan.index') }}" class="text-blue-600 hover:text-blue-900 mr-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        <i class="fas fa-user-check mr-2 text-blue-600"></i>Tugas Saya
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Pengaduan yang ditugaskan kepada saya</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Table -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                @if($pengaduans->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Kode
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Judul Pengaduan
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Prioritas
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tenggat Waktu
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($pengaduans as $pengaduan)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-mono text-gray-900 font-bold">
                                                {{ $pengaduan->kode_pengaduan }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $pengaduan->judul }}</div>
                                            <div class="text-sm text-gray-500 truncate max-w-xs">{{ $pengaduan->deskripsi }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $pengaduan->status == 'diajukan' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $pengaduan->status == 'diproses' ? 'bg-purple-100 text-purple-800' : '' }}
                                                {{ $pengaduan->status == 'selesai' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $pengaduan->status == 'ditolak' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ ucfirst($pengaduan->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $pengaduan->prioritas == 'rendah' ? 'bg-gray-100 text-gray-800' : '' }}
                                                {{ $pengaduan->prioritas == 'sedang' ? 'bg-blue-100 text-blue-800' : '' }}
                                                {{ $pengaduan->prioritas == 'tinggi' ? 'bg-orange-100 text-orange-800' : '' }}
                                                {{ $pengaduan->prioritas == 'darurat' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ ucfirst($pengaduan->prioritas) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if($pengaduan->tenggat_waktu)
                                                {{ $pengaduan->tenggat_waktu->format('d/m/Y') }}
                                                @if($pengaduan->tenggat_waktu->isPast() && $pengaduan->status != 'selesai')
                                                    <span class="text-red-500 ml-1">(Terlambat)</span>
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('petugas.pengaduan.show', $pengaduan) }}" 
                                               class="text-blue-600 hover:text-blue-900">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-user-check text-gray-400 text-5xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada tugas</h3>
                        <p class="text-gray-500">Belum ada pengaduan yang ditugaskan kepada Anda.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>