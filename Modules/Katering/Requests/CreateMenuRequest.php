<?php

namespace Modules\Katering\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * CreateMenuRequest - Input Validation Layer
 * 
 * Bertanggung jawab untuk validasi input sebelum masuk ke Controller
 * 
 * Flow: Request (this) -> Controller -> Service -> Repository
 */
class CreateMenuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'katering_id' => 'required|integer|exists:katerings,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'katering_id.required' => 'Katering harus dipilih.',
            'katering_id.exists' => 'Katering tidak ditemukan.',
            'name.required' => 'Nama menu harus diisi.',
            'name.max' => 'Nama menu maksimal 255 karakter.',
            'price.required' => 'Harga harus diisi.',
            'price.min' => 'Harga tidak boleh negatif.',
        ];
    }
}
