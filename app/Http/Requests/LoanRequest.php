<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Assuming all users are authorized for now; adjust based on business rules
        return true;
    }

    // protected function prepareForValidation(): void
    // {
    //     if ($this->has('payment_due_date')) {
    //         $this->merge([
    //             'payment_due_date' => \Carbon\Carbon::createFromFormat('d/m/Y', $this->payment_due_date)->format('Y-m-d')
    //         ]);
    //     }
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'name' => 'required|string|max:255',
            'loan_amount' => 'required|numeric|min:1',
            'interest_rate' => 'required|numeric|between:0,100',
            'loan_term_months' => 'required|integer|min:1',
            'status' => 'required|in:Approved,Pending,Rejected',
            'payment_due_date' => 'required|date|after_or_equal:today',
        ];
    }

    /**
     * Custom error messages for validation failures.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'The user ID is required.',
            'user_id.integer' => 'The user ID must be an integer.',
            'user_id.exists' => 'The user ID must exist in the users table.',

            'name.required' => 'The borrower name is required.',
            'name.string' => 'The borrower name must be a string.',
            'name.max' => 'The borrower name may not exceed 255 characters.',
            
            'loan_amount.required' => 'Loan amount is required.',
            'loan_amount.numeric' => 'Loan amount must be a valid number.',
            'loan_amount.min' => 'Loan amount must be at least 1.',

            'interest_rate.required' => 'The interest rate is required.',
            'interest_rate.numeric' => 'The interest rate must be a number between 0 and 100.',
            'interest_rate.between' => 'The interest rate must be between 0 and 100.',

            'loan_term_months.required' => 'The loan term is required.',
            'loan_term_months.integer' => 'The loan term must be an integer.',
            'loan_term_months.min' => 'The loan term must be at least 1 month.',

            'status.required' => 'Loan status is required.',
            'status.in' => 'The loan status must be either Approved, Pending, or Rejected.',

            'payment_due_date.required' => 'Payment due date is required.',
            'payment_due_date.date' => 'The payment due date must be a valid date.',
            'payment_due_date.after_or_equal' => 'The payment due date must be today or later.',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        // Return a JSON response with validation errors, instead of redirecting
        throw new HttpResponseException(
            response()->json([
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422)
        );
    }
}
