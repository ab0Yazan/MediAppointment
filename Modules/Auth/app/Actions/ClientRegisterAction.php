<?php

namespace Modules\Auth\app\Actions;

use Illuminate\Support\Facades\Hash;
use Modules\Auth\app\Events\ClientCreated;
use Modules\Auth\DataTransferObjects\ClientDto;
use Modules\Auth\Models\Client;

class ClientRegisterAction
{

    public function __construct()
    {
    }

    public function execute(ClientDto $dto, string $password)
    {
        $client= Client::create([
            'name'=>$dto->getName(),
            'email'=>$dto->getEmail(),
            'password'=>Hash::make($password),
        ]);

        event(new ClientCreated($client->id));


        return $client;
    }
}
