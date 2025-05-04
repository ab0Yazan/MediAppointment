<?php

namespace Modules\Appointment\tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Appointment\app\Actions\CreateDoctorScheduleAction;
use Modules\Appointment\app\Actions\GetDoctorSlotsAction;
use Modules\Appointment\app\DataTransferObjects\CreateDoctorScheduleDto;
use Modules\Appointment\app\Enums\WeekDay;
use Modules\Appointment\app\Http\Controllers\GetDoctorSlotsController;
use Tests\TestCase;

class ListDoctorSlotsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_return_list_of_slots_response(): void
    {

        $doctor = $this->createDoctor();
        (resolve(CreateDoctorScheduleAction::class))->execute(CreateDoctorScheduleDto::fromArray([
            "doctor_id" => $doctor->id,
            "week_day" => WeekDay::SUN,
            "start_time" => "09:00",
            "end_time" => "17:00",
        ]));

        (resolve(CreateDoctorScheduleAction::class))->execute(CreateDoctorScheduleDto::fromArray([
            "doctor_id" => $doctor->id,
            "week_day" => WeekDay::THU,
            "start_time" => "09:00",
            "end_time" => "17:00",
        ]));

        $controller = new GetDoctorSlotsController();
        $action= resolve(GetDoctorSlotsAction::class);
        $response = $controller->__invoke($doctor, $action);

        $this->assertArrayHasKey('startDateTime', $response->getData(true)[0]);
        $this->assertArrayHasKey('endDateTime', $response->getData(true)[0]);
        $this->assertArrayHasKey('slotId', $response->getData(true)[0]);
    }
}
