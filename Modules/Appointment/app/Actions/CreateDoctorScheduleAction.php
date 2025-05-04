<?php

namespace Modules\Appointment\app\Actions;

use Modules\Appointment\app\DataTransferObjects\CreateDoctorScheduleDto;
use Modules\Appointment\app\Events\DoctorScheduleCreated;
use Modules\Appointment\app\Exceptions\ScheduleAlreadyExistsException;
use Modules\Appointment\app\Models\DoctorSchedule;
use Modules\Appointment\app\Repositories\Contracts\ScheduleRepositoryInterface;

class CreateDoctorScheduleAction
{
    private ScheduleRepositoryInterface $repo;
    public function __construct(ScheduleRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }
    public function execute(CreateDoctorScheduleDto $dto) : DoctorSchedule
    {
        $exists = $this->repo->findOneBy(["doctor_id" => $dto->getDoctorId(), "week_day" => $dto->getWeekDay()]);

        if($exists) throw new ScheduleAlreadyExistsException();

        $doctorSchedule = $this->repo->create([
            "doctor_id" => $dto->getDoctorId(),
            "week_day" => $dto->getWeekDay(),
            "start_time" => $dto->getStartTime(),
            "end_time" => $dto->getEndTime(),
        ]);

        event(new DoctorScheduleCreated($doctorSchedule->id));

        return $doctorSchedule;
    }
}
