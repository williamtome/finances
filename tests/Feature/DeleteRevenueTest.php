<?php

namespace Tests\Feature;

use App\Models\Revenue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class DeleteRevenueTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_revenue_successful(): void
    {
        $revenue = Revenue::factory()->create();

        $this->delete(route('revenues.destroy', $revenue->id))
            ->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseMissing(Revenue::class, [$revenue->id]);
    }

    public function test_should_be_generate_error_on_delete_revenue_unknown(): void
    {
        $revenue = Revenue::find(777);

        $this->expectException(\ErrorException::class);
        $this->expectExceptionMessage('Attempt to read property "id" on null');

        $this->delete(route('revenues.destroy', $revenue->id))
            ->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
