<?php

use Illuminate\Support\Facades\Route;
use Modules\Katering\Http\Controllers\MenuController;

Route::prefix('v1')->group(function () {
    Route::get('menus', [MenuController::class, 'index'])->name('katering.menus.index');
    Route::get('menus/{id}', [MenuController::class, 'show'])->name('katering.menus.show');
});
