<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\Admin\PengaduanController as AdminPengaduanController;
use App\Http\Controllers\Admin\SuratController as AdminSuratController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\KategoriPengaduanController;
use App\Http\Controllers\Admin\JenisSuratController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Petugas\PengaduanController as PetugasPengaduanController;
use App\Http\Controllers\Petugas\SuratController as PetugasSuratController;
use Illuminate\Support\Facades\Route;

// ==================== PUBLIC ROUTES ====================
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('home');

    Route::get('/tentang', function () {
        return view('tentang');
    })->name('tentang');

    Route::get('/layanan', function () {
        return view('layanan');
    })->name('layanan');

    Route::get('/panduan', function () {
        return view('panduan');
    })->name('panduan');

    Route::get('/kontak', function () {
        return view('kontak');
    })->name('kontak');
});

// ==================== PUBLIC TRACKING ROUTES ====================
Route::get('/tracking/pengaduan/{kode}', [PengaduanController::class, 'trackPublic'])
    ->name('tracking.pengaduan')
    ->middleware('throttle:30,1');

Route::get('/tracking/surat/{nomor}', [SuratController::class, 'trackPublic'])
    ->name('tracking.surat')
    ->middleware('throttle:30,1');

// ==================== AUTHENTICATION ROUTES ====================
require __DIR__.'/auth.php';

// ==================== SECURE FILE DOWNLOAD ROUTE ====================
Route::get('/storage/{path}', function ($path) {
    // Security validation
    if (str_contains($path, '..') || str_contains($path, '//')) {
        abort(403, 'Access denied.');
    }

    $fullPath = storage_path('app/public/' . $path);
    
    if (!file_exists($fullPath) || !is_file($fullPath)) {
        abort(404);
    }

    $allowedMimes = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'zip'];
    $extension = pathinfo($fullPath, PATHINFO_EXTENSION);
    
    if (!in_array(strtolower($extension), $allowedMimes)) {
        abort(403, 'File type not allowed.');
    }

    return response()->file($fullPath);
})->where('path', '.*')->name('storage.file')->middleware('auth');

// ==================== AUTHENTICATED ROUTES ====================
Route::middleware(['auth', 'verified'])->group(function () {
    // Main Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile Management
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
        Route::patch('/photo', [ProfileController::class, 'updatePhoto'])->name('update.photo');
        Route::patch('/ktp', [ProfileController::class, 'updateKtp'])->name('update.ktp');
    });
});

