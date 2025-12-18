<?php

namespace Modules\Katering\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Modules\Katering\Services\MenuService;
use Modules\Katering\Requests\CreateMenuRequest;
use Modules\Katering\Requests\UpdateMenuRequest;
use Modules\Katering\Entities\Katering;

/**
 * MenuController - Interface/Presentation Layer
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
class MenuController extends Controller
{
    protected MenuService $menuService;

    /**
     * Dependency Injection - Service di-inject via constructor
     */
    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    /**
     * GET /menus
     * Menampilkan semua menu
     * 
     * Flow: Request → Controller → Service → Repository → View
     */
    public function index(): View
    {
        // Call Service layer
        $menus = $this->menuService->getAll();
        
        // Return View dengan data
        return view('pages.menus', compact('menus'));
    }

    /**
     * GET /menus/{id}
     * Menampilkan detail menu
     * 
     * Flow: Request → Controller → Service → Repository → View
     */
    public function show(int $id): View
    {
        // Call Service layer
        $menu = $this->menuService->findById($id);
        
        if (!$menu) {
            abort(404, 'Menu tidak ditemukan');
        }
        
        return view('pages.menu-detail', compact('menu'));
    }

    /**
     * GET /menus/create
     * Form tambah menu baru
     */
    public function create(): View
    {
        $katerings = Katering::all();
        return view('katering::menus.create', compact('katerings'));
    }

    /**
     * POST /menus
     * Simpan menu baru
     * 
     * Flow: CreateMenuRequest (Validation) → Controller → Service → Repository
     */
    public function store(CreateMenuRequest $request): RedirectResponse
    {
        // Input sudah divalidasi oleh CreateMenuRequest
        $this->menuService->create($request->validated());
        
        return redirect()->route('menus.index')
            ->with('success', 'Menu berhasil ditambahkan!');
    }

    /**
     * GET /menus/{id}/edit
     * Form edit menu
     */
    public function edit(int $id): View
    {
        $menu = $this->menuService->findById($id);
        
        if (!$menu) {
            abort(404, 'Menu tidak ditemukan');
        }
        
        $katerings = Katering::all();
        return view('katering::menus.edit', compact('menu', 'katerings'));
    }

    /**
     * PUT /menus/{id}
     * Update menu
     * 
     * Flow: UpdateMenuRequest (Validation) → Controller → Service → Repository
     */
    public function update(UpdateMenuRequest $request, int $id): RedirectResponse
    {
        $this->menuService->update($id, $request->validated());
        
        return redirect()->route('menus.index')
            ->with('success', 'Menu berhasil diupdate!');
    }

    /**
     * DELETE /menus/{id}
     * Hapus menu
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->menuService->delete($id);
        
        return redirect()->route('menus.index')
            ->with('success', 'Menu berhasil dihapus!');
    }
}
