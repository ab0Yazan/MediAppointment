<?php

namespace Modules\Appointment\app\Actions;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Modules\Appointment\app\DataTransferObjects\ReservationDto;
use Modules\Appointment\app\Enums\ReservationStatus;
use Modules\Appointment\app\Events\SlotIsReservedEvent;
use Modules\Appointment\app\Exceptions\CantReserveSlotException;
use Modules\Appointment\app\Repositories\Contracts\ReservationRepositoryInterface;
use Modules\Appointment\app\Repositories\Contracts\SlotRepositoryInterface;
use Modules\Auth\Models\Client;

class ReserveSlotAction
{
    private SlotRepositoryInterface $slotRepo;
    private ReservationRepositoryInterface $reservationRepo;

    public function __construct(SlotRepositoryInterface $slotRepo, ReservationRepositoryInterface $reservationRepo)
    {
        $this->slotRepo = $slotRepo;
        $this->reservationRepo = $reservationRepo;
    }
    public function execute(int $slotId, Client $client)
    {
        $lockKey = "lock:slot:$slotId";
        $lock = Cache::lock($lockKey, 5);

        try {
            return $lock->block(5, function () use ($slotId, $client) {
                return DB::transaction(function () use ($slotId, $client) {

                    $slot= $this->slotRepo->findWithLock($slotId);

                    if ($this->slotRepo->isReserved($slotId)) {
                        throw new CantReserveSlotException();
                    }

                    $reservation= $this->reservationRepo->create([
                        'slot_id' => $slotId,
                        'client_id' => $client->id,
                        'status' => ReservationStatus::UNDER_PAID
                    ]);

                    Event::dispatch(new SlotIsReservedEvent((int) $slot->id));


                    $reservation = $this->reservationRepo->findWithLoad($reservation->id, ['client', 'slot.doctor']);

                    return ReservationDto::fromArray([
                        'reservationId' => $reservation->id,
                        'clientId' => $reservation->client_id,
                        'slotId' => $reservation->slot_id,
                        'status' => $reservation->status,
                        'clientName' => $reservation->client->name,
                        'doctorName' => $reservation->slot->doctor->name,
                    ]);
                });
            });

        }
        catch (\Throwable $e){
            report($e);
            throw new CantReserveSlotException();
        }

    }
}
