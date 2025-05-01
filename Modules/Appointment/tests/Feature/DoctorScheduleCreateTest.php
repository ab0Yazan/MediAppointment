<?php

namespace Modules\Appointment\tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DoctorScheduleCreateTest extends TestCase
{
    use RefreshDatabase;
    public function test_create_doctor_schedule_return_a_successful_response(): void
    {
        $doctor= $this->createDoctor();

        Sanctum::actingAs($doctor);

        $data = [
            "week_day" => 'sat',
            "start_time" => "09:00",
            "end_time" => "14:00",
        ];

        $this->post('api/v1/appointments/schedule/create', $data)->assertCreated();
    }
}
