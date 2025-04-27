<?php

namespace Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DoctorRegisterFeatureTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     */
    public function test_it_register_doctor_valid_request(): void
    {
        $data = [
            "name" => fake()->name,
            "email" => fake()->email,
            "password" => "123456789",
            "password_confirmation" => "123456789",
            "speciality" => 'heart',
        ];

        $response= $this->post('api/v1/doctor/auth/register', $data, ['Accept' => 'application/json']);
        $response->assertStatus(201);

    }

    public function test_it_register_doctor_invalid_request(): void
    {
        $data = [

        ];

        $response= $this->post('api/v1/doctor/auth/register', $data, ['Accept' => 'application/json']);
        $response->assertStatus(422);

    }
}