// ==================== WARGA ROUTES ====================
Route::middleware(['auth', 'verified', 'role:warga'])->prefix('warga')->name('warga.')->group(function () {
    
    // PENGADUAN ROUTES
    Route::prefix('pengaduan')->name('pengaduan.')->group(function () {
        Route::get('/', [PengaduanController::class, 'index'])->name('index');
        Route::get('/buat', [PengaduanController::class, 'create'])->name('create');
        Route::post('/', [PengaduanController::class, 'store'])->name('store');
        Route::get('/{pengaduan}', [PengaduanController::class, 'show'])->name('show');
        Route::get('/{pengaduan}/edit', [PengaduanController::class, 'edit'])->name('edit');
        Route::put('/{pengaduan}', [PengaduanController::class, 'update'])->name('update');
        Route::delete('/{pengaduan}', [PengaduanController::class, 'destroy'])->name('destroy');
        Route::post('/{pengaduan}/upload-bukti', [PengaduanController::class, 'uploadBukti'])->name('upload.bukti');
        Route::get('/{pengaduan}/track', [PengaduanController::class, 'track'])->name('track');
    });

    // SURAT ROUTES
    Route::prefix('surat')->name('surat.')->group(function () {
        Route::get('/', [SuratController::class, 'index'])->name('index');
        Route::get('/ajukan', [SuratController::class, 'create'])->name('create');
        Route::post('/ajukan', [SuratController::class, 'store'])->name('store');
        Route::get('/{surat}', [SuratController::class, 'show'])->name('show');
        Route::get('/{surat}/edit', [SuratController::class, 'edit'])->name('edit');
        Route::put('/{surat}', [SuratController::class, 'update'])->name('update');
        Route::delete('/{surat}', [SuratController::class, 'destroy'])->name('destroy');
        Route::post('/{surat}/upload-syarat', [SuratController::class, 'uploadSyarat'])->name('upload.syarat');
        Route::get('/{surat}/download', [SuratController::class, 'download'])->name('download');
        Route::get('/{surat}/preview', [SuratController::class, 'preview'])->name('preview');
        Route::post('/{surat}/ajukan-verifikasi', [SuratController::class, 'ajukanVerifikasi'])->name('ajukan.verifikasi');
        Route::post('/{surat}/batalkan', [SuratController::class, 'batalkan'])->name('batalkan');
        
        // Draft Routes
        Route::get('/draft/{jenis_surat}', [SuratController::class, 'createDraft'])->name('draft.create');
        Route::post('/draft/{jenis_surat}', [SuratController::class, 'storeDraft'])->name('draft.store');
        
        // ✅ TAMBAHKAN ROUTE UNTUK RIWAYAT DAN UPDATE STATUS WARGA
        Route::get('/{surat}/riwayat', [SuratController::class, 'riwayat'])->name('riwayat');
        Route::put('/{surat}/status', [SuratController::class, 'perbaruiStatus'])->name('update.status');
    });
});

// ==================== PETUGAS ROUTES ====================
Route::middleware(['auth', 'verified', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    
    // Dashboard Petugas
    Route::get('/dashboard', [PetugasPengaduanController::class, 'dashboard'])->name('dashboard');
    
    // PENGADUAN PETUGAS
    Route::prefix('pengaduan')->name('pengaduan.')->group(function () {
        Route::get('/', [PetugasPengaduanController::class, 'index'])->name('index');
        Route::get('/tugas-saya', [PetugasPengaduanController::class, 'tugasSaya'])->name('tugas-saya');
        Route::get('/{pengaduan}', [PetugasPengaduanController::class, 'show'])->name('show');
        Route::put('/{pengaduan}/status', [PetugasPengaduanController::class, 'updateStatus'])->name('update.status');
        Route::put('/{pengaduan}/tindakan', [PetugasPengaduanController::class, 'updateTindakan'])->name('update.tindakan');
        Route::post('/{pengaduan}/upload-penanganan', [PetugasPengaduanController::class, 'uploadPenanganan'])->name('upload.penanganan');
        Route::get('/{pengaduan}/riwayat', [PetugasPengaduanController::class, 'riwayat'])->name('riwayat');
    });

    // SURAT PETUGAS - ✅ PERBAIKI BLOK INI
    Route::prefix('surat')->name('surat.')->group(function () {
        Route::get('/', [PetugasSuratController::class, 'index'])->name('index');
        Route::get('/{surat}', [PetugasSuratController::class, 'show'])->name('show');
        Route::get('/{surat}/edit', [PetugasSuratController::class, 'edit'])->name('edit');
        Route::put('/{surat}', [PetugasSuratController::class, 'update'])->name('update');
        Route::put('/{surat}/status', [PetugasSuratController::class, 'updateStatus'])->name('update.status');
        Route::put('/{surat}/proses', [PetugasSuratController::class, 'prosesSurat'])->name('proses');
        
        // ✅ TAMBAHKAN ROUTE BARU UNTUK SELESAI DAN TOLAK
        Route::put('/{surat}/selesai', [PetugasSuratController::class, 'selesai'])->name('selesai');
        Route::put('/{surat}/tolak', [PetugasSuratController::class, 'tolak'])->name('tolak');
        
        // ✅ TAMBAHKAN ROUTE UNTUK GENERATE
        Route::post('/{surat}/generate', [PetugasSuratController::class, 'generate'])->name('generate');
        Route::post('/{surat}/generate-pdf', [PetugasSuratController::class, 'generatePdf'])->name('generate.pdf');
        
        Route::get('/{surat}/preview', [PetugasSuratController::class, 'preview'])->name('preview');
        Route::get('/{surat}/riwayat', [PetugasSuratController::class, 'riwayat'])->name('riwayat');
        Route::get('/{surat}/download', [PetugasSuratController::class, 'download'])->name('download');
    });
});

