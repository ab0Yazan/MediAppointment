<?php

namespace Modules\Appointment\app\Actions;

use Modules\Appointment\app\DataTransferObjects\CreateDoctorScheduleDto;
use Modules\Appointment\app\Events\DoctorScheduleCreated;
use Modules\Appointment\app\Exceptions\ScheduleAlreadyExistsException;
use Modules\Appointment\app\Models\DoctorSchedule;

class CreateDoctorScheduleAction
{
    public function execute(CreateDoctorScheduleDto $dto) : DoctorSchedule
    {
        $exists= DoctorSchedule::where("doctor_id", $dto->getDoctorId())
            ->where("week_day", $dto->getWeekDay())
            ->exists();

        if($exists) throw new ScheduleAlreadyExistsException();

        $doctorSchedule= DoctorSchedule::create([
            "doctor_id" => $dto->getDoctorId(),
            "week_day" => $dto->getWeekDay(),
            "start_time" => $dto->getStartTime(),
            "end_time" => $dto->getEndTime(),
        ]);


        event(new DoctorScheduleCreated($doctorSchedule->id));

        return $doctorSchedule;
    }
}
