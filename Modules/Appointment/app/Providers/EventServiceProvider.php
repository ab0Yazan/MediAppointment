<?php

namespace Modules\Appointment\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Appointment\app\Events\DoctorScheduleCreated;
use Modules\Appointment\app\Events\SlotIsReservedEvent;
use Modules\Appointment\app\Listeners\GenerateScheduleSlot;
use Modules\Appointment\app\Listeners\MarkSlotAsReserved;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array<string, array<int, string>>
     */
    protected $listen = [
        DoctorScheduleCreated::class => [
            GenerateScheduleSlot::class,
        ],
        SlotIsReservedEvent::class => [
            MarkSlotAsReserved::class
        ]
    ];

    /**
     * Indicates if events should be discovered.
     *
     * @var bool
     */
    protected static $shouldDiscoverEvents = true;

    /**
     * Configure the proper event listeners for email verification.
     */
    protected function configureEmailVerification(): void {}
}
