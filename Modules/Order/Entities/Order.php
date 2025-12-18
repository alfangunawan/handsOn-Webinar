<?php

namespace Modules\Order\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Katering\Entities\Menu;

/**
 * Order Entity - Domain Layer
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
class Order extends Model
{
    protected $table = 'orders';
    
    protected $fillable = [
        'user_id',
        'menu_id',
        'quantity',
        'total_price',
        'status',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'quantity' => 'integer',
        'user_id' => 'integer',
        'menu_id' => 'integer',
    ];

    /**
     * Status yang valid
     */
    public const STATUS_PENDING = 'pending';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    /**
     * Relasi: Order belongs to User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Order belongs to Menu
     */
    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    /**
     * Accessor: Format harga ke Rupiah
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }

    /**
     * Accessor: Label status dalam bahasa Indonesia
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            self::STATUS_PENDING => 'Menunggu',
            self::STATUS_PROCESSING => 'Diproses',
            self::STATUS_COMPLETED => 'Selesai',
            self::STATUS_CANCELLED => 'Dibatalkan',
            default => ucfirst($this->status),
        };
    }

    /**
     * Check: Apakah order bisa dibatalkan
     */
    public function canBeCancelled(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }
}
