<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Expense;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateExpenseTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_expense_successful(): void
    {
        $data = [
            'description' => 'Despesa de teste',
            'amount' => 50,
        ];

        $this->post(route('expenses.store'), $data, ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas(Expense::class, $data);
    }

    public function test_should_be_generate_error_on_create_expense_no_data(): void
    {
        $this->post(route('expenses.store'), [], ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'description' => 'The description field is required.',
                'amount' => 'The amount field is required.',
            ]);
    }

    public function test_should_be_generate_error_when_the_description_is_incorrect(): void
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

    public function test_should_be_generate_error_when_the_amount_is_incorrect(): void
    {
        $data = [
            'description' => 'Despesa teste',
            'amount' => 'abc',
        ];

        $this->post(route('expenses.store'), $data, ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'amount' => 'The amount field must be a number.',
                'amount' => 'The amount field must be greater than or equal to 1.',
            ]);
    }

    public function test_should_set_others_category_when_creating_a_new_expense()
    {
        $data = [
            'description' => 'Despesa teste',
            'amount' => 100,
        ];

        $this->post(route('expenses.store'), $data, ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonFragment([
                'description' => 'Despesa teste',
                'amount' => 100,
                'category_id' => Category::OTHERS,
            ]);
    }

    public function test_should_set_category_id_chosen_when_creating_a_new_expense()
    {
        $data = [
            'description' => 'Despesa teste',
            'amount' => 100,
            'category_id' => 1,
        ];

        $this->post(route('expenses.store'), $data, ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonFragment([
                'description' => 'Despesa teste',
                'amount' => 100,
                'category_id' => Category::FOOD,
            ]);
    }

    public function test_should_be_generate_validation_error_when_creating_new_expense_with_unknown_category()
    {
        $data = [
            'description' => 'Despesa teste',
            'amount' => 100,
            'category_id' => 99,
        ];

        $this->post(route('expenses.store'), $data, ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'category_id' => 'The selected category id is invalid.',
            ]);
    }
}
