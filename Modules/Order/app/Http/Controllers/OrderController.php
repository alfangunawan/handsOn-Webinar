<?php

namespace Modules\Order\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Order\Requests\CreateOrderRequest;
use Modules\Order\Http\Resources\OrderResource;
use Modules\Order\Services\OrderService;

/**
 * OrderController - Interface Layer
 * 
 * Clean Architecture Flow:
 * Request (Validation) -> Controller -> Service (Use Case) -> Repository -> Resource
 * 
 * Controller hanya bertanggung jawab untuk:
 * 1. Menerima request (validasi di Request class)
 * 2. Memanggil Service layer
 * 3. Mengembalikan response menggunakan Resource
 */
class OrderController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * GET /api/v1/orders
     * 
     * Flow: Request -> Controller -> Service -> Repository -> Resource
     */
    public function index(Request $request): JsonResponse
    {
        // 1. Request: Get validated query parameter
        $userId = (int) $request->query('user_id', 1);
        
        // 2. Controller calls Service
        $orders = $this->orderService->getByUserId($userId);
        
        // 3. Return using Resource
        return response()->json([
            'success' => true,
            'data' => OrderResource::collection($orders)
        ]);
    }

    /**
     * GET /api/v1/orders/{id}
     * 
     * Flow: Request -> Controller -> Service -> Repository -> Resource
     */
    public function show($id): JsonResponse
    {
        // Controller calls Service
        $order = $this->orderService->findById($id);
        
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan'
            ], 404);
        }
        
        // Return using Resource
        return response()->json([
            'success' => true,
            'data' => new OrderResource($order)
        ]);
    }

    /**
     * POST /api/v1/orders
     * 
     * Flow: 
     * 1. CreateOrderRequest -> Validasi input
     * 2. Controller -> Meneruskan ke Service
     * 3. OrderService -> Business logic 
     * 4. OrderRepository -> Simpan ke database
     * 5. OrderResource -> Format response
     */
    public function store(CreateOrderRequest $request): JsonResponse
    {
        // 1. Input sudah divalidasi oleh CreateOrderRequest
        $userId = 1; // Demo: hardcoded user
        
        try {
            // 2-4. Controller -> Service -> Repository
            $order = $this->orderService->createOrder(
                $userId,
                $request->input('menu_id'),
                $request->input('quantity')
            );
            
            // 5. Return using Resource
            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibuat',
                'data' => new OrderResource($order)
            ], 201);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
