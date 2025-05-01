<?php

namespace Modules\Appointment\tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Modules\Appointment\app\Http\Requests\CreateDoctorScheduleRequest;
use Modules\Appointment\app\Models\DoctorSchedule;
use Tests\TestCase;

class CreateDoctorScheduleRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_doctor_valid_request(): void
    {
        $doctor = $this->createDoctor();
        $data = [
            'doctor_id' => $doctor->id,
            'week_day' => 'mon',
            'start_time' => '09:00',
            'end_time' => '17:00',
        ];

        $request = new CreateDoctorScheduleRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->passes());
    }

    public function test_create_doctor_invalid_request(): void
    {

        $data = [
            'doctor_id' => null,
            'week_day' => 'dommy',
            'start_time' => '09:00',
            'end_time' => '08:00',
        ];

        $request = new CreateDoctorScheduleRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('week_day', $validator->errors()->toArray());
        $this->assertArrayHasKey('doctor_id', $validator->errors()->toArray());
        $this->assertArrayHasKey('end_time', $validator->errors()->toArray());
    }

    public function test_create_doctor_unique_doctor_id_and_week_day_request(): void
    {

        $doctor = $this->createDoctor();

        $data = [
            'doctor_id' => (int)$doctor->id,
            'week_day' => 'mon',
            'start_time' => '09:00',
            'end_time' => '15:00',
        ];

        DoctorSchedule::create($data);

        $request = new CreateDoctorScheduleRequest($data);

        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->fails());

        $this->assertArrayHasKey('week_day', $validator->errors()->toArray());
    }

}
