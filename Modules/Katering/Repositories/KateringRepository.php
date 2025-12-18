<?php

namespace Modules\Katering\Repositories;

use Modules\Katering\Entities\Katering;
use Illuminate\Database\Eloquent\Collection;

/**
 * KateringRepository - Infrastructure/Data Access Layer
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
 */
class KateringRepository
{
    /**
     * Mendapatkan semua katering
     */
    public function all(): Collection
    {
        return Katering::with('menus')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Mencari katering berdasarkan ID
     */
    public function find(int $id): ?Katering
    {
        return Katering::with('menus')->find($id);
    }

    /**
     * Membuat katering baru
     */
    public function create(array $data): Katering
    {
        return Katering::create($data);
    }

    /**
     * Update katering
     */
    public function update(int $id, array $data): Katering
    {
        $katering = Katering::findOrFail($id);
        $katering->update($data);
        return $katering->fresh(['menus']);
    }

    /**
     * Hapus katering
     */
    public function delete(int $id): bool
    {
        return Katering::destroy($id) > 0;
    }

    /**
     * Pagination
     */
    public function paginate(int $perPage = 10)
    {
        return Katering::with('menus')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
}
