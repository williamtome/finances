<?php

namespace Tests\Feature;

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
}
