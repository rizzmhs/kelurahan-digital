<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
    @csrf
    @method('patch')

    <!-- Name -->
    <div>
        <x-input-label for="name" :value="__('Nama Lengkap')" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" 
            :value="old('name', $user->name)" required autofocus autocomplete="name" />
        <x-input-error class="mt-2" :messages="$errors->get('name')" />
    </div>

    <!-- Email -->
    <div>
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" 
            :value="old('email', $user->email)" required autocomplete="username" />
        <x-input-error class="mt-2" :messages="$errors->get('email')" />
    </div>

    <!-- NIK (hanya jika kosong) -->
    @if(empty($user->nik))
    <div>
        <x-input-label for="nik" :value="__('NIK')" />
        <x-text-input id="nik" name="nik" type="text" class="mt-1 block w-full" 
            :value="old('nik')" required />
        <x-input-error class="mt-2" :messages="$errors->get('nik')" />
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            NIK 16 digit. Hanya bisa diisi sekali.
        </p>
    </div>
    @else
    <div>
        <x-input-label for="nik" :value="__('NIK')" />
        <x-text-input id="nik" type="text" class="mt-1 block w-full bg-gray-100 dark:bg-gray-700" 
            :value="$user->nik" readonly disabled />
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            NIK tidak dapat diubah.
        </p>
    </div>
    @endif

    <!-- Telepon -->
    <div>
        <x-input-label for="telepon" :value="__('Nomor Telepon')" />
        <x-text-input id="telepon" name="telepon" type="tel" class="mt-1 block w-full" 
            :value="old('telepon', $user->telepon)" required />
        <x-input-error class="mt-2" :messages="$errors->get('telepon')" />
    </div>

    <!-- Tanggal Lahir -->
    <div>
        <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
        <x-text-input id="tanggal_lahir" name="tanggal_lahir" type="date" class="mt-1 block w-full" 
            :value="old('tanggal_lahir', $user->tanggal_lahir?->format('Y-m-d'))" required />
        <x-input-error class="mt-2" :messages="$errors->get('tanggal_lahir')" />
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Minimal usia 17 tahun.
        </p>
    </div>

    <!-- Jenis Kelamin -->
    <div>
        <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
        <select id="jenis_kelamin" name="jenis_kelamin" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
            <option value="">Pilih Jenis Kelamin</option>
            <option value="L" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
            <option value="P" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('jenis_kelamin')" />
    </div>

    <!-- Alamat -->
    <div>
        <x-input-label for="alamat" :value="__('Alamat Lengkap')" />
        <textarea id="alamat" name="alamat" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>{{ old('alamat', $user->alamat) }}</textarea>
        <x-input-error class="mt-2" :messages="$errors->get('alamat')" />
    </div>

    <!-- Foto KTP saat ini -->
    @if($user->foto_ktp)
    <div>
        <x-input-label :value="__('Foto KTP Saat Ini')" />
        <div class="mt-2">
            @if(str_ends_with($user->foto_ktp, '.pdf'))
            <div class="flex items-center p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                <svg class="w-8 h-8 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                </svg>
                <div>
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">File PDF</p>
                    <a href="{{ Storage::url($user->foto_ktp) }}" target="_blank" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">Lihat PDF</a>
                </div>
            </div>
            @else
            <img src="{{ Storage::url($user->foto_ktp) }}" alt="Foto KTP" class="max-w-xs rounded-lg shadow-sm">
            @endif
        </div>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Unggah file baru hanya jika ingin mengganti.
        </p>
    </div>
    @endif

    <!-- Foto KTP Baru (Opsional) -->
    <div>
        <x-input-label for="foto_ktp" :value="__('Foto KTP') . ($user->foto_ktp ? ' Baru (Opsional)' : '')" />
        <x-text-input id="foto_ktp" name="foto_ktp" type="file" class="mt-1 block w-full" 
            accept=".jpg,.jpeg,.png,.pdf" {{ !$user->foto_ktp ? 'required' : '' }} />
        <x-input-error class="mt-2" :messages="$errors->get('foto_ktp')" />
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            {{ $user->foto_ktp ? 'Biarkan kosong jika tidak ingin mengganti. ' : '' }}
            Format: JPG, PNG, PDF. Maks: 2MB
        </p>
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>

        @if (session('status') === 'profile-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-green-600 dark:text-green-400"
            >
                {{ __('Profile berhasil diperbarui.') }}
            </p>
        @endif
    </div>
</form>