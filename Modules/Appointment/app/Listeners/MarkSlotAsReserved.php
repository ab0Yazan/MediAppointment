<?php

namespace Modules\Appointment\app\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Appointment\app\Models\Slot;

class MarkSlotAsReserved
{
    /**
     * Create the event listener.
     */
    public function __construct() {}

    /**
     * Handle the event.
     */
    public function handle($event): void {
        $slot = Slot::find($event->getSlotId());
        $slot->reserve();
    }
}
