<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Appointment\app\Actions\CreateDoctorScheduleAction;
use Modules\Appointment\app\DataTransferObjects\CreateDoctorScheduleDto;
use Modules\Appointment\app\Enums\WeekDay;
use Modules\Auth\app\Actions\ClientRegisterAction;
use Modules\Auth\app\Actions\DoctorRegisterAction;
use Modules\Auth\app\DataTransferObjects\DoctorDto;
use Modules\Auth\app\Models\Doctor;
use Modules\Auth\DataTransferObjects\ClientDto;

abstract class TestCase extends BaseTestCase
{
    public function createDoctor($spec="heart", $email="doc@d.com", $name="doc"): Doctor
    {
        return  (new DoctorRegisterAction())->execute(DoctorDto::fromArray([
            "name" => $name,
            "email" => $email,
            "speciality" => $spec,
        ]), "12345678");
    }

    public function createDoctorAndSchedule() : Doctor
    {
        $doctor= $this->createDoctor();

        (resolve(CreateDoctorScheduleAction::class))->execute(CreateDoctorScheduleDto::fromArray([
            "doctor_id" => $doctor->id,
            "week_day" => WeekDay::TUE,
            "start_time" => "09:00",
            "end_time" => "17:00",
        ]));

        (resolve(CreateDoctorScheduleAction::class))->execute(CreateDoctorScheduleDto::fromArray([
            "doctor_id" => $doctor->id,
            "week_day" => WeekDay::THU,
            "start_time" => "09:00",
            "end_time" => "17:00",
        ]));

        return $doctor;
    }

    public function createClient()
    {
        return (new ClientRegisterAction())->execute(
            ClientDto::fromArray([
                "name" => fake()->name,
                "email" => fake()->email,
            ]),
            "12345678"
        );
    }
}
