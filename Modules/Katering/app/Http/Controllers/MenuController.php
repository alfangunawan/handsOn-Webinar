<?php

namespace Modules\Katering\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Routing\Controller;
use Modules\Katering\Services\MenuService;

/**
 * MenuController - Interface Layer (Web)
 * 
 * Clean Architecture Flow:
 * Request -> Controller -> Service (Use Case) -> Repository -> View
 * 
 * Controller hanya bertanggung jawab untuk:
 * 1. Menerima request
 * 2. Memanggil Service layer
 * 3. Mengembalikan View dengan data
 */
class MenuController extends Controller
{
    protected MenuService $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    /**
     * GET /menus
     * Menampilkan halaman daftar menu
     * 
     * Flow: Request -> Controller -> Service -> Repository -> View
     */
    public function index(): View
    {
        // Controller calls Service
        $menus = $this->menuService->getAll();
        
        // Return View with data
        return view('pages.menus', compact('menus'));
    }

    /**
     * GET /menus/{id}
     * Menampilkan detail menu
     */
    public function show($id): View
    {
        // Controller calls Service
        $menu = $this->menuService->findById($id);
        
        if (!$menu) {
            abort(404, 'Menu tidak ditemukan');
        }
        
        // Return View with data
        return view('pages.menu-detail', compact('menu'));
    }
}
