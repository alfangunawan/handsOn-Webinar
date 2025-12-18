<?php

namespace Modules\Order\Services;

use Modules\Order\Repositories\OrderRepository;
use Modules\Katering\Repositories\MenuRepository;
use Exception;

class OrderService
{
    protected $orderRepository;
    protected $menuRepository;

    public function __construct(OrderRepository $orderRepository, MenuRepository $menuRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->menuRepository = $menuRepository;
    }

    public function getAll()
    {
        return $this->orderRepository->all();
    }

    public function getByUserId($userId)
    {
        return $this->orderRepository->getByUserId($userId);
    }

    public function findById($id)
    {
        return $this->orderRepository->find($id);
    }

    public function createOrder($userId, $menuId, $quantity)
    {
        $menu = $this->menuRepository->find($menuId);
        
        if (!$menu) {
            throw new Exception("Menu not found");
        }

        $totalPrice = $menu->price * $quantity;

        return $this->orderRepository->create([
            'user_id' => $userId,
            'menu_id' => $menuId,
            'quantity' => $quantity,
            'total_price' => $totalPrice,
            'status' => 'pending'
        ]);
    }

    public function update($id, array $data)
    {
        return $this->orderRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->orderRepository->delete($id);
    }
}
