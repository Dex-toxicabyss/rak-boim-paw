<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaundryStorageController;
use App\Http\Controllers\RackController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\StorageLogController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard (Pemilik & Staf)
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('role:pemilik,staf')
        ->name('dashboard');

    // Transaksi Penataan Rak (Create, Read, Update untuk Pemilik & Staf)
    Route::middleware('role:pemilik,staf')->group(function () {
        Route::get('/laundry-storages', [LaundryStorageController::class, 'index'])->name('storages.index');
        Route::get('/laundry-storages/create', [LaundryStorageController::class, 'create'])->name('storages.create');
        Route::post('/laundry-storages', [LaundryStorageController::class, 'store'])->name('storages.store');
        Route::get('/laundry-storages/{laundryStorage}/edit', [LaundryStorageController::class, 'edit'])->name('storages.edit');
        Route::put('/laundry-storages/{laundryStorage}', [LaundryStorageController::class, 'update'])->name('storages.update');

        // Read-only Daftar Rak & Daftar Tarif untuk Staf (Pemilik juga bisa akses)
        Route::get('/racks', [RackController::class, 'index'])->name('racks.index');
        Route::get('/service-categories', [ServiceCategoryController::class, 'index'])->name('categories.index');

        // Log Serah Terima & Verifikasi Setrika
        Route::get('/storage-logs', [StorageLogController::class, 'index'])->name('logs.index');
        Route::post('/storage-logs', [StorageLogController::class, 'store'])->name('logs.store');
    });

    // Rute Khusus Pemilik (Dilindungi Middleware role:pemilik -> HTTP 403 untuk Staf)
    Route::middleware('role:pemilik')->group(function () {
        // Hapus Arsip Cucian Selesai
        Route::delete('/laundry-storages/{laundryStorage}', [LaundryStorageController::class, 'destroy'])
            ->name('storages.destroy');

        // CRUD Master ID Rak & Lemari
        Route::get('/racks/create', [RackController::class, 'create'])->name('racks.create');
        Route::post('/racks', [RackController::class, 'store'])->name('racks.store');
        Route::get('/racks/{rack}/edit', [RackController::class, 'edit'])->name('racks.edit');
        Route::put('/racks/{rack}', [RackController::class, 'update'])->name('racks.update');
        Route::delete('/racks/{rack}', [RackController::class, 'destroy'])->name('racks.destroy');

        // CRUD Master Tarif Layanan
        Route::get('/service-categories/create', [ServiceCategoryController::class, 'create'])->name('categories.create');
        Route::post('/service-categories', [ServiceCategoryController::class, 'store'])->name('categories.store');
        Route::get('/service-categories/{serviceCategory}/edit', [ServiceCategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/service-categories/{serviceCategory}', [ServiceCategoryController::class, 'update'])->name('categories.update');
        Route::delete('/service-categories/{serviceCategory}', [ServiceCategoryController::class, 'destroy'])->name('categories.destroy');

        // CRUD Master User
        Route::resource('/users', UserController::class)->except(['show']);

        // Laporan & Export CSV / PDF
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/export-csv', [ReportController::class, 'exportCsv'])->name('reports.csv');
        Route::get('/reports/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.pdf');
    });
});
