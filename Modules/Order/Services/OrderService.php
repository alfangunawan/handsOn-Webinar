<?php

namespace Modules\Order\Services;

use Modules\Order\Repositories\OrderRepository;
use Modules\Katering\Repositories\MenuRepository;
use Modules\Order\Entities\Order;
use Exception;
use Illuminate\Database\Eloquent\Collection;

/**
 * OrderService - Use Case / Business Logic Layer
 * 
 * Service berisi logika bisnis yang:
 * - Tidak bergantung pada framework (HTTP, database)
 * - Meng-orkestrasi Repository untuk akses data
 * - Menerapkan aturan bisnis (validasi menu, hitung total)
 * 
 * Flow: Controller -> Service (this) -> Repository
 */
class OrderService
{
    protected OrderRepository $orderRepository;
    protected MenuRepository $menuRepository;

    public function __construct(
        OrderRepository $orderRepository, 
        MenuRepository $menuRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->menuRepository = $menuRepository;
    }

    /**
     * Mendapatkan semua pesanan
     */
    public function getAll(): Collection
    {
        return $this->orderRepository->all();
    }

    /**
     * Mendapatkan pesanan berdasarkan user ID
     */
    public function getByUserId(int $userId): Collection
    {
        return $this->orderRepository->getByUserId($userId);
    }

    /**
     * Mencari pesanan berdasarkan ID
     */
    public function findById(int $id): ?Order
    {
        return $this->orderRepository->find($id);
    }

    /**
     * Membuat pesanan baru
     * 
     * Business Logic:
     * 1. Validasi menu exists
     * 2. Hitung total harga (price * quantity)
     * 3. Set status awal 'pending'
     * 
     * @throws Exception jika menu tidak ditemukan
     */
    public function createOrder(int $userId, int $menuId, int $quantity): Order
    {
        // Business Rule: Validasi menu harus ada
        $menu = $this->menuRepository->find($menuId);
        
        if (!$menu) {
            throw new Exception("Menu dengan ID {$menuId} tidak ditemukan");
        }

        // Business Rule: Hitung total harga
        $totalPrice = $menu->price * $quantity;

        // Simpan ke repository
        return $this->orderRepository->create([
            'user_id' => $userId,
            'menu_id' => $menuId,
            'quantity' => $quantity,
            'total_price' => $totalPrice,
            'status' => 'pending'
        ]);
    }

    /**
     * Update pesanan
     */
    public function update(int $id, array $data): Order
    {
        return $this->orderRepository->update($id, $data);
    }

    /**
     * Update status pesanan
     */
    public function updateStatus(int $id, string $status): Order
    {
        $validStatuses = ['pending', 'processing', 'completed', 'cancelled'];
        
        if (!in_array($status, $validStatuses)) {
            throw new Exception("Status tidak valid: {$status}");
        }
        
        return $this->orderRepository->update($id, ['status' => $status]);
    }

    /**
     * Hapus pesanan
     */
    public function delete(int $id): bool
    {
        return $this->orderRepository->delete($id);
    }
}
