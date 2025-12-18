<?php

namespace Modules\Katering\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * UpdateMenuRequest - Input Validation Layer
 * 
 * Validasi untuk update menu
 */
class UpdateMenuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'sometimes|required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama menu harus diisi.',
            'name.max' => 'Nama menu maksimal 255 karakter.',
            'price.required' => 'Harga harus diisi.',
            'price.min' => 'Harga tidak boleh negatif.',
        ];
    }
}
