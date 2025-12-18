<?php

use Illuminate\Support\Facades\Route;
use Modules\Katering\Http\Controllers\KateringController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('katerings', KateringController::class)->names('katering');
});
