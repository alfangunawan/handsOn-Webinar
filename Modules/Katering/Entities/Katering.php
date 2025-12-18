<?php

namespace Modules\Katering\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Katering Entity - Domain Layer
 */
class Katering extends Model
{
    protected $table = 'katerings';
    
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Relasi: Katering has many Menus
     */
    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class);
    }
}
