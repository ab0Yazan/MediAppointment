<?php

namespace Modules\Appointment\app\Actions;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Modules\Appointment\app\Models\DoctorSchedule;
use Modules\Appointment\app\Repositories\Contracts\SlotRepositoryInterface;

final class AppointmentGenerateSlotAction
{
    private SlotRepositoryInterface $repo;
    public function __construct(SlotRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }
    public function execute(DoctorSchedule $schedule, $slot_minutes=30)
    {
        $start = Carbon::createFromFormat('H:i', $schedule->start_time);
        $end = Carbon::createFromFormat('H:i', $schedule->end_time);
        if($end->lessThanOrEqualTo($start)) {
            throw new \InvalidArgumentException('End time must be after start time.');
        }

        $period= CarbonPeriod::create($start, "{$slot_minutes} minutes", $end)->excludeEndDate();

        $slots = [];

        foreach ($period as $date) {
            $start = $date->copy()->format('H:i');
            $end = $date->copy()->addMinutes($slot_minutes)->format('H:i');
            $week_day = $schedule->week_day->value;
            $date = Carbon::now()->next(ucfirst(strtolower($schedule->week_day->value)));
            $slots[] = ['doctor_schedule_id' => $schedule->id,'start_time' => $start, 'end_time' => $end, 'week_day' => $week_day, 'date' => $date];
        }

        $this->repo->bulkInsert($slots);
        $this->repo->findBy(['doctor_schedule_id' => $schedule->id]);

        return $schedule->slots;
    }
}
