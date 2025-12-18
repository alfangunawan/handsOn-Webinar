<?php

namespace Modules\Katering\Services;

use Modules\Katering\Repositories\MenuRepository;
use Modules\Katering\Entities\Menu;
use Illuminate\Database\Eloquent\Collection;

/**
 * MenuService - Application/Use Case Layer
 * 
 * ┌─────────────────────────────────────────────────────────────────┐
 * │                    CLEAN ARCHITECTURE FLOW                      │
 * ├─────────────────────────────────────────────────────────────────┤
 * │  Request → Controller → Service (this) → Repository → Entity   │
 * └─────────────────────────────────────────────────────────────────┘
 * 
 * Service bertanggung jawab untuk:
 * 1. Mengandung Business Logic / Use Case
 * 2. Mengorkestrasikan Repository untuk akses data
 * 3. Menerapkan aturan bisnis
 * 
 * Service TIDAK boleh:
 * - Mengakses HTTP Request/Response
 * - Mengandung query database langsung
 */
class MenuService
{
    protected MenuRepository $menuRepository;

    /**
     * Dependency Injection - Repository di-inject via constructor
     */
    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    /**
     * Use Case: Mendapatkan semua menu
     */
    public function getAll(): Collection
    {
        return $this->menuRepository->all();
    }

    /**
     * Use Case: Mendapatkan menu dengan pagination
     */
    public function getAllPaginated(int $perPage = 10)
    {
        return $this->menuRepository->paginate($perPage);
    }

    /**
     * Use Case: Mencari menu berdasarkan ID
     */
    public function findById(int $id): ?Menu
    {
        return $this->menuRepository->find($id);
    }

    /**
     * Use Case: Membuat menu baru
     * 
     * Business Logic:
     * - Validasi data sudah dilakukan di Request layer
     * - Data langsung diteruskan ke Repository
     */
    public function create(array $data): Menu
    {
        return $this->menuRepository->create($data);
    }

    /**
     * Use Case: Update menu
     */
    public function update(int $id, array $data): Menu
    {
        return $this->menuRepository->update($id, $data);
    }

    /**
     * Use Case: Hapus menu
     */
    public function delete(int $id): bool
    {
        return $this->menuRepository->delete($id);
    }

    /**
     * Use Case: Mendapatkan menu berdasarkan katering
     */
    public function getByKateringId(int $kateringId): Collection
    {
        return $this->menuRepository->getByKateringId($kateringId);
    }

    /**
     * Use Case: Mencari menu berdasarkan nama
     */
    public function searchByName(string $keyword): Collection
    {
        return $this->menuRepository->searchByName($keyword);
    }
}
