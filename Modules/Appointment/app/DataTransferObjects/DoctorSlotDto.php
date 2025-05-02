<?php

namespace Modules\Appointment\app\DataTransferObjects;

use Carbon\Carbon;

class DoctorSlotDto
{
    private int $slotId;
    private string $startTime;
    private string $endTime;
    private Carbon $date;

    public function __construct(int $slotId, string $startTime, string $endTime, Carbon $date)
    {
        $this->slotId = $slotId;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->date = $date;
    }

    public function getSlotId(): int
    {
        return $this->slotId;
    }

    public function getStartTime(): string
    {
        return $this->startTime;
    }

    public function getEndTime(): string
    {
        return $this->endTime;
    }

    public function getDate(): Carbon
    {
        return $this->date;
    }

    public function getStartDatetime(): Carbon
    {
        return Carbon::createFromFormat('d-m-Y H:i', $this->date->format('d-m-Y') . ' ' . $this->startTime);
    }

    public function getEndDatetime(): Carbon
    {
        return Carbon::createFromFormat('d-m-Y H:i', $this->date->format('d-m-Y') . ' ' . $this->endTime);
    }

}
