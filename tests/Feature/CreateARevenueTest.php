<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateARevenueTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_a_revenue_successful()
    {
        $data = [
            'description' => 'Receita de teste',
            'amount' => 1000,
        ];

        $this->post(route('revenues.store'), $data, ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_OK);
    }

    public function test_should_be_generate_error_on_create_a_revenue_no_data()
    {
        $this->post(route('revenues.store'), [], ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'description' => 'The description field is required.',
                'amount' => 'The amount field is required.',
            ]);
    }

    public function test_should_be_generate_error_on_create_a_revenue_with_description_incorrect()
    {
        $data = ['description' => 1234, 'amount' => 200];

        $this->post(route('revenues.store'), $data, ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'description' => 'The description field must be a string.',
                'description' => 'The description field must be at least 5 characters.',
            ]);
    }

    public function test_should_be_generate_error_on_create_a_revenue_with_amount_incorrect()
    {
        $data = [
            'description' => 'Receita de teste',
            'amount' => 0,
        ];

        $this->post(route('revenues.store'), $data, ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'amount' => 'The amount field must be greater than or equal to 1.',
            ]);
    }
}
