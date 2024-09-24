<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoanCalculationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Allow all users to make this request
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'principal' => 'required|numeric|min:0',
            'interest_rate' => 'required|numeric|between:0,100',
            'loan_term_months' => 'required|integer|min:1',
        ];
    }

    /**
     * Get the custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'principal.required' => 'The principal amount is required.',
            'principal.numeric' => 'The principal amount must be a number.',
            'principal.min' => 'The principal amount must be at least 0.',

            'interest_rate.required' => 'The interest rate is required.',
            'interest_rate.numeric' => 'The interest rate must be a number.',
            'interest_rate.between' => 'The interest rate must be between 0 and 100.',
            
            'loan_term_months.required' => 'The loan term in months is required.',
            'loan_term_months.integer' => 'The loan term must be an integer.',
            'loan_term_months.min' => 'The loan term must be at least 1 month.',
        ];
    }
}

