<?php

namespace Modules\Auth\Contracts;

use Modules\Auth\app\DataTransferObjects\LoginDto;

interface LoginActionInterface
{
    public function execute(LoginDto $dto): array;
}
