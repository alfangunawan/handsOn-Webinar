<?php

namespace Modules\Order\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Modules\Order\Requests\CreateOrderRequest;
use Modules\Order\Services\OrderService;

/**
 * OrderController - Interface Layer (Web)
 * 
 * Clean Architecture Flow:
 * Request (Validation) -> Controller -> Service (Use Case) -> Repository -> View
 * 
 * Controller hanya bertanggung jawab untuk:
 * 1. Menerima request (validasi di Request class)
 * 2. Memanggil Service layer
 * 3. Mengembalikan View atau Redirect
 */
class OrderController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * GET /orders
     * Menampilkan halaman daftar pesanan
     * 
     * Flow: Request -> Controller -> Service -> Repository -> View
     */
    public function index(): View
    {
        // Demo: hardcoded user_id
        $userId = 1;
        
        // Controller calls Service
        $orders = $this->orderService->getByUserId($userId);
        
        // Return View with data
        return view('pages.orders', compact('orders'));
    }

    /**
     * GET /orders/{id}
     * Menampilkan detail pesanan
     */
    public function show($id): View
    {
        // Controller calls Service
        $order = $this->orderService->findById($id);
        
        if (!$order) {
            abort(404, 'Pesanan tidak ditemukan');
        }
        
        // Return View with data
        return view('pages.order-detail', compact('order'));
    }

    /**
     * POST /orders
     * Membuat pesanan baru
     * 
     * Flow: 
     * 1. CreateOrderRequest -> Validasi input
     * 2. Controller -> Meneruskan ke Service
     * 3. OrderService -> Business logic 
     * 4. OrderRepository -> Simpan ke database
     * 5. Redirect dengan flash message
     */
    public function store(CreateOrderRequest $request): RedirectResponse
    {
        // 1. Input sudah divalidasi oleh CreateOrderRequest
        $userId = 1; // Demo: hardcoded user
        
        try {
            // 2-4. Controller -> Service -> Repository
            $this->orderService->createOrder(
                $userId,
                $request->input('menu_id'),
                $request->input('quantity')
            );
            
            // 5. Redirect dengan success message
            return redirect('/orders')->with('success', 'Pesanan berhasil dibuat!');
            
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }
}
