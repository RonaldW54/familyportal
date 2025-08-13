<?php

// ========= IMPORTS (USE-ANWEISUNGEN) ===========
use App\Http\Controllers\Admin\ApprovalController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PhotoManagementController;
use App\Http\Controllers\Admin\TextController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\BulkUploadController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FamilyApplicationController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SecureMediaController;
use App\Http\Controllers\ReportController;
use App\Http\Middleware\IsAdmin;
use App\Models\Setting;
use Illuminate\Support\Facades\Route;



// =========================================================================
// ÖFFENTLICHE ROUTEN (für jeden zugänglich)
// =========================================================================
Route::get('/', function () {
    return redirect()->route('dashboard');
});
Route::get('/test', function () {
    return view('test');
});
Route::get('/apply', [FamilyApplicationController::class, 'create'])->name('apply.create');
Route::post('/apply', [FamilyApplicationController::class, 'store'])->name('apply.store');


// =========================================================================
// AUTHENTIFIZIERTE ROUTEN (nur für eingeloggte, verifizierte User)
// =========================================================================
Route::middleware(['auth', 'verified'])->group(function () {
    
    // ---- DASHBOARD & PROFIL ----
    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ---- FOTO-VERWALTUNG (USER-SICHT) ----
    Route::get('/photos', [PhotoController::class, 'index'])->name('photos.index');
    Route::get('/shared-with-me', [PhotoController::class, 'sharedWithMe'])->name('photos.shared');
    Route::get('/photos/create', [PhotoController::class, 'create'])->name('photos.create');
    Route::post('/photos', [PhotoController::class, 'store'])->name('photos.store');
    Route::get('/photos/unprocessed', [PhotoController::class, 'unprocessed'])->name('photos.unprocessed');
    
    Route::get('/photos/upload-bulk', [BulkUploadController::class, 'create'])->name('photos.upload-bulk');
    Route::post('/photos/upload-bulk', [BulkUploadController::class, 'store'])->name('photos.upload-bulk.store');
    
    Route::get('/photos/{media}/edit', [PhotoController::class, 'edit'])->name('photos.edit');
    Route::patch('/photos/{media}', [PhotoController::class, 'update'])->name('photos.update');
    Route::delete('/photos/{media}', [PhotoController::class, 'destroy'])->name('photos.destroy');
    Route::post('/photos/{media}/rotate', [PhotoController::class, 'rotate'])->name('photos.rotate');
    Route::post('/photos/{media}/crop', [PhotoController::class, 'crop'])->name('photos.crop');
    Route::post('/photos/{media}/import-exif', [PhotoController::class, 'importExif'])->name('photos.import-exif');

    // ---- ALBUM-VERWALTUNG (USER-SICHT) ----
    Route::get('/albums', [AlbumController::class, 'index'])->name('albums.index');
    Route::post('/albums', [AlbumController::class, 'store'])->name('albums.store');
    Route::get('/albums/{album}', [AlbumController::class, 'show'])->name('albums.show');
    Route::post('/albums/ajax-create', [AlbumController::class, 'ajaxStore'])->name('albums.ajax.store');

    // ---- SICHERE MEDIENAUSLIEFERUNG ----
    Route::get('/media/{media}', [SecureMediaController::class, 'show'])->name('media.show');

    // ---- Editor für Berichte und Geschichten ----
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
});

// =========================================================================
// ADMIN ROUTEN (nur für eingeloggte Admins)
// =========================================================================
Route::middleware(['auth', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    
    // ---- ADMIN DASHBOARD & FREIGABEN ----
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/approvals', [ApprovalController::class, 'index'])->name('approvals.index');
    Route::post('/approve/{user}', [ApprovalController::class, 'approve'])->name('approvals.approve');
    Route::delete('/reject/{user}', [ApprovalController::class, 'reject'])->name('approvals.reject');

    // ---- BENUTZERVERWALTUNG ----
    Route::get('/users', function () {
        return view('admin.users.index');
    })->name('users.index');

    // ---- TEXTE & EINSTELLUNGEN ----
    // Die alten Text-Routen werden durch die neue Settings-Route ersetzt
    Route::get('/settings', \App\Livewire\Admin\SettingsManager::class)->name('settings.edit');
    
    // ---- ADMIN FOTO-VERWALTUNG ----
    Route::get('/photos', [PhotoManagementController::class, 'index'])->name('photos.manage.index');
    Route::get('/photos/{media}/edit', [PhotoManagementController::class, 'edit'])->name('photos.manage.edit');
    Route::patch('/photos/{media}', [PhotoManagementController::class, 'update'])->name('photos.manage.update');
    Route::post('/photos/{media}/reassign', [PhotoManagementController::class, 'reassign'])->name('photos.manage.reassign');

});

// =========================================================================
// AUTH-ROUTEN (von Laravel Breeze hinzugefügt)
// =========================================================================
require __DIR__.'/auth.php';