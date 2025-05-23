<?php

namespace Modules\Appointment\tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Appointment\app\Actions\CreateDoctorScheduleAction;
use Modules\Appointment\app\DataTransferObjects\CreateDoctorScheduleDto;
use Modules\Appointment\app\Enums\WeekDay;
use Modules\Appointment\app\Exceptions\ScheduleAlreadyExistsException;
use Modules\Appointment\app\Models\DoctorSchedule;
use Modules\Auth\app\Actions\DoctorRegisterAction;
use Modules\Auth\app\DataTransferObjects\DoctorDto;
use Tests\TestCase;

class DoctorCreateScheduleActionTest extends TestCase
{
    use RefreshDatabase;

    private function createSchedule($data): DoctorSchedule
    {
        $dto = CreateDoctorScheduleDto::fromArray($data);
        $action = resolve(CreateDoctorScheduleAction::class);
        return $action->execute($dto);
    }
    public function test_create_schedule(): void
    {
        $doctor= (new DoctorRegisterAction())->execute(DoctorDto::fromArray([
            "name" => "John Doe",
            "email" => "doc1@d.c",
            "speciality" => "heart",
        ]), "12345678");

        $data = [
            "doctor_id" => $doctor->id,
            "week_day" => WeekDay::from('sat'),
            "start_time" => "09:00",
            "end_time" => "17:00",
        ];

        $schedule= $this->createSchedule($data);

        $this->assertDatabaseHas("doctor_schedules", $schedule->getAttributes());
    }

    public function test_unique_doctor_id_and_week_day()
    {

        $this->expectException(ScheduleAlreadyExistsException::class);

        $doctor= $this->createDoctor();

        $data = [
            "doctor_id" => $doctor->id,
            "week_day" => WeekDay::from('sat'),
            "start_time" => "09:00",
            "end_time" => "17:00",
        ];

        $this->createSchedule($data);

        //same doctor and week day
        $this->createSchedule($data);
    }
}
