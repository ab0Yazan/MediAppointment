<?php

namespace Modules\Appointment\app\Exceptions;

use Exception;

class ScheduleAlreadyExistsException extends Exception {
    protected $message = "A schedule for this doctor on this day already exists.";
}
