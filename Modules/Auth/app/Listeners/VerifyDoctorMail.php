<?php

namespace Modules\Auth\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Modules\Auth\Events\DoctorCreated;

class VerifyDoctorMail
{
    /**
     * Create the event listener.
     */
    public function __construct() {}

    /**
     * Handle the event.
     */
    public function handle(DoctorCreated $event): void {
        $doctor = $event->getDoctor();
    }
}
