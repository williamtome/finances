<?php

namespace Tests\Feature;

use App\Models\Expense;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class DeleteExpenseTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_expense_successful(): void
    {
        $expense = Expense::factory()->create();

        $this->delete(route('expenses.destroy', $expense->id))
            ->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseMissing(Expense::class, [$expense->id]);
    }

    public function test_should_be_generate_error_on_delete_expense_unknown(): void
    {
        $expense = Expense::find(909);

        $this->expectException(\ErrorException::class);
        $this->expectExceptionMessage('Attempt to read property "id" on null');

        $this->delete(route('expenses.destroy', $expense->id))
            ->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
