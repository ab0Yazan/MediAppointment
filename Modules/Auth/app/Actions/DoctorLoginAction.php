<?php

namespace Modules\Auth\app\Actions;

use Modules\Auth\Actions\BaseLoginAction;
use Modules\Auth\app\Models\Doctor;

final class DoctorLoginAction extends BaseLoginAction
{
    protected function getUserModel(): string
    {
        return Doctor::class;
    }
}
