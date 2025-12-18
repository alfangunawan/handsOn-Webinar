<?php

use Illuminate\Support\Facades\Route;
use Modules\Katering\Http\Controllers\MenuController;
use Modules\Katering\Http\Controllers\KateringController;

/*
|--------------------------------------------------------------------------
| Web Routes - Katering Module
|--------------------------------------------------------------------------
|
| Clean Architecture Flow:
| Request -> Controller -> Service -> Repository -> View
|
| NOTE: Specific routes (like /menus/create) MUST be before 
|       wildcard routes (like /menus/{id}) to avoid conflicts
|
*/

// ==================== KATERING ROUTES ====================

// Protected routes for Katering - requires authentication (defined first!)
Route::middleware(['auth'])->group(function () {
    Route::get('/katerings/create', [KateringController::class, 'create'])->name('katerings.create');
    Route::post('/katerings', [KateringController::class, 'store'])->name('katerings.store');
    Route::get('/katerings/{id}/edit', [KateringController::class, 'edit'])->name('katerings.edit');
    Route::put('/katerings/{id}', [KateringController::class, 'update'])->name('katerings.update');
    Route::delete('/katerings/{id}', [KateringController::class, 'destroy'])->name('katerings.destroy');
});

// Public routes for Katering
Route::get('/katerings', [KateringController::class, 'index'])->name('katerings.index');
Route::get('/katerings/{id}', [KateringController::class, 'show'])->name('katerings.show');


// ==================== MENU ROUTES ====================

// Protected routes for Menu - requires authentication (defined first!)
Route::middleware(['auth'])->group(function () {
    Route::get('/menus/create', [MenuController::class, 'create'])->name('menus.create');
    Route::post('/menus', [MenuController::class, 'store'])->name('menus.store');
    Route::get('/menus/{id}/edit', [MenuController::class, 'edit'])->name('menus.edit');
    Route::put('/menus/{id}', [MenuController::class, 'update'])->name('menus.update');
    Route::delete('/menus/{id}', [MenuController::class, 'destroy'])->name('menus.destroy');
});

// Public routes for Menu - accessible by everyone (wildcard route at the end)
Route::get('/menus', [MenuController::class, 'index'])->name('menus.index');
Route::get('/menus/{id}', [MenuController::class, 'show'])->name('menus.show');


