<?php

use App\Http\Controllers\Admin\CrawlApiController as AdminCrawlApiController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DataRecordController as AdminDataRecordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Superadmin\CrawlApiController;
use App\Http\Controllers\Superadmin\DashboardController as SuperadminDashboardController;
use App\Http\Controllers\Superadmin\DataFieldController;
use App\Http\Controllers\Superadmin\DataTypeController;
use App\Http\Controllers\Superadmin\SuperadminDataRecordController;
use App\Http\Controllers\Superadmin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Redirect /dashboard based on role
Route::get('/dashboard', function () {
    if (auth()->check()) {
        return auth()->user()->isSuperadmin()
            ? redirect()->route('superadmin.dashboard')
            : redirect()->route('admin.dashboard');
    }
    return redirect()->route('login');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes (from Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ========================================
// Superadmin Routes
// ========================================
Route::middleware(['auth', 'verified'])->prefix('superadmin')->name('superadmin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [SuperadminDashboardController::class, 'index'])->name('dashboard');

    // Data Types CRUD
    Route::resource('data-types', DataTypeController::class);

    // Data Fields (nested under Data Type)
    Route::prefix('data-types/{dataType}/fields')->name('data-types.fields.')->group(function () {
        Route::get('/', [DataFieldController::class, 'index'])->name('index');
        Route::get('/create', [DataFieldController::class, 'create'])->name('create');
        Route::post('/', [DataFieldController::class, 'store'])->name('store');
        Route::get('/{field}/edit', [DataFieldController::class, 'edit'])->name('edit');
        Route::put('/{field}', [DataFieldController::class, 'update'])->name('update');
        Route::delete('/{field}', [DataFieldController::class, 'destroy'])->name('destroy');
    });

    // Data Records (nested under Data Type) - Superadmin can access ALL
    Route::prefix('data-types/{dataType}/records')->name('data-types.records.')->group(function () {
        Route::get('/', [SuperadminDataRecordController::class, 'index'])->name('index');
        Route::get('/create', [SuperadminDataRecordController::class, 'create'])->name('create');
        Route::post('/', [SuperadminDataRecordController::class, 'store'])->name('store');
        Route::get('/{record}/edit', [SuperadminDataRecordController::class, 'edit'])->name('edit');
        Route::put('/{record}', [SuperadminDataRecordController::class, 'update'])->name('update');
        Route::delete('/{record}', [SuperadminDataRecordController::class, 'destroy'])->name('destroy');
        Route::get('/export', [SuperadminDataRecordController::class, 'index'])->name('export'); // export via ?export=excel
    });

    // Users Management
    Route::resource('users', UserController::class);

    // Crawl & API
    Route::get('/crawl-api', [CrawlApiController::class, 'index'])->name('crawl-api.index');
});

// ========================================
// Admin Data Routes
// ========================================
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Crawl & API
    Route::get('/crawl-api', [AdminCrawlApiController::class, 'index'])->name('crawl-api.index');

    // Data Records (nested under Data Type) - Admin only sees assigned types
    Route::prefix('data-types/{dataType}/records')->name('data-types.records.')->group(function () {
        Route::get('/', [AdminDataRecordController::class, 'index'])->name('index');
        Route::get('/create', [AdminDataRecordController::class, 'create'])->name('create');
        Route::post('/', [AdminDataRecordController::class, 'store'])->name('store');
        Route::get('/{record}/edit', [AdminDataRecordController::class, 'edit'])->name('edit');
        Route::put('/{record}', [AdminDataRecordController::class, 'update'])->name('update');
        Route::delete('/{record}', [AdminDataRecordController::class, 'destroy'])->name('destroy');
        Route::get('/export', [AdminDataRecordController::class, 'index'])->name('export'); // export via ?export=excel
    });
});

require __DIR__.'/auth.php';