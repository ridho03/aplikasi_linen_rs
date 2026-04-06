<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Models\Tenant;
use App\Http\Controllers\RfidController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ScanController;

Route::get('/scan/realtime', [RfidController::class, 'realtime']);

Route::get('/scan', [ScanController::class, 'index']);
Route::get('/api/scan', [RfidController::class, 'scan']);
Route::get('/rfid/latest', [RfidController::class, 'getLatestRfid']);

Route::post('/admin', [AdminController::class, 'store']);


Route::middleware(['auth'])->group(function () {
    Route::get('/tenant', [TenantController::class, 'index']);
    Route::get('/tenant/create', [TenantController::class, 'create']);
    Route::post('/tenant', [TenantController::class, 'store']);
    Route::delete('/tenant/{id}', [TenantController::class, 'destroy']);
});

Route::post('/rfid/tag/store', [RfidController::class, 'storeTag'])->middleware('auth');
Route::get('/rfid/tag', [RfidController::class, 'formTag'])->middleware('auth');

Route::get('/rfid/tag', [RfidController::class, 'formTag']);
Route::post('/rfid/tag', [RfidController::class, 'storeTag']);

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/admin/create', function () {

    $tenants = Tenant::all();

    return view('admin.create', compact('tenants'));
});

    Route::post('/admin/store', [App\Http\Controllers\AdminController::class, 'store']);
});

Route::get('/export', [DashboardController::class, 'export'])->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
