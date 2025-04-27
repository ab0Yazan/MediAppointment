<?php

namespace Modules\Auth\app\Actions;

use Modules\Auth\Actions\BaseLoginAction;
use Modules\Auth\Models\Client;

final class ClientLoginAction extends BaseLoginAction
{
    protected function getUserModel(): string
    {
        return Client::class;
    }
}
