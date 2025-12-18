<?php

namespace Modules\Katering\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * MenuResource - Presentation Layer
 * 
 * Resource bertugas:
 * - Transformasi Entity/Model ke format JSON
 * - Formatting data (harga)
 * - Menyembunyikan field sensitif
 * 
 * Flow: Controller -> Resource (this) -> JSON Response
 */
class MenuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'katering_id' => $this->katering_id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'formatted_price' => 'Rp ' . number_format($this->price, 0, ',', '.'),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
