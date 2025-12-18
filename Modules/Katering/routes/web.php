<?php

use Illuminate\Support\Facades\Route;
use Modules\Katering\Http\Controllers\MenuController;

/*
|--------------------------------------------------------------------------
| Web Routes - Katering Module
|--------------------------------------------------------------------------
|
| Clean Architecture Flow:
| Request -> Controller -> Service -> Repository -> View
|
*/

Route::get('/menus', [MenuController::class, 'index'])->name('menus.index');
Route::get('/menus/{id}', [MenuController::class, 'show'])->name('menus.show');
