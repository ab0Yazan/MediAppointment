<?php

namespace Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GetDoctorSlotsTest extends TestCase
{
    use RefreshDatabase;
    public function test_get_doctor_slot_return_a_successful_response(): void
    {
        $doctor =  $this->createDoctorAndSchedule();
        $client = $this->createClient();

        Sanctum::actingAs($client);

        $this->get("api/v1/appointments/doctors/{$doctor->id}/slots")->assertOk();
    }
}
