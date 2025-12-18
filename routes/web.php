<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

Route::get('/', function () {
    return view('pages.home');
});

Route::get('/menus', function () {
    // Try to fetch menus from API
    try {
        $response = Http::get('http://127.0.0.1:8000/api/v1/menus');
        $menus = $response->json()['data'] ?? [];
    } catch (\Exception $e) {
        $menus = [];
    }
    
    return view('pages.menus', compact('menus'));
});

Route::get('/orders', function () {
    // Try to fetch orders from API
    try {
        $response = Http::get('http://127.0.0.1:8000/api/v1/orders?user_id=1');
        $orders = $response->json()['data'] ?? [];
    } catch (\Exception $e) {
        $orders = [];
    }
    
    return view('pages.orders', compact('orders'));
});

Route::post('/orders', function (\Illuminate\Http\Request $request) {
    try {
        $response = Http::post('http://127.0.0.1:8000/api/v1/orders', [
            'menu_id' => $request->input('menu_id'),
            'quantity' => $request->input('quantity', 1),
        ]);
        
        return redirect('/orders')->with('success', 'Pesanan berhasil dibuat!');
    } catch (\Exception $e) {
        return redirect('/orders')->with('error', 'Gagal membuat pesanan.');
    }
});
