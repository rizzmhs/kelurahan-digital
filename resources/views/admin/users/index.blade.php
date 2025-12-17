@php
    // Helper functions untuk konsistensi
    if (!function_exists('getRoleBadgeClass')) {
        function getRoleBadgeClass($role) {
            $badgeClasses = [
                'admin' => 'badge-admin',
                'petugas' => 'badge-petugas',
                'warga' => 'badge-warga'
            ];
            return $badgeClasses[$role] ?? 'badge-draft';
        }
    }
    
    if (!function_exists('getStatusBadgeClass')) {
        function getStatusBadgeClass($isVerified) {
            return $isVerified ? 'badge-selesai' : 'badge-diajukan';
        }
    }
    
    if (!function_exists('getStatusDisplay')) {
        function getStatusDisplay($isVerified) {
            return $isVerified ? 'Terverifikasi' : 'Belum Diverifikasi';
        }
    }
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    Kelola Pengguna
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    Manajemen semua pengguna sistem
                </p>
            </div>
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <i class="fas fa-users text-blue-500"></i>
                <span>Total: <span class="font-semibold text-gray-900">{{ $users->total() }}</span> pengguna</span>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Stats Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Users -->
            <div class="stats-card">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="stats-icon stats-icon-blue">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total User</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $users->total() }}</p>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <span class="text-xs text-gray-500 flex items-center">
                            <i class="fas fa-user-check mr-2"></i>
                            Semua role
                        </span>
                    </div>
                </div>
            </div>

            <!-- Warga -->
            <div class="stats-card">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="stats-icon stats-icon-green">
                            <i class="fas fa-user text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Warga</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $users->where('role', 'warga')->count() }}</p>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <span class="text-xs text-gray-500 flex items-center">
                            <i class="fas fa-home mr-2"></i>
                            Pengguna masyarakat
                        </span>
                    </div>
                </div>
            </div>

            <!-- Petugas -->
            <div class="stats-card">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="stats-icon stats-icon-purple">
                            <i class="fas fa-user-shield text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Petugas</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $users->where('role', 'petugas')->count() }}</p>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <span class="text-xs text-gray-500 flex items-center">
                            <i class="fas fa-tasks mr-2"></i>
                            Staff kelurahan
                        </span>
                    </div>
                </div>
            </div>

            <!-- Admin -->
            <div class="stats-card">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="stats-icon stats-icon-orange">
                            <i class="fas fa-user-cog text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Admin</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $users->where('role', 'admin')->count() }}</p>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <span class="text-xs text-gray-500 flex items-center">
                            <i class="fas fa-cogs mr-2"></i>
                            Administrator
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Content Section -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Filter Panel -->
            <div class="lg:col-span-1">
                <div class="card sticky top-6">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-filter text-blue-500"></i>
                            Filter & Pencarian
                        </h3>
                    </div>
                    <form method="GET" action="{{ route('admin.users.index') }}" class="p-5">
                        <div class="space-y-5">
                            <!-- Role Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                                    <i class="fas fa-user-tag text-gray-500 text-sm"></i>
                                    Role
                                </label>
                                <select name="role" 
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    <option value="">Semua Role</option>
                                    <option value="warga" {{ request('role') == 'warga' ? 'selected' : '' }}>Warga</option>
                                    <option value="petugas" {{ request('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </div>

                            <!-- Verified Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                                    <i class="fas fa-check-circle text-gray-500 text-sm"></i>
                                    Status Verifikasi
                                </label>
                                <select name="verified" 
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    <option value="">Semua Status</option>
                                    <option value="1" {{ request('verified') == '1' ? 'selected' : '' }}>Terverifikasi</option>
                                    <option value="0" {{ request('verified') == '0' ? 'selected' : '' }}>Belum Diverifikasi</option>
                                </select>
                            </div>

                            <!-- Action Buttons -->
                            <div class="space-y-3 pt-2">
                                <button type="submit" 
                                        class="w-full px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm transition-colors duration-200 flex items-center justify-center gap-2">
                                    <i class="fas fa-filter"></i>
                                    Terapkan Filter
                                </button>
                                
                                <a href="{{ route('admin.users.index') }}" 
                                   class="w-full px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg text-sm transition-colors duration-200 flex items-center justify-center gap-2">
                                    <i class="fas fa-redo"></i>
                                    Reset Semua
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-3">
                <div class="card">
                    <!-- Header -->
                    <div class="card-header">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                    <i class="fas fa-users text-gray-500"></i>
                                    Daftar Pengguna
                                </h3>
                                @if(request()->anyFilled(['role', 'verified']))
                                <p class="text-sm text-gray-500 mt-1">
                                    Filter aktif: 
                                    @if(request('role')) <span class="font-medium text-blue-600">{{ ucfirst(request('role')) }}</span> @endif
                                    @if(request('verified') === '1') <span class="font-medium text-green-600">Terverifikasi</span> @endif
                                    @if(request('verified') === '0') <span class="font-medium text-yellow-600">Belum Diverifikasi</span> @endif
                                </p>
                                @endif
                            </div>
                            
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.users.create') }}" 
                                   class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm transition-colors flex items-center gap-2">
                                    <i class="fas fa-plus"></i>
                                    Tambah User
                                </a>
                            </div>
                        </div>
                    </div>

                    @if($users->count() > 0)
                        <!-- Desktop Table -->
                        <div class="hidden lg:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            User
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Kontak
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Role
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Bergabung
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($users as $user)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <!-- User Info -->
                                        <td class="px-6 py-4">
                                            <div class="flex items-start gap-3">
                                                <div class="flex-shrink-0">
                                                    <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                                                        <div class="text-blue-600 font-semibold">
                                                            {{ substr($user->name, 0, 1) }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="text-sm font-semibold text-gray-900">
                                                        {{ $user->name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500 mt-0.5">
                                                        {{ $user->email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <!-- Kontak -->
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $user->telepon ?? '-' }}</div>
                                            <div class="text-xs text-gray-500 mt-0.5">{{ $user->nik ?? '-' }}</div>
                                        </td>
                                        
                                        <!-- Role -->
                                        <td class="px-6 py-4">
                                            <span class="badge {{ getRoleBadgeClass($user->role) }}">
                                                <i class="fas fa-user-tag mr-1"></i>
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        
                                        <!-- Status -->
                                        <td class="px-6 py-4">
                                            <span class="badge {{ getStatusBadgeClass($user->is_verified) }}">
                                                <i class="fas {{ $user->is_verified ? 'fa-check-circle' : 'fa-clock' }} mr-1"></i>
                                                {{ getStatusDisplay($user->is_verified) }}
                                            </span>
                                        </td>
                                        
                                        <!-- Bergabung -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 font-medium">{{ $user->created_at->format('d M Y') }}</div>
                                            <div class="text-xs text-gray-500">{{ $user->created_at->format('H:i') }}</div>
                                        </td>
                                        
                                        <!-- Actions -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-2">
                                                <!-- View -->
                                                <a href="{{ route('admin.users.show', $user) }}" 
                                                   class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200"
                                                   title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                
                                                <!-- Edit -->
                                                <a href="{{ route('admin.users.edit', $user) }}" 
                                                   class="p-2 text-gray-500 hover:text-yellow-600 hover:bg-yellow-50 rounded-lg transition-colors duration-200"
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                
                                                <!-- Delete -->
                                                @if($user->id !== auth()->id())
                                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200"
                                                            title="Hapus" 
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile/Tablet Cards -->
                        <div class="lg:hidden">
                            <div class="divide-y divide-gray-200">
                                @foreach($users as $user)
                                <div class="p-4 hover:bg-gray-50 transition-colors duration-150">
                                    <!-- Card Header -->
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-start gap-3">
                                                <div class="flex-shrink-0">
                                                    <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                                                        <div class="text-blue-600 font-semibold">
                                                            {{ substr($user->name, 0, 1) }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <h4 class="text-sm font-semibold text-gray-900 truncate">
                                                        {{ $user->name }}
                                                    </h4>
                                                    <p class="text-xs text-gray-500 mt-0.5 truncate">
                                                        {{ $user->email }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <a href="{{ route('admin.users.edit', $user) }}" 
                                               class="p-1.5 text-gray-500 hover:text-yellow-600">
                                                <i class="fas fa-edit text-sm"></i>
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <!-- Card Details -->
                                    <div class="space-y-3 text-sm">
                                        <!-- Status & Role -->
                                        <div class="flex items-center justify-between">
                                            <span class="badge {{ getRoleBadgeClass($user->role) }}">
                                                <i class="fas fa-user-tag mr-1"></i>
                                                {{ ucfirst($user->role) }}
                                            </span>
                                            <span class="badge {{ getStatusBadgeClass($user->is_verified) }}">
                                                <i class="fas {{ $user->is_verified ? 'fa-check-circle' : 'fa-clock' }} mr-1"></i>
                                                {{ getStatusDisplay($user->is_verified) }}
                                            </span>
                                        </div>
                                        
                                        <!-- Info -->
                                        <div class="grid grid-cols-2 gap-3">
                                            <div>
                                                <p class="text-xs text-gray-500 mb-1">Telepon</p>
                                                <p class="text-sm font-medium text-gray-900">{{ $user->telepon ?? '-' }}</p>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500 mb-1">Bergabung</p>
                                                <p class="text-sm font-medium text-gray-900">{{ $user->created_at->format('d M Y') }}</p>
                                            </div>
                                        </div>
                                        
                                        <!-- Actions -->
                                        <div class="pt-3 border-t border-gray-200">
                                            <div class="flex items-center justify-between">
                                                <a href="{{ route('admin.users.show', $user) }}" 
                                                   class="px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-medium rounded-lg transition-colors duration-200 flex items-center gap-1">
                                                    <i class="fas fa-eye"></i>
                                                    Detail
                                                </a>
                                                
                                                @if($user->id !== auth()->id())
                                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-700 text-xs font-medium rounded-lg transition-colors duration-200 flex items-center gap-1"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                                        <i class="fas fa-trash"></i>
                                                        Hapus
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div class="border-t border-gray-200 bg-gray-50">
                            <div class="px-5 py-4">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                    <div class="text-sm text-gray-600">
                                        Menampilkan <span class="font-medium">{{ $users->firstItem() }}</span> sampai 
                                        <span class="font-medium">{{ $users->lastItem() }}</span> dari 
                                        <span class="font-medium">{{ $users->total() }}</span> entri
                                    </div>
                                    <div class="flex justify-center sm:justify-end">
                                        {{ $users->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="p-8 text-center">
                            <div class="empty-state-icon">
                                <i class="fas fa-users text-xl"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">
                                Tidak ada pengguna ditemukan
                            </h4>
                            <p class="text-gray-500 max-w-md mx-auto mb-6">
                                @if(request()->anyFilled(['role', 'verified']))
                                    Tidak ada pengguna yang sesuai dengan filter yang Anda pilih.
                                @else
                                    Belum ada pengguna yang terdaftar.
                                @endif
                            </p>
                            @if(request()->anyFilled(['role', 'verified']))
                            <div class="space-x-3">
                                <a href="{{ route('admin.users.index') }}" 
                                   class="btn btn-primary">
                                    <i class="fas fa-redo-alt mr-2"></i>
                                    Reset Filter
                                </a>
                            </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-bolt text-yellow-500"></i>
                    Aksi Cepat
                </h3>
                <p class="text-sm text-gray-500 mt-1">Manajemen pengguna cepat</p>
            </div>
            <div class="card-body">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Tambah User -->
                    <a href="{{ route('admin.users.create') }}" 
                       class="group p-5 border border-gray-200 rounded-xl hover:border-blue-300 hover:shadow-sm transition-all duration-200 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="stats-icon stats-icon-blue group-hover:bg-blue-100">
                                <i class="fas fa-user-plus text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 group-hover:text-blue-600">
                                    Tambah User
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    Tambah pengguna baru
                                </p>
                            </div>
                            <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-blue-500"></i>
                        </div>
                    </a>

                    <!-- Bulk Verification -->
                    <a href="#" 
                       onclick="return confirm('Verifikasi semua pengguna yang belum diverifikasi?')"
                       class="group p-5 border border-gray-200 rounded-xl hover:border-green-300 hover:shadow-sm transition-all duration-200 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="stats-icon stats-icon-green group-hover:bg-green-100">
                                <i class="fas fa-check-double text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 group-hover:text-green-600">
                                    Verifikasi Massal
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    Verifikasi semua user
                                </p>
                            </div>
                            <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-green-500"></i>
                        </div>
                    </a>

                    <!-- Export Data -->
                    <a href="#" 
                       class="group p-5 border border-gray-200 rounded-xl hover:border-purple-300 hover:shadow-sm transition-all duration-200 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="stats-icon stats-icon-purple group-hover:bg-purple-100">
                                <i class="fas fa-file-export text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 group-hover:text-purple-600">
                                    Export Data
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    Export data pengguna
                                </p>
                            </div>
                            <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-purple-500"></i>
                        </div>
                    </a>

                    <!-- Role Management -->
                    <a href="#" 
                       class="group p-5 border border-gray-200 rounded-xl hover:border-orange-300 hover:shadow-sm transition-all duration-200 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="stats-icon stats-icon-orange group-hover:bg-orange-100">
                                <i class="fas fa-user-cog text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 group-hover:text-orange-600">
                                    Kelola Role
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    Manajemen peran user
                                </p>
                            </div>
                            <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-orange-500"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animasi untuk stats cards
            const statsCards = document.querySelectorAll('.stats-card');
            statsCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
    @endpush
</x-app-layout>