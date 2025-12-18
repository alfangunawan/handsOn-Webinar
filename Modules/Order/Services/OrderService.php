<?php

namespace Modules\Order\Services;

use Modules\Order\Repositories\OrderRepository;
use Modules\Katering\Repositories\MenuRepository;
use Modules\Order\Entities\Order;
use Exception;
use Illuminate\Database\Eloquent\Collection;

/**
 * OrderService - Application/Use Case Layer
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
class OrderService
{
    protected OrderRepository $orderRepository;
    protected MenuRepository $menuRepository;

    /**
     * Dependency Injection - Repositories di-inject via constructor
     */
    public function __construct(
        OrderRepository $orderRepository, 
        MenuRepository $menuRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->menuRepository = $menuRepository;
    }

    /**
     * Use Case: Mendapatkan semua pesanan
     */
    public function getAll(): Collection
    {
        return $this->orderRepository->all();
    }

    /**
     * Use Case: Mendapatkan pesanan berdasarkan user ID
     */
    public function getByUserId(int $userId): Collection
    {
        return $this->orderRepository->getByUserId($userId);
    }

    /**
     * Use Case: Mencari pesanan berdasarkan ID
     */
    public function findById(int $id): ?Order
    {
        return $this->orderRepository->find($id);
    }

    /**
     * Use Case: Membuat pesanan baru
     * 
     * Business Logic:
     * 1. Validasi menu harus ada di database
     * 2. Hitung total harga = price × quantity
     * 3. Set status awal = 'pending'
     * 
     * @throws Exception jika menu tidak ditemukan
     */
    public function createOrder(int $userId, int $menuId, int $quantity): Order
    {
        // Business Rule 1: Menu harus ada
        $menu = $this->menuRepository->find($menuId);
        
        if (!$menu) {
            throw new Exception("Menu dengan ID {$menuId} tidak ditemukan");
        }

        // Business Rule 2: Hitung total harga
        $totalPrice = $menu->price * $quantity;

        // Business Rule 3: Status awal pending
        return $this->orderRepository->create([
            'user_id' => $userId,
            'menu_id' => $menuId,
            'quantity' => $quantity,
            'total_price' => $totalPrice,
            'status' => 'pending'
        ]);
    }

    /**
     * Use Case: Update status pesanan
     * 
     * Business Logic:
     * - Status harus valid (pending, processing, completed, cancelled)
     * 
     * @throws Exception jika status tidak valid
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
     * Use Case: Batalkan pesanan
     * 
     * Business Logic:
     * - Hanya pesanan dengan status 'pending' yang bisa dibatalkan
     * 
     * @throws Exception jika pesanan tidak bisa dibatalkan
     */
    public function cancel(int $id): Order
    {
        $order = $this->orderRepository->find($id);
        
        if (!$order) {
            throw new Exception("Pesanan tidak ditemukan");
        }
        
        if ($order->status !== 'pending') {
            throw new Exception("Pesanan dengan status '{$order->status}' tidak bisa dibatalkan");
        }
        
        return $this->orderRepository->update($id, ['status' => 'cancelled']);
    }

    /**
     * Use Case: Update pesanan
     */
    public function update(int $id, array $data): Order
    {
        return $this->orderRepository->update($id, $data);
    }

    /**
     * Use Case: Hapus pesanan
     */
    public function delete(int $id): bool
    {
        return $this->orderRepository->delete($id);
    }
}
