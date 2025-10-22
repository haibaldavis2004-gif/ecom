<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePurchaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Allow all users or implement auth logic
    }

    public function rules(): array
    {
        return [
            'user_id' => 'sometimes|uuid|exists:users,id',
            'total_amount' => 'sometimes|numeric|min:0',
            'status' => 'sometimes|in:pending,completed,cancelled',
        ];
    }
}
