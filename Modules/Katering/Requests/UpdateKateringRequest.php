<?php

namespace Modules\Katering\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * UpdateKateringRequest - Input Validation Layer
 * 
 * Bertanggung jawab untuk validasi input sebelum masuk ke Controller
 * 
 * Flow: Request (this) -> Controller -> Service -> Repository
 */
class UpdateKateringRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama katering harus diisi.',
            'name.max' => 'Nama katering maksimal 255 karakter.',
            'description.max' => 'Deskripsi maksimal 1000 karakter.',
        ];
    }
}
