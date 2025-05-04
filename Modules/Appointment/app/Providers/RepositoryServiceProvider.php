<?php

namespace Modules\Appointment\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Appointment\app\Models\DoctorSchedule;
use Modules\Appointment\app\Models\Slot;
use Modules\Appointment\app\Repositories\Contracts\ScheduleRepositoryInterface;
use Modules\Appointment\app\Repositories\Contracts\SlotRepositoryInterface;
use Modules\Appointment\app\Repositories\ScheduleCacheRepository;
use Modules\Appointment\app\Repositories\ScheduleEloquentRepository;
use Modules\Appointment\app\Repositories\SlotCacheRepository;
use Modules\Appointment\app\Repositories\SlotEloquentRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void {
        $this->app->bind(SlotRepositoryInterface::class, function ($app) {
            return new SlotCacheRepository(
                new SlotEloquentRepository(new Slot()),
                $app->make('cache.store')
            );
        });

        $this->app->bind(ScheduleRepositoryInterface::class, function ($app) {
            return new ScheduleCacheRepository(
                new ScheduleEloquentRepository(resolve(DoctorSchedule::class)),
                $app->make('cache.store')
            );
        });
    }

    public function provides(): array
    {
        return [];
    }
}
