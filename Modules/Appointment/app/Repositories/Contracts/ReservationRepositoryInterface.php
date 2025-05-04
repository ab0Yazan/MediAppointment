<?php

namespace Modules\Appointment\app\Repositories\Contracts;

interface ReservationRepositoryInterface extends RepositoryInterface
{
    public function findWithLoad(int $id, array $with, array $columns = ['*']);
}
