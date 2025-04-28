<?php

namespace Modules\Appointment\app\Actions;

use Modules\Appointment\app\DataTransferObjects\CreateDoctorScheduleDto;
use Modules\Appointment\Events\DoctorScheduleCreated;
use Modules\Appointment\Models\DoctorSchedule;

class CreateDoctorScheduleAction
{
    public function execute(CreateDoctorScheduleDto $dto) : DoctorSchedule
    {
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
