# Setup Google OAuth Login

## Langkah-Langkah Setup Google OAuth untuk Aplikasi Kelurahan Digital

### 1. Persiapan di Google Cloud Console

1. **Buka Google Cloud Console**
   - Kunjungi https://console.cloud.google.com
   - Login dengan akun Google Anda

2. **Buat Project Baru**
   - Klik pada dropdown "Select a Project" di bagian atas
   - Klik "New Project"
   - Masukkan nama: `Kelurahan Digital`
   - Klik "Create"
   - Tunggu proses pembuatan selesai

3. **Setup OAuth 2.0 Credentials**
   - Di menu sidebar, cari dan klik "APIs & Services" > "Credentials"
   - Klik tombol "Create Credentials" > "OAuth client ID"
   - Jika diminta, setup OAuth consent screen terlebih dahulu:
     - Pilih "User Type" > "External" > klik "Create"
     - Isi form:
       - **App name**: Kelurahan Digital
       - **User support email**: email@gmail.com
       - **Developer contact**: email@gmail.com
     - Klik "Save and Continue"
     - Di bagian "Scopes", klik "Save and Continue"
     - Klik "Save and Continue" lagi
     - Review dan klik "Back to Dashboard"

4. **Buat OAuth Client ID**
   - Kembali ke "Credentials" > "Create Credentials" > "OAuth client ID"
   - Pilih "Web application"
   - Isi form:
     - **Name**: Kelurahan Digital Web Client
     - **Authorized JavaScript origins**: 
       ```
       http://localhost
       http://localhost:8000
       ```
     - **Authorized redirect URIs**:
       ```
       http://localhost/auth/google/callback
       http://localhost:8000/auth/google/callback
       ```
     - (Jika di production, ganti dengan domain Anda)
   - Klik "Create"

5. **Copy Credentials**
   - Setelah berhasil, akan ada modal dengan credentials
   - **Copy Client ID** dan **Client Secret**

### 2. Setup di Laravel Application

1. **Update .env File**
   Buka file `.env` di root project dan ganti:
   ```env
   GOOGLE_CLIENT_ID=your_client_id_here
   GOOGLE_CLIENT_SECRET=your_client_secret_here
   GOOGLE_REDIRECT_URI=http://localhost/auth/google/callback
   ```

   Contoh:
   ```env
   GOOGLE_CLIENT_ID=123456789-abcdefghijklmnopqrstuvwxyz.apps.googleusercontent.com
   GOOGLE_CLIENT_SECRET=GOCSPX-1234567890abcdefghijk
   GOOGLE_REDIRECT_URI=http://localhost/auth/google/callback
   ```

2. **Jika sudah di Production**
   Ganti URL dengan domain Anda:
   ```env
   GOOGLE_REDIRECT_URI=https://yourdomain.com/auth/google/callback
   ```

### 3. Test Setup

1. **Clear Cache**
   ```bash
   php artisan config:cache
   php artisan cache:clear
   ```

2. **Akses Halaman Login**
   - Buka http://localhost/login
   - Klik tombol "Google" di bagian "atau masuk dengan"
   - Anda akan diarahkan ke halaman login Google
   - Login dengan akun Google Anda

3. **Verifikasi**
   - Setelah login sukses, Anda akan diarahkan ke `/dashboard`
   - User baru akan dibuat otomatis dengan role `warga` dan status `active`
   - Email dari akun Google akan menjadi email user
   - Status email akan otomatis `verified`

### 4. Fitur-Fitur yang Sudah Diintegrasikan

✅ **Auto User Creation**
   - User baru akan dibuat otomatis ketika login dengan Google pertama kali

✅ **Email Verification**
   - Email otomatis terverifikasi dari Google

✅ **Role Assignment**
   - Default role: `warga`
   - Dapat diubah di admin panel jika diperlukan

✅ **Token Storage**
   - Google access token disimpan di database
   - Dapat digunakan untuk keperluan future integration

✅ **Session Management**
   - User akan login otomatis dan dapat mengakses dashboard
   - Session tersimpan di database

### 5. Troubleshooting

**Error: "Gagal login dengan Google"**
- Pastikan credentials di `.env` benar
- Jalankan `php artisan config:cache`
- Pastikan GOOGLE_REDIRECT_URI sesuai dengan yang ada di Google Console

**Error: "Invalid request"**
- Pastikan URL redirect URIs di Google Console sudah ditambahkan
- Gunakan exact same URL yang ada di `.env` GOOGLE_REDIRECT_URI

**User tidak bisa login padahal Google authentication berhasil**
- Cek status_connection database apakah `active` atau `inactive`
- Cek di table users apakah user sudah dibuat

### 6. Customization (Optional)

Jika Anda ingin mengubah default role atau status, edit file:
```
app/Http/Controllers/Auth/GoogleController.php
```

Cari bagian:
```php
$user = User::create([
    'role' => 'warga', // Ubah di sini
    'status' => 'active', // Ubah di sini
]);
```

---

## Screenshots & Testing

Setelah setup selesai, Anda dapat:
1. ✅ Login dengan Google di halaman login
2. ✅ Auto create user account
3. ✅ Akses dashboard setelah login
4. ✅ Manage user di admin panel

---

**Note**: Untuk aplikasi production, pastikan menggunakan HTTPS dan update semua URL di Google Console dan `.env`
