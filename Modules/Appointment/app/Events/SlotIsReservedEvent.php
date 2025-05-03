<?php

namespace Modules\Appointment\app\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

final class SlotIsReservedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private int $slotId;

    public function __construct(int $slotId) {
        $this->slotId = $slotId;
    }

    public function getSlotId(): int
    {
        return $this->slotId;
    }

}
