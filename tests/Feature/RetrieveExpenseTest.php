<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Expense;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class RetrieveExpenseTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_all_expenses_successful(): void
    {
        Expense::factory()->count(5)->create();

        $this->get(route('expenses.index'), ['Content-Type' => 'application/json'])
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                [
                    'id',
                    'description',
                    'amount',
                    'created_at',
                    'updated_at',
                    'deleted_at',
                ]
            ]);
    }

    public function test_retrieve_expense_by_description(): void
    {
        $expense = Expense::factory()->create([
            'description' => 'Compras no mercado',
            'amount' => 100,
            'category_id' => Category::FOOD,
        ]);

        $this->get(
            route('expenses.index', ['description' => 'compras']),
            ['Content-Type' => 'application/json']
        )
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment([
                'id' => $expense->id,
                'description' => $expense->description,
                'amount' => $expense->amount,
                'category_id' => $expense->category_id,
            ]);
    }
}
