<?php

namespace Modules\Katering\Services;

use Modules\Katering\Repositories\MenuRepository;

class MenuService
{
    protected $menuRepository;

    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    public function getAll()
    {
        return $this->menuRepository->all();
    }

    public function findById($id)
    {
        return $this->menuRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->menuRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->menuRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->menuRepository->delete($id);
    }
}
