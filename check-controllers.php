<?php
// check-controllers.php
$routes = [
    // API Controllers
    'App\Http\Controllers\Api\PengaduanApiController',
    'App\Http\Controllers\Api\SuratApiController',
    'App\Http\Controllers\Api\AuthApiController',
    
    // Main Controllers
    'App\Http\Controllers\ProfileController',
    'App\Http\Controllers\DashboardController',
    'App\Http\Controllers\PengaduanController',
    'App\Http\Controllers\SuratController',
    
    // Admin Controllers
    'App\Http\Controllers\Admin\PengaduanController',
    'App\Http\Controllers\Admin\SuratController',
    'App\Http\Controllers\Admin\UserController',
    'App\Http\Controllers\Admin\KategoriPengaduanController',
    'App\Http\Controllers\Admin\JenisSuratController',
    'App\Http\Controllers\Admin\DashboardController',
    
    // Petugas Controllers
    'App\Http\Controllers\Petugas\PengaduanController',
    'App\Http\Controllers\Petugas\SuratController',
];

echo "🔍 Checking Controllers...\n\n";

$missing = [];
$existing = [];

foreach ($routes as $controller) {
    $path = str_replace('App\Http\Controllers\\', '', $controller);
    $filePath = app_path('Http/Controllers/' . str_replace('\\', '/', $path) . '.php');
    
    if (file_exists($filePath)) {
        $existing[] = $controller;
        echo "✅ {$controller}\n";
    } else {
        $missing[] = $controller;
        echo "❌ {$controller}\n";
    }
}

echo "\n📊 SUMMARY:\n";
echo "✅ Existing: " . count($existing) . " controllers\n";
echo "❌ Missing: " . count($missing) . " controllers\n";

if (count($missing) > 0) {
    echo "\n🚀 Generate missing controllers with:\n";
    foreach ($missing as $controller) {
        $path = str_replace('App\Http\Controllers\\', '', $controller);
        $command = "php artisan make:controller " . str_replace('\\', '/', $path);
        echo "   {$command}\n";
    }
}