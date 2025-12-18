<?php

namespace Modules\Order\Repositories;

use Modules\Order\Entities\Order;
use Illuminate\Database\Eloquent\Collection;

/**
 * OrderRepository - Data Access Layer
 * 
 * Repository bertugas:
 * - Menyembunyikan detail implementasi database
 * - Menyediakan interface untuk akses data Order
 * - Menggunakan Eloquent untuk interaksi dengan database
 * 
 * Flow: Service -> Repository (this) -> Entity/Model
 */
class OrderRepository
{
    /**
     * Mendapatkan semua pesanan
     */
    public function all(): Collection
    {
        return Order::all();
    }

    /**
     * Mencari pesanan berdasarkan ID
     */
    public function find(int $id): ?Order
    {
        return Order::find($id);
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
        return Order::where('user_id', $userId)->orderBy('created_at', 'desc')->get();
    }

    /**
     * Update pesanan
     */
    public function update(int $id, array $data): Order
    {
        $order = Order::findOrFail($id);
        $order->update($data);
        return $order;
    }

    /**
     * Hapus pesanan
     */
    public function delete(int $id): bool
    {
        return Order::destroy($id) > 0;
    }
}
