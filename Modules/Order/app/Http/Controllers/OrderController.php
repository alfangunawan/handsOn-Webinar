<?php

namespace Modules\Order\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Order\Requests\CreateOrderRequest;
use Modules\Order\Requests\UpdateOrderRequest;
use Modules\Order\Services\OrderService;

/**
 * OrderController - Interface/Presentation Layer
 * 
 * ┌─────────────────────────────────────────────────────────────────┐
 * │                    CLEAN ARCHITECTURE FLOW                      │
 * ├─────────────────────────────────────────────────────────────────┤
 * │  Request (Validation) → Controller (this) → Service → Repository│
 * └─────────────────────────────────────────────────────────────────┘
 * 
 * Controller bertanggung jawab untuk:
 * 1. Menerima HTTP Request (validasi via Request class)
 * 2. Memanggil Service layer
 * 3. Mengembalikan Response (View atau Redirect)
 * 
 * Controller TIDAK boleh:
 * - Mengandung business logic
 * - Mengakses database langsung
 */
class OrderController extends Controller
{
    protected OrderService $orderService;

    /**
     * Dependency Injection - Service di-inject via constructor
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * GET /orders
     * Menampilkan semua pesanan user yang login
     * 
     * Flow: Request → Controller → Service → Repository → View
     */
    public function index(): View
    {
        // Ambil user ID dari Auth (sudah login karena middleware)
        $userId = Auth::id();
        
        // Call Service layer
        $orders = $this->orderService->getByUserId($userId);
        
        // Return View dengan data
        return view('pages.orders', compact('orders'));
    }

    /**
     * GET /orders/{id}
     * Menampilkan detail pesanan
     * 
     * Flow: Request → Controller → Service → Repository → View
     */
    public function show(int $id): View
    {
        // Call Service layer
        $order = $this->orderService->findById($id);
        
        // Validasi: order harus milik user yang login
        if (!$order || $order->user_id !== Auth::id()) {
            abort(404, 'Pesanan tidak ditemukan');
        }
        
        return view('pages.order-detail', compact('order'));
    }

    /**
     * POST /orders
     * Membuat pesanan baru
     * 
     * Flow: CreateOrderRequest (Validation) → Controller → Service → Repository
     * 
     * Business Logic di Service:
     * - Validasi menu exists
     * - Hitung total harga
     * - Set status pending
     */
    public function store(CreateOrderRequest $request): RedirectResponse
    {
        // Input sudah divalidasi oleh CreateOrderRequest
        $userId = Auth::id();
        
        try {
            // Call Service layer dengan business logic
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

    /**
     * PUT /orders/{id}
     * Update status pesanan
     * 
     * Flow: UpdateOrderRequest (Validation) → Controller → Service → Repository
     */
    public function update(UpdateOrderRequest $request, int $id): RedirectResponse
    {
        $order = $this->orderService->findById($id);
        
        // Validasi: order harus milik user yang login
        if (!$order || $order->user_id !== Auth::id()) {
            abort(404, 'Pesanan tidak ditemukan');
        }
        
        try {
            $this->orderService->updateStatus($id, $request->input('status'));
            
            return redirect()->route('orders.index')
                ->with('success', 'Status pesanan berhasil diupdate!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * DELETE /orders/{id}
     * Batalkan pesanan
     */
    public function destroy(int $id): RedirectResponse
    {
        $order = $this->orderService->findById($id);
        
        if (!$order || $order->user_id !== Auth::id()) {
            abort(404, 'Pesanan tidak ditemukan');
        }
        
        try {
            $this->orderService->cancel($id);
            
            return redirect()->route('orders.index')
                ->with('success', 'Pesanan berhasil dibatalkan!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }
}
