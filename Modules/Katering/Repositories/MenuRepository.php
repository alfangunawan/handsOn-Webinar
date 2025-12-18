<?php

namespace Modules\Katering\Repositories;

use Modules\Katering\Entities\Menu;
use Illuminate\Database\Eloquent\Collection;

/**
 * MenuRepository - Data Access Layer
 * 
 * Repository bertugas:
 * - Menyembunyikan detail implementasi database
 * - Menyediakan interface untuk akses data Menu
 * - Menggunakan Eloquent untuk interaksi dengan database
 * 
 * Flow: Service -> Repository (this) -> Entity/Model
 */
class MenuRepository
{
    /**
     * Mendapatkan semua menu
     */
    public function all(): Collection
    {
        return Menu::all();
    }

    /**
     * Mencari menu berdasarkan ID
     */
    public function find(int $id): ?Menu
    {
        return Menu::find($id);
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
        return $menu;
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
}
