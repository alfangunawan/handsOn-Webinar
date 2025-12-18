<?php

namespace Modules\Katering\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Menu Entity - Domain Layer
 * 
 * ┌─────────────────────────────────────────────────────────────────┐
 * │                    CLEAN ARCHITECTURE FLOW                      │
 * ├─────────────────────────────────────────────────────────────────┤
 * │  Request → Controller → Service → Repository → Entity (this)   │
 * └─────────────────────────────────────────────────────────────────┘
 * 
 * Entity merepresentasikan:
 * 1. Struktur data domain
 * 2. Relasi antar entity
 * 3. Atribut yang dapat diisi (fillable)
 */
class Menu extends Model
{
    protected $table = 'menus';
    
    protected $fillable = [
        'katering_id',
        'name',
        'description',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'katering_id' => 'integer',
    ];

    /**
     * Relasi: Menu belongs to Katering
     */
    public function katering(): BelongsTo
    {
        return $this->belongsTo(Katering::class);
    }

    /**
     * Relasi: Menu has many Orders
     */
    public function orders(): HasMany
    {
        return $this->hasMany(\Modules\Order\Entities\Order::class);
    }

    /**
     * Accessor: Format harga ke Rupiah
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
}
