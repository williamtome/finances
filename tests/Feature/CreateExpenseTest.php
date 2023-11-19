<?php

namespace Tests\Feature;

use App\Models\Expense;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateExpenseTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_expense_successful()
    {
        $data = [
            'description' => 'Despesa de teste',
            'amount' => 50,
        ];

        $this->post(route('expenses.store'), $data)
            ->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas(Expense::class, $data);
    }

    public function test_should_be_generate_error_on_create_expense_no_data()
    {
        $this->post(route('expenses.store'), [], ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'description' => 'The description field is required.',
                'amount' => 'The amount field is required.',
            ]);
    }

    public function test_should_br_generate_error_when_the_description_field_is_incorrect()
    {
        $data = [
            'description' => 1234,
            'amount' => 1234
        ];

        $this->post(route('expenses.store'), $data, ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'description' => 'The description field must be a string.',
                'description' => 'The description field must be at least 5 characters.',
            ]);
    }
}
