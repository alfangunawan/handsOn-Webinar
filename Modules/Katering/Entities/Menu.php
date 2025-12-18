<?php

namespace Modules\Katering\Entities;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';
    protected $fillable = ['katering_id', 'name', 'price', 'description'];
}
