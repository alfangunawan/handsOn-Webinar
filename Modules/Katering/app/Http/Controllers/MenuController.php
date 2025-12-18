<?php

namespace Modules\Katering\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Katering\Services\MenuService;

class MenuController extends Controller
{
    protected $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    public function index(): JsonResponse
    {
        $menus = $this->menuService->getAll();
        return response()->json([
            'data' => $menus
        ]);
    }

    public function show($id): JsonResponse
    {
        $menu = $this->menuService->findById($id);
        
        if (!$menu) {
            return response()->json(['message' => 'Menu not found'], 404);
        }
        
        return response()->json([
            'data' => $menu
        ]);
    }
}
