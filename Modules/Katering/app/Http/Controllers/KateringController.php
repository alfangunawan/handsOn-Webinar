<?php

namespace Modules\Katering\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Modules\Katering\Services\KateringService;
use Modules\Katering\Requests\CreateKateringRequest;
use Modules\Katering\Requests\UpdateKateringRequest;

/**
 * KateringController - Interface/Presentation Layer
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
 */
class KateringController extends Controller
{
    protected KateringService $kateringService;

    /**
     * Dependency Injection - Service di-inject via constructor
     */
    public function __construct(KateringService $kateringService)
    {
        $this->kateringService = $kateringService;
    }

    /**
     * GET /katerings
     * Menampilkan semua katering
     */
    public function index(): View
    {
        $katerings = $this->kateringService->getAll();
        return view('katering::katerings.index', compact('katerings'));
    }

    /**
     * GET /katerings/{id}
     * Menampilkan detail katering
     */
    public function show(int $id): View
    {
        $katering = $this->kateringService->findById($id);
        
        if (!$katering) {
            abort(404, 'Katering tidak ditemukan');
        }
        
        return view('katering::katerings.show', compact('katering'));
    }

    /**
     * GET /katerings/create
     * Form tambah katering baru
     */
    public function create(): View
    {
        return view('katering::katerings.create');
    }

    /**
     * POST /katerings
     * Simpan katering baru
     */
    public function store(CreateKateringRequest $request): RedirectResponse
    {
        $this->kateringService->create($request->validated());
        
        return redirect()->route('katerings.index')
            ->with('success', 'Katering berhasil ditambahkan!');
    }

    /**
     * GET /katerings/{id}/edit
     * Form edit katering
     */
    public function edit(int $id): View
    {
        $katering = $this->kateringService->findById($id);
        
        if (!$katering) {
            abort(404, 'Katering tidak ditemukan');
        }
        
        return view('katering::katerings.edit', compact('katering'));
    }

    /**
     * PUT /katerings/{id}
     * Update katering
     */
    public function update(UpdateKateringRequest $request, int $id): RedirectResponse
    {
        $this->kateringService->update($id, $request->validated());
        
        return redirect()->route('katerings.index')
            ->with('success', 'Katering berhasil diupdate!');
    }

    /**
     * DELETE /katerings/{id}
     * Hapus katering
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->kateringService->delete($id);
        
        return redirect()->route('katerings.index')
            ->with('success', 'Katering berhasil dihapus!');
    }
}
