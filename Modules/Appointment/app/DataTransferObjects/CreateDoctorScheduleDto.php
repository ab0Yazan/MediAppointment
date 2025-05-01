<?php

namespace Modules\Appointment\app\DataTransferObjects;

use Modules\Appointment\app\Enums\WeekDay;
use Modules\Appointment\app\Models\DoctorSchedule;

final class CreateDoctorScheduleDto
{
    protected int $doctorId;
    protected WeekDay $weekDay;
    protected string $startTime;
    protected string $endTime;

    public function __construct(int $doctorId, WeekDay $weekDay, string $startTime, string $endTime)
    {
        $this->doctorId = $doctorId;
        $this->weekDay = $weekDay;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }

    public function getDoctorId(): int
    {
        return $this->doctorId;
    }

    public function getWeekDay(): WeekDay
    {
        return $this->weekDay;
    }

    public function getStartTime(): string
    {
        return $this->startTime;
    }

    public function getEndTime(): string
    {
        return $this->endTime;
    }

    public static function fromArray(array $data): CreateDoctorScheduleDto
    {
        return new self(
            $data['doctor_id'],
            $data['week_day'],
            $data['start_time'],
            $data['end_time']
        );
    }

    public static function fromModel(DoctorSchedule $model): CreateDoctorScheduleDto
    {
        return new self(
            $model->doctor_id,
            $model->week_day,
            $model->start_time,
            $model->end_time
        );
    }


}
