<?php

namespace Modules\Katering\Repositories;

use Modules\Katering\Entities\Menu;

class MenuRepository
{
    public function all()
    {
        return Menu::all();
    }

    public function find($id)
    {
        return Menu::find($id);
    }

    public function create(array $data)
    {
        return Menu::create($data);
    }

    public function update($id, array $data)
    {
        $menu = Menu::findOrFail($id);
        $menu->update($data);
        return $menu;
    }

    public function delete($id)
    {
        return Menu::destroy($id);
    }
}
