<?php

namespace Modules\Appointment\app\Repositories\Contracts;

interface SlotRepositoryInterface extends RepositoryInterface
{
    public function getAvailableSlotsByDoctor(int $doctorId);
    public function findWithLock(int $id);
    public function isReserved(int $id):bool;
}
