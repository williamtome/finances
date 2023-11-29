<?php

namespace Tests\Feature;

use App\Models\Expense;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateExpenseTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_a_expense_successful()
    {
        $expense = Expense::factory()->create();

        $data = [
            'description' => 'Atualização de receita',
            'amount' => 2000,
        ];

        $this->put(route('expenses.update', $expense->id), $data, ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment($data);
    }

    public function test_should_be_generate_error_on_update_a_expense_no_data()
    {
        $expense = Expense::factory()->create();

        $this->put(route('expenses.update', $expense->id), [], ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'description' => 'The description field is required.',
                'amount' => 'The amount field is required.',
            ]);
    }

    public function test_should_be_generate_error_on_update_a_expense_with_incorrect_data()
    {
        $expense = Expense::factory()->create();

        $data = [
            'description' => 11231,
            'amount' => 'adsa',
        ];

        $this->put(route('expenses.update', $expense->id), $data, ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'description' => 'The description field must be a string.',
                'amount' => 'The amount field must be a number.',
                'amount' => 'The amount field must be greater than or equal to 1.',
            ]);
    }
}
