<?php

namespace Modules\Appointment\app\Actions;


use Carbon\Carbon;
use Illuminate\Support\Collection;
use Modules\Appointment\app\DataTransferObjects\DoctorSlotDto;
use Modules\Appointment\app\Models\Slot;
use Modules\Auth\app\Models\Doctor;

class GetDoctorSlotsAction
{
    public function execute(int $doctorId): Collection
    {
        if(!Doctor::find($doctorId)){
            throw new \InvalidArgumentException("invalid doctor id");
        }

        return Slot::join('doctor_schedules', 'doctor_schedules.id', '=', 'slots.doctor_schedule_id')
            ->where("doctor_schedules.doctor_id", $doctorId)
            ->whereDate("slots.date", ">=", now())
            ->select("slots.start_time", "slots.end_time", "slots.date", "slots.id")
            ->get()
            ->map(function ($slot) {
                return new DoctorSlotDto($slot->id, $slot->start_time, $slot->end_time, Carbon::createFromFormat('Y-m-d H:i:s', $slot->date));
            });
    }
}
