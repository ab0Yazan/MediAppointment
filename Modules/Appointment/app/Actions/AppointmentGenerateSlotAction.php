<?php

namespace Modules\Appointment\app\Actions;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use Modules\Appointment\app\Models\DoctorSchedule;

final class AppointmentGenerateSlotAction
{
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

        DB::table('slots')->insert($slots);

        $schedule->with('slots');

        return $schedule->slots;
    }
}
