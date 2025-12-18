<?php

namespace Modules\Order\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Order\Services\OrderService;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request): JsonResponse
    {
        $userId = $request->query('user_id', 1);
        $orders = $this->orderService->getByUserId((int) $userId);
        
        return response()->json([
            'data' => $orders
        ]);
    }

    public function show($id): JsonResponse
    {
        $order = $this->orderService->findById($id);
        
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        
        return response()->json([
            'data' => $order
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'menu_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $userId = 1; // Hardcoded for demo
        
        try {
            $order = $this->orderService->createOrder(
                $userId,
                $request->input('menu_id'),
                $request->input('quantity')
            );
            
            return response()->json([
                'message' => 'Order created successfully',
                'data' => $order
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
