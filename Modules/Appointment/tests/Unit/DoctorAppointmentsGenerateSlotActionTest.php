<?php

namespace Modules\Appointment\tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Modules\Appointment\app\Actions\AppointmentGenerateSlotAction;
use Modules\Appointment\app\Actions\CreateDoctorScheduleAction;
use Modules\Appointment\app\DataTransferObjects\CreateDoctorScheduleDto;
use Modules\Appointment\app\Enums\WeekDay;
use Modules\Appointment\app\Events\DoctorScheduleCreated;
use Modules\Appointment\app\Listeners\GenerateScheduleSlot;
use Modules\Auth\app\Actions\DoctorRegisterAction;
use Modules\Auth\app\DataTransferObjects\DoctorDto;
use Tests\TestCase;

class DoctorAppointmentsGenerateSlotActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_generate_appointments_action()
    {
        Event::fake();
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

        $schedule = (new CreateDoctorScheduleAction())->execute( CreateDoctorScheduleDto::fromArray($data));
        $action = new AppointmentGenerateSlotAction();
        $slots = $action->execute($schedule);

        $this->assertNotEmpty($slots, "Appointments should not be empty.");

        foreach ($slots as $slot) {
            $start = \Carbon\Carbon::createFromFormat('H:i', $slot['start_time']);
            $end = \Carbon\Carbon::createFromFormat('H:i', $slot['end_time']);
            $this->assertEquals(30, $start->diffInMinutes($end), "Each slot should be 30 minutes.");
        }

        $this->assertEquals('09:00', $slots->first()->start_time);

        $lastAppointment = $slots->last();

        $this->assertEquals('17:00', $lastAppointment->end_time);

        $this->assertDatabaseHas("slots", $slots->first()->getAttributes());

        Event::assertDispatched(DoctorScheduleCreated::class);

        Event::assertListening(
            DoctorScheduleCreated::class, GenerateScheduleSlot::class
        );

    }

    public function test_listener_generate_schedule_slots()
    {
        Event::fake();

        //given
        $doctor= (new DoctorRegisterAction())->execute(DoctorDto::fromArray([
            "name" => "John Doe",
            "email" => "doc1@d.c",
            "speciality" => "heart",
        ]), "12345678");

        $data = [
            "doctor_id" => $doctor->id,
            "week_day" => WeekDay::from('sun'),
            "start_time" => "09:00",
            "end_time" => "17:00",
        ];

        //when
        $schedule = (new CreateDoctorScheduleAction())->execute( CreateDoctorScheduleDto::fromArray($data));
        $listener = new GenerateScheduleSlot();
        $listener->handle(new DoctorScheduleCreated($schedule->id));

        Event::assertDispatched(DoctorScheduleCreated::class);

        Event::assertListening(
            DoctorScheduleCreated::class, GenerateScheduleSlot::class
        );

        //then
        $this->assertDatabaseHas('slots', [
            'doctor_schedule_id' => $schedule->id,
        ]);

    }
}
