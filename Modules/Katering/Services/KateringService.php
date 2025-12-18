<?php

namespace Modules\Katering\Services;

use Modules\Katering\Repositories\KateringRepository;
use Modules\Katering\Entities\Katering;
use Illuminate\Database\Eloquent\Collection;

/**
 * KateringService - Application/Use Case Layer
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
 */
class KateringService
{
    protected KateringRepository $kateringRepository;

    /**
     * Dependency Injection - Repository di-inject via constructor
     */
    public function __construct(KateringRepository $kateringRepository)
    {
        $this->kateringRepository = $kateringRepository;
    }

    /**
     * Use Case: Mendapatkan semua katering
     */
    public function getAll(): Collection
    {
        return $this->kateringRepository->all();
    }

    /**
     * Use Case: Mendapatkan katering dengan pagination
     */
    public function getAllPaginated(int $perPage = 10)
    {
        return $this->kateringRepository->paginate($perPage);
    }

    /**
     * Use Case: Mencari katering berdasarkan ID
     */
    public function findById(int $id): ?Katering
    {
        return $this->kateringRepository->find($id);
    }

    /**
     * Use Case: Membuat katering baru
     */
    public function create(array $data): Katering
    {
        return $this->kateringRepository->create($data);
    }

    /**
     * Use Case: Update katering
     */
    public function update(int $id, array $data): Katering
    {
        return $this->kateringRepository->update($id, $data);
    }

    /**
     * Use Case: Hapus katering
     */
    public function delete(int $id): bool
    {
        return $this->kateringRepository->delete($id);
    }
}
