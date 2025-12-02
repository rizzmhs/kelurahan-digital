<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Pengguna - {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Header & Actions -->
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                            <p class="text-gray-600 mt-1">{{ $user->email }}</p>
                        </div>
                        <div class="flex space-x-2">
                            @php
                                $roleClasses = [
                                    'warga' => 'bg-green-100 text-green-800',
                                    'petugas' => 'bg-blue-100 text-blue-800',
                                    'admin' => 'bg-purple-100 text-purple-800'
                                ];
                            @endphp
                            <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $roleClasses[$user->role] }}">
                                {{ ucfirst($user->role) }}
                            </span>
                            @if($user->is_verified)
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                    Terverifikasi
                                </span>
                            @else
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Belum Diverifikasi
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Main Content -->
                        <div class="lg:col-span-2 space-y-6">
                            <!-- Personal Information -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-3">Informasi Pribadi</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-sm font-medium text-gray-600">NIK</label>
                                        <p class="text-sm text-gray-900 mt-1">{{ $user->nik }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-600">Telepon</label>
                                        <p class="text-sm text-gray-900 mt-1">{{ $user->telepon }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-600">Tanggal Lahir</label>
                                        <p class="text-sm text-gray-900 mt-1">{{ $user->tanggal_lahir->format('d F Y') }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-600">Jenis Kelamin</label>
                                        <p class="text-sm text-gray-900 mt-1">{{ $user->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="text-sm font-medium text-gray-600">Alamat</label>
                                        <p class="text-sm text-gray-900 mt-1">{{ $user->alamat }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Activity Stats -->
                            <div class="bg-white border border-gray-200 rounded-lg p-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-3">Statistik Aktivitas</h3>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-blue-600">{{ $user->pengaduans_count }}</div>
                                        <div class="text-sm text-gray-600">Pengaduan</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-green-600">{{ $user->surats_count }}</div>
                                        <div class="text-sm text-gray-600">Surat</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-purple-600">{{ $user->created_at->diffInDays(now()) }}</div>
                                        <div class="text-sm text-gray-600">Hari Bergabung</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Recent Activity -->
                            @if($user->pengaduans_count > 0 || $user->surats_count > 0)
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-3">Aktivitas Terbaru</h3>
                                <div class="space-y-3">
                                    @if($user->pengaduans_count > 0)
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-700 mb-2">Pengaduan Terbaru</h4>
                                        @foreach($user->pengaduans->take(3) as $pengaduan)
                                        <div class="flex items-center justify-between p-2 border border-gray-200 rounded mb-2">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ Str::limit($pengaduan->judul, 40) }}</p>
                                                <p class="text-xs text-gray-500">{{ $pengaduan->created_at->format('d M Y') }}</p>
                                            </div>
                                            <span class="px-2 py-1 text-xs rounded-full {{ $pengaduan->getStatusBadgeClass() }}">
                                                {{ ucfirst($pengaduan->status) }}
                                            </span>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif

                                    @if($user->surats_count > 0)
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-700 mb-2">Surat Terbaru</h4>
                                        @foreach($user->surats->take(3) as $surat)
                                        <div class="flex items-center justify-between p-2 border border-gray-200 rounded mb-2">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $surat->jenisSurat->nama }}</p>
                                                <p class="text-xs text-gray-500">{{ $surat->created_at->format('d M Y') }}</p>
                                            </div>
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
                                            <span class="px-2 py-1 text-xs rounded-full {{ $statusClasses[$surat->status] }}">
                                                {{ str_replace('_', ' ', ucfirst($surat->status)) }}
                                            </span>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Sidebar -->
                        <div class="space-y-6">
                            <!-- Account Information -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-3">Informasi Akun</h3>
                                <dl class="space-y-2">
                                    <div class="flex justify-between">
                                        <dt class="text-sm text-gray-600">Email:</dt>
                                        <dd class="text-sm text-gray-900">{{ $user->email }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm text-gray-600">Role:</dt>
                                        <dd class="text-sm text-gray-900">{{ ucfirst($user->role) }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm text-gray-600">Bergabung:</dt>
                                        <dd class="text-sm text-gray-900">{{ $user->created_at->format('d F Y') }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm text-gray-600">Terakhir Update:</dt>
                                        <dd class="text-sm text-gray-900">{{ $user->updated_at->format('d F Y') }}</dd>
                                    </div>
                                </dl>
                            </div>

                            <!-- Management Actions -->
                            <div class="bg-white border border-gray-200 rounded-lg p-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-3">Kelola User</h3>
                                <div class="space-y-3">
                                    @if(!$user->is_verified)
                                    <form action="{{ route('admin.users.verify', $user) }}" method="POST" class="w-full">
                                        @csrf
                                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-md text-sm font-medium">
                                            Verifikasi User
                                        </button>
                                    </form>
                                    @endif

                                    <form action="{{ route('admin.users.update.role', $user) }}" method="POST" class="w-full">
                                        @csrf
                                        <div class="flex space-x-2">
                                            <select name="role" required
                                                    class="flex-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                <option value="warga" {{ $user->role == 'warga' ? 'selected' : '' }}>Warga</option>
                                                <option value="petugas" {{ $user->role == 'petugas' ? 'selected' : '' }}>Petugas</option>
                                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                            </select>
                                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md text-sm font-medium">
                                                Update
                                            </button>
                                        </div>
                                    </form>

                                    @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.update.status', $user) }}" method="POST" class="w-full">
                                        @csrf
                                        <div class="flex space-x-2">
                                            <select name="status" required
                                                    class="flex-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                <option value="active" selected>Aktif</option>
                                                <option value="suspended">Suspend</option>
                                            </select>
                                            <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white py-2 px-4 rounded-md text-sm font-medium">
                                                Update
                                            </button>
                                        </div>
                                    </form>
                                    @endif
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="space-y-3">
                                <a href="{{ route('admin.users.edit', $user) }}" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white py-2 px-4 rounded-md text-sm font-medium text-center block">
                                    Edit User
                                </a>
                                <a href="{{ route('admin.users.index') }}" class="w-full bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded-md text-sm font-medium text-center block">
                                    Kembali ke Daftar
                                </a>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="w-full">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-md text-sm font-medium" 
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                        Hapus User
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>