// ==================== ADMIN ROUTES ====================
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Admin Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/statistik', [AdminDashboardController::class, 'statistik'])->name('statistik');
    Route::get('/laporan', [AdminDashboardController::class, 'laporan'])->name('laporan');
    Route::post('/laporan/generate', [AdminDashboardController::class, 'generateLaporan'])->name('laporan.generate');

    // USER MANAGEMENT
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('index');
        Route::get('/create', [AdminUserController::class, 'create'])->name('create');
        Route::post('/', [AdminUserController::class, 'store'])->name('store');
        Route::get('/{user}', [AdminUserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [AdminUserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [AdminUserController::class, 'update'])->name('update');
        Route::delete('/{user}', [AdminUserController::class, 'destroy'])->name('destroy');
        Route::post('/{user}/verify', [AdminUserController::class, 'verify'])->name('verify');
        Route::post('/{user}/role', [AdminUserController::class, 'updateRole'])->name('update.role');
        Route::post('/{user}/status', [AdminUserController::class, 'updateStatus'])->name('update.status');
    });

    // PENGADUAN ADMIN
    Route::prefix('pengaduan')->name('pengaduan.')->group(function () {
        Route::get('/', [AdminPengaduanController::class, 'index'])->name('index');
        Route::get('/{pengaduan}', [AdminPengaduanController::class, 'show'])->name('show');
        Route::put('/{pengaduan}/status', [AdminPengaduanController::class, 'updateStatus'])->name('update.status');
        Route::put('/{pengaduan}/prioritas', [AdminPengaduanController::class, 'updatePrioritas'])->name('update.prioritas');
        Route::put('/{pengaduan}/assign', [AdminPengaduanController::class, 'assignPetugas'])->name('assign.petugas');
        Route::put('/{pengaduan}/tindakan', [AdminPengaduanController::class, 'updateTindakan'])->name('update.tindakan');
        Route::post('/{pengaduan}/verifikasi', [AdminPengaduanController::class, 'verifikasi'])->name('verifikasi');
        Route::post('/{pengaduan}/tolak', [AdminPengaduanController::class, 'tolak'])->name('tolak');
        Route::post('/{pengaduan}/selesai', [AdminPengaduanController::class, 'selesai'])->name('selesai');
        Route::delete('/{pengaduan}', [AdminPengaduanController::class, 'destroy'])->name('destroy');
        Route::get('/{pengaduan}/riwayat', [AdminPengaduanController::class, 'riwayat'])->name('riwayat');
        
        // Export Routes
        Route::get('/export/excel', [AdminPengaduanController::class, 'exportExcel'])->name('export.excel');
        Route::get('/export/pdf', [AdminPengaduanController::class, 'exportPdf'])->name('export.pdf');
    });

    // SURAT ADMIN
    Route::prefix('surat')->name('surat.')->group(function () {
        // Quick create routes
        Route::get('/quick-create', [AdminSuratController::class, 'createQuick'])->name('quick.create');
        Route::post('/quick-create', [AdminSuratController::class, 'storeQuick'])->name('quick.store');

        Route::get('/', [AdminSuratController::class, 'index'])->name('index');
        Route::get('/{surat}', [AdminSuratController::class, 'show'])->name('show');
        Route::put('/{surat}/status', [AdminSuratController::class, 'updateStatus'])->name('update.status');
        Route::post('/{surat}/verifikasi', [AdminSuratController::class, 'verifikasi'])->name('verifikasi');
        Route::post('/{surat}/tolak', [AdminSuratController::class, 'tolak'])->name('tolak');
        Route::post('/{surat}/proses', [AdminSuratController::class, 'proses'])->name('proses');
        Route::post('/{surat}/siap-ambil', [AdminSuratController::class, 'siapAmbil'])->name('siap.ambil');
        Route::post('/{surat}/selesai', [AdminSuratController::class, 'selesai'])->name('selesai');
        Route::delete('/{surat}', [AdminSuratController::class, 'destroy'])->name('destroy');
        Route::get('/{surat}/preview', [AdminSuratController::class, 'preview'])->name('preview');
        Route::post('/{surat}/generate-pdf', [AdminSuratController::class, 'generatePdf'])->name('generate.pdf');
        Route::get('/{surat}/riwayat', [AdminSuratController::class, 'riwayat'])->name('riwayat');
        
        // Template Management
        Route::get('/{surat}/edit-template', [AdminSuratController::class, 'editTemplate'])->name('edit.template');
        Route::put('/{surat}/update-template', [AdminSuratController::class, 'updateTemplate'])->name('update.template');
        
        // ✅ TAMBAHKAN ROUTE DOWNLOAD UNTUK ADMIN
        Route::get('/{surat}/download', [AdminSuratController::class, 'download'])->name('download');
    });

    
    // Kategori Pengaduan
    Route::prefix('kategori-pengaduan')->name('kategori_pengaduan.')->group(function () {
        Route::get('/', [KategoriPengaduanController::class, 'index'])->name('index');
        Route::get('/create', [KategoriPengaduanController::class, 'create'])->name('create');
        Route::post('/', [KategoriPengaduanController::class, 'store'])->name('store');
        Route::get('/{kategoriPengaduan}/edit', [KategoriPengaduanController::class, 'edit'])->name('edit');
        Route::put('/{kategoriPengaduan}', [KategoriPengaduanController::class, 'update'])->name('update');
        Route::get('/{kategoriPengaduan}', [KategoriPengaduanController::class, 'show'])->name('show');
        Route::delete('/{kategoriPengaduan}', [KategoriPengaduanController::class, 'destroy'])->name('destroy');
        Route::put('/{kategoriPengaduan}/status', [KategoriPengaduanController::class, 'updateStatus'])->name('update.status');
    });

    // Jenis Surat
    Route::prefix('jenis-surat')->name('jenis_surat.')->group(function () {
        Route::get('/', [JenisSuratController::class, 'index'])->name('index');
        Route::get('/create', [JenisSuratController::class, 'create'])->name('create');
        Route::post('/', [JenisSuratController::class, 'store'])->name('store');
        Route::get('/{jenisSurat}', [JenisSuratController::class, 'show'])->name('show');
        Route::get('/{jenisSurat}/edit', [JenisSuratController::class, 'edit'])->name('edit');
        Route::put('/{jenisSurat}', [JenisSuratController::class, 'update'])->name('update');
        Route::delete('/{jenisSurat}', [JenisSuratController::class, 'destroy'])->name('destroy');
        Route::put('/{jenisSurat}/status', [JenisSuratController::class, 'updateStatus'])->name('update.status');
        Route::get('/{jenisSurat}/template', [JenisSuratController::class, 'editTemplate'])->name('edit.template');
        Route::put('/{jenisSurat}/template', [JenisSuratController::class, 'updateTemplate'])->name('update.template');
        Route::get('/{jenisSurat}/preview', [JenisSuratController::class, 'previewTemplate'])->name('preview.template');
    });
});

// ==================== FALLBACK ROUTE ====================
Route::fallback(function () {
    if (request()->is('api/*')) {
        return response()->json([
            'message' => 'API endpoint not found.',
            'status' => 404
        ], 404);
    }
    
    return response()->view('errors.404', [], 404);
});