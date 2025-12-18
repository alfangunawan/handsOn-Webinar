<?php

namespace Modules\Order\Repositories;

use Modules\Order\Entities\Order;
use Illuminate\Database\Eloquent\Collection;

/**
 * OrderRepository - Infrastructure/Data Access Layer
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
class OrderRepository
{
    /**
     * Mendapatkan semua pesanan
     */
    public function all(): Collection
    {
        return Order::with(['menu', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Mencari pesanan berdasarkan ID
     */
    public function find(int $id): ?Order
    {
        return Order::with(['menu', 'user'])->find($id);
    }

    /**
     * Membuat pesanan baru
     */
    public function create(array $data): Order
    {
        return Order::create($data);
    }

    /**
     * Mendapatkan pesanan berdasarkan user ID
     */
    public function getByUserId(int $userId): Collection
    {
        return Order::with('menu')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Update pesanan
     */
    public function update(int $id, array $data): Order
    {
        $order = Order::findOrFail($id);
        $order->update($data);
        return $order->fresh(['menu', 'user']);
    }

    /**
     * Hapus pesanan
     */
    public function delete(int $id): bool
    {
        return Order::destroy($id) > 0;
    }

    /**
     * Mendapatkan pesanan berdasarkan status
     */
    public function getByStatus(string $status): Collection
    {
        return Order::with(['menu', 'user'])
            ->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Mendapatkan pesanan pending
     */
    public function getPendingOrders(): Collection
    {
        return $this->getByStatus('pending');
    }
}
