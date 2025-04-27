<?php

namespace Modules\Auth\app\Actions;

use Modules\Auth\app\DataTransferObjects\DoctorDto;
use Modules\Auth\app\Events\DoctorCreated;
use Modules\Auth\app\Models\Doctor;

class DoctorRegisterAction
{
    public static function execute(DoctorDto $dto, $password): Doctor
    {
        $doctor= Doctor::create([
            "name" => $dto->getName(),
            "email" => $dto->getEmail(),
            "speciality" => $dto->getSpeciality(),
            "password" => bcrypt($password),
        ]);

        /*** dispatch doctorCreatedEvent ***/
        event(new DoctorCreated($doctor->id));

        return $doctor;

    }

}
