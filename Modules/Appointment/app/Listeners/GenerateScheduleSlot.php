<?php

namespace Modules\Appointment\app\Listeners;

use Modules\Appointment\app\Actions\AppointmentGenerateSlotAction;
use Modules\Appointment\app\Events\DoctorScheduleCreated;
use Modules\Appointment\app\Models\DoctorSchedule;

class GenerateScheduleSlot
{

    public function __construct()
    {
    }


    public function handle(DoctorScheduleCreated $event): void
    {
        $scheduleId = $event->getScheduleId();
        $doctorSchedule = DoctorSchedule::where('id', $scheduleId)->first();
        (new AppointmentGenerateSlotAction())->execute($doctorSchedule);
    }
}
