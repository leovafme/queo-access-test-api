<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    /**
     * A basic feature test employee.
     *
     * @return void
     */
    public function test_employee()
    {
        $response = $this->get('/api/employees');

        $response->assertStatus(200);
    }
}
