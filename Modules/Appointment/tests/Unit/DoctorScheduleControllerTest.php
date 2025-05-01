<?php

namespace Modules\Appointment\tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\Sanctum;
use Modules\Appointment\app\Actions\CreateDoctorScheduleAction;
use Modules\Appointment\app\Enums\WeekDay;
use Modules\Appointment\app\Exceptions\ScheduleAlreadyExistsException;
use Modules\Appointment\Http\Controllers\DoctorScheduleController;
use Modules\Appointment\app\Http\Requests\CreateDoctorScheduleRequest;
use Modules\Auth\app\Actions\DoctorRegisterAction;
use Modules\Auth\app\DataTransferObjects\DoctorDto;
use Tests\TestCase;

class DoctorScheduleControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_create_doctor_schedule(): void
    {
        $doctor= (new DoctorRegisterAction())->execute(DoctorDto::fromArray([
            "name" => "John Doe",
            "email" => "doc1@d.c",
            "speciality" => "heart",
        ]), "12345678");

        Sanctum::actingAs($doctor);
        $data = [
            "week_day" => WeekDay::from('sat')->value,
            "start_time" => "09:00",
            "end_time" => "17:00"
        ];
        $request = new CreateDoctorScheduleRequest($data);
        $controller = new DoctorScheduleController();
        $action = new CreateDoctorScheduleAction();
        $response = $controller->create($request, $action);
        self::assertTrue($response->isSuccessful());
        $this->assertDatabaseHas("doctor_schedules", $data);
    }

    public function test_create_doctor_schedule_invalid_body(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $doctor= $this->createDoctor();

        Sanctum::actingAs($doctor);

        $data = [

            "week_day" => WeekDay::from('sat')->value,
            "start_time" => "09:00",
            "end_time" => "08:00"
        ];
        $request = new CreateDoctorScheduleRequest();
        $request->merge($data);
        $validator = Validator::make($data, $request->rules());
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('end_time', $validator->errors()->toArray());

        $controller = new DoctorScheduleController();
        $action = new CreateDoctorScheduleAction();
        $controller->create($request, $action);
        $this->assertDatabaseHas("doctor_schedules", $data);
    }
    public function test_create_doctor_unique_doctor_id_and_week_day()
    {
        $this->expectException(ScheduleAlreadyExistsException::class);
        $doctor= $this->createDoctor();

        Sanctum::actingAs($doctor);

        $data = [
            "week_day" => WeekDay::from('sat')->value,
            "start_time" => "09:00",
            "end_time" => "15:00"
        ];

        $request = new CreateDoctorScheduleRequest();
        $request->merge($data);

        $controller = new DoctorScheduleController();
        $action = new CreateDoctorScheduleAction();
        $controller->create($request, $action);

        //create same doctor_id, week_day
        $controller->create($request, $action);
    }

}
