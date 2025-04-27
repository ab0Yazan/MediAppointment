<?php

namespace Modules\Auth\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Auth\app\Actions\ClientRegisterAction;
use Modules\Auth\DataTransferObjects\ClientDto;
use Modules\Auth\Models\Client;
use Tests\TestCase;

class RegisterClientActionTest extends TestCase
{
    use RefreshDatabase;
    public function test_create_client(): void
    {
        $data = [
          "name" => "John Doe",
          "email" => "c1@c.com",
          "password" => "12345678",
          "password_confirmation" => "12345678"
        ];

        $dto=  ClientDto::fromArray($data);
        $action = new ClientRegisterAction();
        $client = $action->execute($dto, $data['password']);
        $this->assertInstanceOf(Client::class, $client);
        $this->assertDatabaseHas('clients', $client->getAttributes());
    }
}
