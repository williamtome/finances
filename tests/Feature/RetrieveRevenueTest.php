<?php

namespace Tests\Feature;

use App\Models\Revenue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class RetrieveRevenueTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_all_revenues_successful(): void
    {
        Revenue::factory()->count(5)->create();

        $this->get(route('revenues.index'), ['Content-Type' => 'application/json'])
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                [
                    'id',
                    'description',
                    'amount',
                    'created_at',
                    'updated_at',
                    'deleted_at',
                ],
            ]);
    }

    public function test_should_show_specific_revenue_with_successful(): void
    {
        $revenue = Revenue::factory()->create();

        $this->get(route('revenues.show', $revenue->id), ['Content-Type' => 'application/json'])
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'id',
                'description',
                'amount',
                'created_at',
                'updated_at',
                'deleted_at',
            ]);
    }
}
