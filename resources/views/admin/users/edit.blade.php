<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Pengguna - {{ $user->name }}
            </h2>
            <div>
                <a href="{{ route('admin.users.show', $user) }}" class="bg-gray-800 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle mr-3"></i>
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle mr-3"></i>
                                <div>
                                    <strong class="font-bold">Terjadi kesalahan:</strong>
                                    <ul class="mt-1 list-disc list-inside text-sm">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('admin.users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <!-- Personal Information -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-user-circle mr-2 text-blue-600"></i>Informasi Pribadi
                                </h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Nama -->
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                            Nama Lengkap <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="name" name="name" 
                                               value="{{ old('name', $user->name) }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                               required>
                                    </div>

                                    <!-- Email -->
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                            Email <span class="text-red-500">*</span>
                                        </label>
                                        <input type="email" id="email" name="email" 
                                               value="{{ old('email', $user->email) }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                               required>
                                    </div>

                                    <!-- NIK -->
                                    <div>
                                        <label for="nik" class="block text-sm font-medium text-gray-700 mb-1">
                                            NIK
                                        </label>
                                        <input type="text" id="nik" name="nik" 
                                               value="{{ old('nik', $user->nik) }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>

                                    <!-- Telepon -->
                                    <div>
                                        <label for="telepon" class="block text-sm font-medium text-gray-700 mb-1">
                                            No. Telepon
                                        </label>
                                        <input type="tel" id="telepon" name="telepon" 
                                               value="{{ old('telepon', $user->telepon) }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>

                                    <!-- Tanggal Lahir -->
                                    <div>
                                        <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-1">
                                            Tanggal Lahir
                                        </label>
                                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" 
                                               value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>

                                    <!-- Jenis Kelamin -->
                                    <div>
                                        <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-1">
                                            Jenis Kelamin
                                        </label>
                                        <select id="jenis_kelamin" name="jenis_kelamin"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="L" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="P" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>

                                    <!-- Alamat -->
                                    <div class="md:col-span-2">
                                        <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">
                                            Alamat
                                        </label>
                                        <textarea id="alamat" name="alamat" rows="3"
                                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('alamat', $user->alamat) }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Account Information -->
                            <div class="bg-white border border-gray-200 rounded-lg p-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-user-shield mr-2 text-green-600"></i>Informasi Akun
                                </h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Role -->
                                    <div>
                                        <label for="role" class="block text-sm font-medium text-gray-700 mb-1">
                                            Role <span class="text-red-500">*</span>
                                        </label>
                                        <select id="role" name="role" required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            <option value="warga" {{ old('role', $user->role) == 'warga' ? 'selected' : '' }}>Warga</option>
                                            <option value="petugas" {{ old('role', $user->role) == 'petugas' ? 'selected' : '' }}>Petugas</option>
                                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                    </div>

                                    <!-- Status -->
                                    <div>
                                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                                            Status Akun <span class="text-red-500">*</span>
                                        </label>
                                        <select id="status" name="status" required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                                            <option value="suspended" {{ old('status', $user->status) == 'suspended' ? 'selected' : '' }}>Suspended</option>
                                        </select>
                                    </div>

                                    <!-- Verified Status -->
                                    <div class="md:col-span-2">
                                        <div class="flex items-center">
                                            <input type="checkbox" id="is_verified" name="is_verified" 
                                                   value="1" {{ old('is_verified', $user->is_verified) ? 'checked' : '' }}
                                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                            <label for="is_verified" class="ml-2 block text-sm text-gray-900">
                                                Akun sudah diverifikasi
                                            </label>
                                        </div>
                                        <p class="mt-1 text-sm text-gray-500">
                                            Centang jika user sudah melakukan verifikasi email/NIK
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Password Reset (Optional) -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-key mr-2 text-yellow-600"></i>Reset Password (Opsional)
                                </h3>
                                
                                <div class="space-y-4">
                                    <p class="text-sm text-gray-600">
                                        Kosongkan field password jika tidak ingin mengubah password user.
                                    </p>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                                Password Baru
                                            </label>
                                            <input type="password" id="password" name="password"
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                                   autocomplete="new-password">
                                        </div>

                                        <div>
                                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                                                Konfirmasi Password
                                            </label>
                                            <input type="password" id="password_confirmation" name="password_confirmation"
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                                   autocomplete="new-password">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                                <div class="text-sm text-gray-600">
                                    <p>User ID: <span class="font-mono">{{ $user->id }}</span></p>
                                    <p>Bergabung: {{ $user->created_at->format('d F Y H:i') }}</p>
                                </div>
                                
                                <div class="flex space-x-3">
                                    <a href="{{ route('admin.users.show', $user) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        <i class="fas fa-times mr-2"></i>Batal
                                    </a>
                                    <button type="submit" 
                                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Show/hide password fields if needed
        document.addEventListener('DOMContentLoaded', function() {
            const passwordToggle = document.getElementById('reset_password_toggle');
            const passwordFields = document.getElementById('password_fields');
            
            if (passwordToggle && passwordFields) {
                passwordToggle.addEventListener('change', function() {
                    passwordFields.classList.toggle('hidden', !this.checked);
                });
            }
            
            // Format NIK input
            const nikInput = document.getElementById('nik');
            if (nikInput) {
                nikInput.addEventListener('input', function(e) {
                    // Remove non-numeric characters
                    this.value = this.value.replace(/\D/g, '');
                });
            }
            
            // Format phone input
            const phoneInput = document.getElementById('telepon');
            if (phoneInput) {
                phoneInput.addEventListener('input', function(e) {
                    // Remove non-numeric characters except plus sign at start
                    if (this.value.startsWith('+')) {
                        this.value = '+' + this.value.slice(1).replace(/\D/g, '');
                    } else {
                        this.value = this.value.replace(/\D/g, '');
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>