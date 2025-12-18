<?php

namespace Modules\Order\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * CreateOrderRequest - Input Validation Layer
 * 
 * ┌─────────────────────────────────────────────────────────────────┐
 * │                    CLEAN ARCHITECTURE FLOW                      │
 * ├─────────────────────────────────────────────────────────────────┤
 * │  Request (this) → Controller → Service → Repository → Entity   │
 * └─────────────────────────────────────────────────────────────────┘
 * 
 * Bertanggung jawab untuk validasi input sebelum masuk ke Controller
 */
class CreateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Hanya user yang login bisa membuat order
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'menu_id' => 'required|integer|exists:menus,id',
            'quantity' => 'required|integer|min:1|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'menu_id.required' => 'Menu harus dipilih.',
            'menu_id.integer' => 'ID menu tidak valid.',
            'menu_id.exists' => 'Menu tidak ditemukan.',
            'quantity.required' => 'Jumlah harus diisi.',
            'quantity.integer' => 'Jumlah harus berupa angka.',
            'quantity.min' => 'Jumlah minimal 1.',
            'quantity.max' => 'Jumlah maksimal 100.',
        ];
    }
}
