<?php

namespace Modules\Appointment\tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Modules\Appointment\app\Actions\CreateDoctorScheduleAction;
use Modules\Appointment\app\Actions\GetDoctorSlotsAction;
use Modules\Appointment\app\DataTransferObjects\CreateDoctorScheduleDto;
use Modules\Appointment\app\DataTransferObjects\DoctorSlotDto;
use Modules\Appointment\app\Enums\WeekDay;
use Modules\Appointment\app\Exceptions\ScheduleAlreadyExistsException;
use Tests\TestCase;

class ListDoctorAppointmentsActionTest extends TestCase
{
    use RefreshDatabase;


    public function test_it_returns_empty_slots(): void
    {
        $doctor = $this->createDoctor();

        $action = new GetDoctorSlotsAction();

        $slots = $action->execute($doctor->id);

        $this->assertInstanceOf(Collection::class ,$slots);

        $this->assertTrue($slots->isEmpty());

        $this->assertTrue($slots->isEmpty());
    }

    /**
     * @throws ScheduleAlreadyExistsException
     */
    public function test_it_returns_doctor_available_slots(): void
    {
        $doctor = $this->createDoctor();

        (new CreateDoctorScheduleAction())->execute(CreateDoctorScheduleDto::fromArray([
            "doctor_id" => $doctor->id,
            "week_day" => WeekDay::SUN,
            "start_time" => "09:00",
            "end_time" => "17:00",
        ]));

        (new CreateDoctorScheduleAction())->execute(CreateDoctorScheduleDto::fromArray([
            "doctor_id" => $doctor->id,
            "week_day" => WeekDay::THU,
            "start_time" => "09:00",
            "end_time" => "17:00",
        ]));

        $action = new GetDoctorSlotsAction();
        $slots = $action->execute($doctor->id);
        $this->assertInstanceOf(Collection::class ,$slots);
        $this->assertTrue($slots->isNotEmpty());
        $this->assertTrue($slots->first() instanceof DoctorSlotDto);
    }

    public function test_it_throw_exception_if_doctor_not_found(): void
    {
        $doctor = $this->createDoctor();

        (new CreateDoctorScheduleAction())->execute(CreateDoctorScheduleDto::fromArray([
            "doctor_id" => $doctor->id,
            "week_day" => WeekDay::SUN,
            "start_time" => "09:00",
            "end_time" => "17:00",
        ]));

        (new CreateDoctorScheduleAction())->execute(CreateDoctorScheduleDto::fromArray([
            "doctor_id" => $doctor->id,
            "week_day" => WeekDay::THU,
            "start_time" => "09:00",
            "end_time" => "17:00",
        ]));


        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("invalid doctor id");
        $action = new GetDoctorSlotsAction();
        $slots = $action->execute(55); // no doctor with id 55

    }
}
