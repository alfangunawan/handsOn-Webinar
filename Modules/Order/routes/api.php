<?php

use Illuminate\Support\Facades\Route;
use Modules\Order\Http\Controllers\OrderController;

Route::prefix('v1')->group(function () {
    Route::get('orders', [OrderController::class, 'index'])->name('order.orders.index');
    Route::get('orders/{id}', [OrderController::class, 'show'])->name('order.orders.show');
    Route::post('orders', [OrderController::class, 'store'])->name('order.orders.store');
});
