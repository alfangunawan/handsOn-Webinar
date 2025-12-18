<?php

namespace Modules\Order\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Order\Requests\CreateOrderRequest;
use Modules\Order\Services\OrderService;

/**
 * OrderController - Interface Layer (Web)
 * 
 * Clean Architecture Flow:
 * Request (Validation) -> Controller -> Service (Use Case) -> Repository -> View
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
     * Menampilkan halaman daftar pesanan user yang login
     */
    public function index(): View
    {
        // Gunakan ID user yang login
        $userId = Auth::id();
        
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
        $order = $this->orderService->findById($id);
        
        // Pastikan order milik user yang login
        if (!$order || $order->user_id !== Auth::id()) {
            abort(404, 'Pesanan tidak ditemukan');
        }
        
        return view('pages.order-detail', compact('order'));
    }

    /**
     * POST /orders
     * Membuat pesanan baru
     */
    public function store(CreateOrderRequest $request): RedirectResponse
    {
        // Gunakan ID user yang login
        $userId = Auth::id();
        
        try {
            $this->orderService->createOrder(
                $userId,
                $request->input('menu_id'),
                $request->input('quantity')
            );
            
            return redirect()->route('orders.index')
                ->with('success', 'Pesanan berhasil dibuat!');
            
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }
}
