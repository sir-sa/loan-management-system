<?php

namespace Tests\Feature;

use App\Models\Loan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoanControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_create_a_loan()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $loanData = [
            'user_id' => $user->id,
            'name' => 'John Doe',
            'loan_amount' => 5000,
            'interest_rate' => 5,
            'loan_term_months' => 12,
            'status' => 'Pending',
            'payment_due_date' => now()->addMonths(12)->toDateString(),
        ];

        $response = $this->postJson('/api/loans', $loanData, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'id', 'user_id', 'name', 'loan_amount', 'interest_rate',
                     'loan_term_months', 'status', 'payment_due_date'
                 ]);
    }

    /** @test */
    public function it_should_list_all_loans()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        Loan::factory()->count(5)->create(['user_id' => $user->id]);

        $response = $this->getJson('/api/loans', [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([[
                     'id', 'user_id', 'name', 'loan_amount', 'interest_rate',
                     'loan_term_months', 'status', 'payment_due_date'
                 ]]);
    }

    /** @test **/
    /** @test */
public function it_should_view_single_loan_by_id()
{
    $user = User::factory()->create();
    $token = JWTAuth::fromUser($user);
    $loan = Loan::factory()->create(['user_id' => $user->id]);

    $response = $this->getJson('/api/loans/' . $loan->id, [
        'Authorization' => 'Bearer ' . $token,
    ]);

    $response->assertStatus(200)
             ->assertJsonStructure([
                 'id', 'user_id', 'name', 'loan_amount', 'interest_rate',
                 'loan_term_months', 'status', 'payment_due_date'
             ])
             ->assertJson([
                 'id' => $loan->id,
                 'user_id' => $loan->user_id,
                 'name' => $loan->name,
                 'loan_amount' => (string) $loan->loan_amount,
                 'interest_rate' => (string) $loan->interest_rate,
                 'loan_term_months' => $loan->loan_term_months,
                 'status' => $loan->status,
                 'payment_due_date' => $loan->payment_due_date->toDateString(),
             ]);
}

 /** @test */
 public function it_should_update_loan()
 {
     $user = User::factory()->create();
     $token = JWTAuth::fromUser($user);

     $loan = Loan::factory()->create(['user_id' => $user->id]);

     $data = [
         'name' => 'Updated Loan Name',
         'user_id' => $user->id,
         'loan_amount' => 6000,
         'interest_rate' => 6,
         'loan_term_months' => 12,
         'status' => 'Approved',
         'payment_due_date' => now()->addMonths(12)->toDateString(),
     ];

     $response = $this->patchJson('/api/loans/' . $loan->id, $data, [
         'Authorization' => 'Bearer ' . $token,
     ]);

     $response->assertStatus(200)
              ->assertJsonStructure([
                  'id', 'user_id', 'name', 'loan_amount', 'interest_rate',
                  'loan_term_months', 'status', 'payment_due_date'
              ])
              ->assertJson([
                  'id' => $loan->id,
                  'name' => 'Updated Loan Name',
                  'user_id' => $user->id,
                  'loan_amount' => (string) 6000,
                  'interest_rate' => (string) 6,
                  'loan_term_months' => 12,
                  'status' => 'Approved',
                  'payment_due_date' => $data['payment_due_date'],
              ]);
 }

 /** @test */
 public function it_should_delete_loan()
 {
     $user = User::factory()->create();
     $token = JWTAuth::fromUser($user);

     $loan = Loan::factory()->create(['user_id' => $user->id]);

     $response = $this->deleteJson('/api/loans/' . $loan->id, [], [
         'Authorization' => 'Bearer ' . $token,
     ]);

     $response->assertStatus(200)
              ->assertJson([
                  'message' => 'Loan deleted successfully.',
              ]);

     $this->assertDatabaseMissing('loans', [
         'id' => $loan->id,
     ]);
 }



   
    /** @test */
    public function it_should_calculate_loan_repayment()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $data = [
            'principal' => 5000,
            'interest_rate' => 5,
            'loan_term_months' => 12,
        ];

        $response = $this->postJson('/api/loans/calculate', $data, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['total_repayment', 'monthly_repayment']);
    }

    /** @test */
    public function it_should_update_loan_status()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $loan = Loan::factory()->create([
            'user_id' => $user->id,
            'status' => 'Pending',
        ]);

        $data = ['status' => 'Approved'];

        $response = $this->patchJson('/api/loans/status/' . $loan->id, $data, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Loan status updated successfully.',
                     'loan' => ['status' => 'Approved'],
                 ]);
    }
}
