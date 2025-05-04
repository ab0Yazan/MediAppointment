<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Appointment\app\Repositories\Contracts\ReservationRepositoryInterface;
use Modules\Appointment\app\Repositories\ReservationCacheRepository;
use Modules\Appointment\app\Repositories\ReservationEloquentRepository;
use Modules\Appointment\Models\Reservation;
use Modules\Auth\app\Repositories\Contracts\DoctorRepositoryInterface;
use Modules\Auth\app\Repositories\DoctorCacheRepository;
use Modules\Auth\app\Repositories\DoctorEloquentRepository;
use Modules\Appointment\Providers\RepositoryServiceProvider;
use Modules\Auth\app\Models\Doctor;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(RepositoryServiceProvider::class);
        $this->app->bind(DoctorRepositoryInterface::class, function ($app) {
            return new DoctorCacheRepository(
                new DoctorEloquentRepository(new Doctor()),
                $app->make('cache.store')
            );
        });
        $this->app->bind(ReservationRepositoryInterface::class, function ($app) {
            return new ReservationCacheRepository(
                new ReservationEloquentRepository(new Reservation()),
                $app->make('cache.store')
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
