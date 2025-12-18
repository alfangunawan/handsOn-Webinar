<?php

namespace Modules\Katering\Services;

use Modules\Katering\Repositories\MenuRepository;
use Modules\Katering\Entities\Menu;
use Illuminate\Database\Eloquent\Collection;

/**
 * MenuService - Use Case / Business Logic Layer
 * 
 * Service berisi logika bisnis yang:
 * - Tidak bergantung pada framework (HTTP, database)
 * - Meng-orkestrasi Repository untuk akses data
 * 
 * Flow: Controller -> Service (this) -> Repository
 */
class MenuService
{
    protected MenuRepository $menuRepository;

    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    /**
     * Mendapatkan semua menu
     */
    public function getAll(): Collection
    {
        return $this->menuRepository->all();
    }

    /**
     * Mencari menu berdasarkan ID
     */
    public function findById(int $id): ?Menu
    {
        return $this->menuRepository->find($id);
    }

    /**
     * Membuat menu baru
     */
    public function create(array $data): Menu
    {
        return $this->menuRepository->create($data);
    }

    /**
     * Update menu
     */
    public function update(int $id, array $data): Menu
    {
        return $this->menuRepository->update($id, $data);
    }

    /**
     * Hapus menu
     */
    public function delete(int $id): bool
    {
        return $this->menuRepository->delete($id);
    }
}
