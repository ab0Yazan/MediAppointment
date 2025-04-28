<?php

namespace Modules\Appointment\tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Modules\Auth\app\Actions\DoctorRegisterAction;
use Modules\Auth\app\DataTransferObjects\DoctorDto;
use Tests\TestCase;

class DoctorScheduleCreateTest extends TestCase
{
    use RefreshDatabase;
    public function test_create_doctor_schedule_return_a_successful_response(): void
    {
        $doctor= (new DoctorRegisterAction())->execute(DoctorDto::fromArray([
            "name" => "John Doe",
            "email" => "doc1@d.c",
            "speciality" => "heart",
        ]), "12345678");

        Sanctum::actingAs($doctor);

        $data = [
            "week_day" => 'sat',
            "start_time" => "09:00",
            "end_time" => "14:00",
        ];

        $this->post('api/v1/appointments/schedule/create', $data)->assertCreated();


    }
}
