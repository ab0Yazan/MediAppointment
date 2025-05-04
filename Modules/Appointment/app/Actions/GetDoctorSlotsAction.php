<?php

namespace Modules\Appointment\app\Actions;


use Carbon\Carbon;
use Illuminate\Support\Collection;
use Modules\Appointment\app\DataTransferObjects\DoctorSlotDto;
use Modules\Appointment\app\Repositories\Contracts\SlotRepositoryInterface;
use Modules\Auth\app\Repositories\Contracts\DoctorRepositoryInterface;

class GetDoctorSlotsAction
{
    private SlotRepositoryInterface $slotRepo;
    private DoctorRepositoryInterface $doctorRepo;

    public function __construct(SlotRepositoryInterface $slotRepo, DoctorRepositoryInterface $doctorRepo)
    {
        $this->slotRepo = $slotRepo;
        $this->doctorRepo = $doctorRepo;
    }

    public function execute(int $doctorId): Collection
    {
        $doctor = $this->doctorRepo->find($doctorId);

        if (!$doctor) {
            throw new \InvalidArgumentException("invalid doctor id");
        }

        $slots = $this->slotRepo->getAvailableSlotsByDoctor($doctorId);

        return  $slots
            ->map(function ($slot) {
                return new DoctorSlotDto($slot->id, $slot->start_time, $slot->end_time, Carbon::createFromFormat('Y-m-d H:i:s', $slot->date));
            });
    }
}
