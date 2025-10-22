<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // set to true if you allow all users or implement auth
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|uuid|exists:users,id',
           // 'total_amount' => 'required|numeric|min:0',
            'status' => 'nullable|in:pending,completed,cancelled',
        ];
    }
}
