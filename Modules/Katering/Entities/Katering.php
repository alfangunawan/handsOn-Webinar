<?php

namespace Modules\Katering\Entities;

use Illuminate\Database\Eloquent\Model;

class Katering extends Model
{
    protected $table = 'katerings';
    protected $fillable = ['name', 'description'];
}
