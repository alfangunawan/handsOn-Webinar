<?php

namespace Modules\Katering\Repositories;

use Modules\Katering\Entities\Menu;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * MenuRepository - Infrastructure/Data Access Layer
 * 
 * ┌─────────────────────────────────────────────────────────────────┐
 * │                    CLEAN ARCHITECTURE FLOW                      │
 * ├─────────────────────────────────────────────────────────────────┤
 * │  Request → Controller → Service → Repository (this) → Entity   │
 * └─────────────────────────────────────────────────────────────────┘
 * 
 * Repository bertanggung jawab untuk:
 * 1. Menyembunyikan detail implementasi database
 * 2. Menyediakan interface untuk akses data
 * 3. Melakukan operasi CRUD ke database via Eloquent
 * 
 * Repository TIDAK boleh:
 * - Mengandung business logic
 * - Mengakses HTTP layer
 */
class MenuRepository
{
    /**
     * Mendapatkan semua menu
     */
    public function all(): Collection
    {
        return Menu::with('katering')->get();
    }

    /**
     * Mendapatkan menu dengan pagination
     */
    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return Menu::with('katering')->paginate($perPage);
    }

    /**
     * Mencari menu berdasarkan ID
     */
    public function find(int $id): ?Menu
    {
        return Menu::with('katering')->find($id);
    }

    /**
     * Membuat menu baru
     */
    public function create(array $data): Menu
    {
        return Menu::create($data);
    }

    /**
     * Update menu
     */
    public function update(int $id, array $data): Menu
    {
        $menu = Menu::findOrFail($id);
        $menu->update($data);
        return $menu->fresh();
    }

    /**
     * Hapus menu
     */
    public function delete(int $id): bool
    {
        return Menu::destroy($id) > 0;
    }

    /**
     * Mendapatkan menu berdasarkan katering ID
     */
    public function getByKateringId(int $kateringId): Collection
    {
        return Menu::where('katering_id', $kateringId)->get();
    }

    /**
     * Mencari menu berdasarkan nama
     */
    public function searchByName(string $keyword): Collection
    {
        return Menu::where('name', 'like', "%{$keyword}%")->get();
    }
}
