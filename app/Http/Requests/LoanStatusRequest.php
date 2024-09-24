<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoanStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'status' => 'required|in:Approved,Rejected',
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'status.required' => 'The loan status is required.',
            'status.in' => 'The loan status must be either "Approved" or "Rejected".',
        ];
    }

    
}
