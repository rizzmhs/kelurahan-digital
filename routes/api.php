<?php

use App\Http\Controllers\Api\PengaduanApiController;
use App\Http\Controllers\Api\SuratApiController;
use App\Http\Controllers\Api\AuthApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ==================== PUBLIC API ROUTES ====================

// Health Check Endpoint
Route::get('/health', function () {
    return response()->json([
        'status' => 'OK', 
        'timestamp' => now(),
        'service' => 'Laravel API',
        'version' => '1.0'
    ]);
});

// API Status
Route::get('/status', function () {
    return response()->json([
        'message' => 'API Service is running',
        'version' => '1.0'
    ]);
});

// ==================== VERSION 1 API ROUTES ====================
Route::prefix('v1')->group(function () {
    
    // ========== PUBLIC AUTH ENDPOINTS ==========
    Route::post('/login', [AuthApiController::class, 'login']);
    Route::post('/register', [AuthApiController::class, 'register']);
    
    // ========== PUBLIC TRACKING ENDPOINTS ==========
    Route::get('/tracking/pengaduan/{kode}', [PengaduanApiController::class, 'trackPublic'])
        ->name('api.tracking.pengaduan');
    
    Route::get('/tracking/surat/{nomor}', [SuratApiController::class, 'trackPublic'])
        ->name('api.tracking.surat');
    
    // ========== PUBLIC INFORMATION ENDPOINTS ==========
    Route::get('/info/jenis-surat', [SuratApiController::class, 'getJenisSurat'])
        ->name('api.info.jenis_surat');
    
    Route::get('/info/kategori-pengaduan', [PengaduanApiController::class, 'getKategoriPengaduan'])
        ->name('api.info.kategori_pengaduan');

    // ========== PROTECTED API ENDPOINTS ==========
    Route::middleware(['auth:sanctum', 'throttle:120,1'])->group(function () {
        
        // ===== AUTH MANAGEMENT =====
        Route::post('/logout', [AuthApiController::class, 'logout'])
            ->name('api.logout');
        
        Route::post('/refresh-token', [AuthApiController::class, 'refreshToken'])
            ->name('api.refresh.token');
        
        // ===== PROFILE MANAGEMENT =====
        Route::prefix('profile')->name('api.profile.')->group(function () {
            Route::get('/', [AuthApiController::class, 'profile'])
                ->name('show');
            
            Route::put('/', [AuthApiController::class, 'updateProfile'])
                ->name('update');
            
            Route::patch('/photo', [AuthApiController::class, 'updatePhoto'])
                ->name('update.photo');
            
            Route::patch('/ktp', [AuthApiController::class, 'updateKtp'])
                ->name('update.ktp');
            
            Route::put('/password', [AuthApiController::class, 'updatePassword'])
                ->name('update.password');
        });

        // ===== DASHBOARD DATA =====
        Route::prefix('dashboard')->name('api.dashboard.')->group(function () {
            Route::get('/stats', [AuthApiController::class, 'dashboardStats'])
                ->name('stats');
            
            Route::get('/recent-activities', [AuthApiController::class, 'recentActivities'])
                ->name('recent.activities');
        });

        // ===== PENGADUAN MANAGEMENT =====
        Route::prefix('pengaduan')->name('api.pengaduan.')->group(function () {
            // CRUD Operations
            Route::get('/', [PengaduanApiController::class, 'index'])
                ->name('index');
            
            Route::post('/', [PengaduanApiController::class, 'store'])
                ->name('store');
            
            Route::get('/{pengaduan}', [PengaduanApiController::class, 'show'])
                ->name('show');
            
            Route::put('/{pengaduan}', [PengaduanApiController::class, 'update'])
                ->name('update');
            
            Route::delete('/{pengaduan}', [PengaduanApiController::class, 'destroy'])
                ->name('destroy');
            
            // Additional Actions
            Route::post('/{pengaduan}/upload-bukti', [PengaduanApiController::class, 'uploadBukti'])
                ->name('upload.bukti');
            
            Route::get('/{pengaduan}/track', [PengaduanApiController::class, 'track'])
                ->name('track');
            
            Route::get('/{pengaduan}/riwayat', [PengaduanApiController::class, 'riwayat'])
                ->name('riwayat');
        });

        // ===== SURAT MANAGEMENT =====
        Route::prefix('surat')->name('api.surat.')->group(function () {
            // CRUD Operations
            Route::get('/', [SuratApiController::class, 'index'])
                ->name('index');
            
            Route::post('/', [SuratApiController::class, 'store'])
                ->name('store');
            
            Route::get('/{surat}', [SuratApiController::class, 'show'])
                ->name('show');
            
            Route::put('/{surat}', [SuratApiController::class, 'update'])
                ->name('update');
            
            Route::delete('/{surat}', [SuratApiController::class, 'destroy'])
                ->name('destroy');
            
            // Additional Actions
            Route::post('/{surat}/upload-syarat', [SuratApiController::class, 'uploadSyarat'])
                ->name('upload.syarat');
            
            Route::get('/{surat}/download', [SuratApiController::class, 'download'])
                ->name('download');
            
            Route::get('/{surat}/preview', [SuratApiController::class, 'preview'])
                ->name('preview');
            
            Route::post('/{surat}/ajukan-verifikasi', [SuratApiController::class, 'ajukanVerifikasi'])
                ->name('ajukan.verifikasi');
            
            Route::post('/{surat}/batalkan', [SuratApiController::class, 'batalkan'])
                ->name('batalkan');
            
            Route::get('/{surat}/riwayat', [SuratApiController::class, 'riwayat'])
                ->name('riwayat');
            
            // Draft Management
            Route::post('/draft/{jenis_surat}', [SuratApiController::class, 'storeDraft'])
                ->name('draft.store');
        });

        // ===== NOTIFICATIONS =====
        Route::prefix('notifications')->name('api.notifications.')->group(function () {
            Route::get('/', [AuthApiController::class, 'notifications'])
                ->name('index');
            
            Route::put('/{id}/read', [AuthApiController::class, 'markAsRead'])
                ->name('mark.read');
            
            Route::post('/mark-all-read', [AuthApiController::class, 'markAllAsRead'])
                ->name('mark.all.read');
        });
    });
});

// ==================== USER ENDPOINT ====================
Route::get('/user', function (Request $request) {
    return response()->json([
        'user' => $request->user(),
        'permissions' => $request->user()?->getAllPermissions()->pluck('name'),
        'roles' => $request->user()?->getRoleNames()
    ]);
})->middleware('auth:sanctum');

// ==================== API FALLBACK ROUTE ====================
Route::fallback(function () {
    return response()->json([
        'message' => 'API endpoint not found.',
        'status' => 404,
        'available_versions' => ['v1'],
        'documentation' => url('/api/docs')
    ], 404);
});