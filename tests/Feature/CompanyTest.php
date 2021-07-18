<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use WithFaker;
    /**
     * Test list all companies
     *
     * @return void
     */
    public function test_list()
    {
        $response = $this->get('/api/companies');

        $response->assertStatus(200);
    }

    /**
     * Expected create company.
     *
     * @return void
     */
    public function test_create()
    {
        $DTO = [
            'name' => $this->faker->company(),
            'email' => $this->faker->unique()->safeEmail(),
            'website' => $this->faker->url(),
        ];

        $response = $this->postJson('/api/companies', $DTO);

        $response->assertStatus(200)->assertJson([
            'success' => true,
        ]);
    }
}
