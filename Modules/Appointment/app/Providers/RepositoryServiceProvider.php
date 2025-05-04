<?php

namespace Modules\Appointment\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Appointment\app\Models\Slot;
use Modules\Appointment\app\Repositories\CachingRepository;
use Modules\Appointment\app\Repositories\Contracts\SlotRepositoryInterface;
use Modules\Appointment\app\Repositories\SlotRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void {
        $this->app->bind(
            SlotRepositoryInterface::class,
            function($app) {
                $baseRepository = new SlotRepository($app->make(Slot::class));
                return new CachingRepository(
                    $baseRepository,
                    $app['cache.store'],
                    config('cache.time', 60)
                );
            }
        );
    }

    public function provides(): array
    {
        return [];
    }
}
