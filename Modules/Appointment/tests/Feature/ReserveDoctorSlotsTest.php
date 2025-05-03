<?php

namespace Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Modules\Appointment\app\Models\Slot;
use Tests\TestCase;

class ReserveDoctorSlotsTest extends TestCase
{
    use RefreshDatabase;
    public function test_get_doctor_slot_return_a_successful_response(): void
    {
        $this->createDoctorAndSchedule();
        $client = $this->createClient();
        $slot= Slot::first();

        Sanctum::actingAs($client, ['*'], 'client');

        $this->post("api/v1/appointments/slots/{$slot->id}")->assertCreated();
        $this->assertDatabaseCount('reservations', 1);
    }
}
