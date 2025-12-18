<?php

namespace Modules\Katering\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Katering\Http\Resources\MenuResource;
use Modules\Katering\Services\MenuService;

/**
 * MenuController - Interface Layer
 * 
 * Clean Architecture Flow:
 * Request -> Controller -> Service (Use Case) -> Repository -> Resource
 * 
 * Controller hanya bertanggung jawab untuk:
 * 1. Menerima request
 * 2. Memanggil Service layer
 * 3. Mengembalikan response menggunakan Resource
 */
class MenuController extends Controller
{
    protected MenuService $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    /**
     * GET /api/v1/menus
     * 
     * Flow: Request -> Controller -> Service -> Repository -> Resource
     */
    public function index(): JsonResponse
    {
        // Controller calls Service
        $menus = $this->menuService->getAll();
        
        // Return using Resource
        return response()->json([
            'success' => true,
            'data' => MenuResource::collection($menus)
        ]);
    }

    /**
     * GET /api/v1/menus/{id}
     * 
     * Flow: Request -> Controller -> Service -> Repository -> Resource
     */
    public function show($id): JsonResponse
    {
        // Controller calls Service
        $menu = $this->menuService->findById($id);
        
        if (!$menu) {
            return response()->json([
                'success' => false,
                'message' => 'Menu tidak ditemukan'
            ], 404);
        }
        
        // Return using Resource
        return response()->json([
            'success' => true,
            'data' => new MenuResource($menu)
        ]);
    }
}
