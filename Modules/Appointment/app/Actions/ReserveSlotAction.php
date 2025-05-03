<?php

namespace Modules\Appointment\app\Actions;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Modules\Appointment\app\DataTransferObjects\ReservationDto;
use Modules\Appointment\app\Enums\ReservationStatus;
use Modules\Appointment\app\Events\SlotIsReservedEvent;
use Modules\Appointment\app\Exceptions\CantReserveSlotException;
use Modules\Appointment\app\Models\Slot;
use Modules\Appointment\Models\Reservation;
use Modules\Auth\Models\Client;

class ReserveSlotAction
{
    public function execute(int $slotId, Client $client)
    {
        $lockKey = "lock:slot:$slotId";
        $lock = Cache::lock($lockKey, 5);

        try {
            return $lock->block(5, function () use ($slotId, $client) {
                return DB::transaction(function () use ($slotId, $client) {
                    $slot = Slot::lockForUpdate($slotId);

                    if ($slot->isReserved()) {
                        throw new CantReserveSlotException();
                    }

                    $reservation = Reservation::create([
                        'slot_id' => $slotId,
                        'client_id' => $client->id,
                        'status' => ReservationStatus::UNDER_PAID
                    ]);

                    Event::dispatch(new SlotIsReservedEvent((int) $slot->id));

                    return ReservationDto::fromArray([
                        'reservationId' => $reservation->id,
                        'clientId' => $reservation->client_id,
                        'slotId' => $reservation->slot_id,
                        'status' => $reservation->status,
                        'clientName' => $client->name,
                        'doctorName' => $slot->doctor->name,
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
