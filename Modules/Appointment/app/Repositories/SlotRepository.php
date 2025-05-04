<?php

namespace Modules\Appointment\app\Repositories;

use Modules\Appointment\app\Models\Slot;
use Modules\Appointment\app\Repositories\Contracts\SlotRepositoryInterface;

final class SlotRepository extends EloquentRepository implements SlotRepositoryInterface
{
    public function __construct(Slot $model){
        parent::__construct($model);
    }

}
