<?php

namespace Modules\Appointment\app\Exceptions;

use Exception;

class CantReserveSlotException extends Exception {
    protected $message = 'The requested slot is already reserved';
}
