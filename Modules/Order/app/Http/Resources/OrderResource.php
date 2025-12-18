<?php

namespace Modules\Order\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * OrderResource - Presentation Layer
 * 
 * Resource bertugas:
 * - Transformasi Entity/Model ke format JSON
 * - Formatting data (tanggal, harga, status label)
 * - Menyembunyikan field sensitif
 * 
 * Flow: Controller -> Resource (this) -> JSON Response
 */
class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'menu_id' => $this->menu_id,
            'quantity' => $this->quantity,
            'total_price' => $this->total_price,
            'formatted_price' => 'Rp ' . number_format($this->total_price, 0, ',', '.'),
            'status' => $this->status,
            'status_label' => $this->getStatusLabel(),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * Get human-readable status label
     */
    private function getStatusLabel(): string
    {
        return match($this->status) {
            'pending' => 'Menunggu',
            'processing' => 'Diproses',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => ucfirst($this->status ?? 'Unknown'),
        };
    }
}
