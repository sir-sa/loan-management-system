<?php

namespace Database\Factories;

use App\Models\Loan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class LoanFactory extends Factory
{
    protected $model = Loan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'name' => $this->faker->name,
            'loan_amount' => $this->faker->numberBetween(1000, 10000),
            'interest_rate' => $this->faker->randomFloat(2, 1, 10),
            'loan_term_months' => $this->faker->numberBetween(6, 24),
            'status' => 'Pending',
            'payment_due_date' => Carbon::now()->addMonths(12),
        ];
    }
}
