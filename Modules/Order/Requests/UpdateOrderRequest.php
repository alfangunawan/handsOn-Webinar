<?php

namespace Modules\Order\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * UpdateOrderRequest - Input Validation Layer
 */
class UpdateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'status' => 'required|in:pending,processing,completed,cancelled',
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Status harus dipilih.',
            'status.in' => 'Status tidak valid.',
        ];
    }
}
