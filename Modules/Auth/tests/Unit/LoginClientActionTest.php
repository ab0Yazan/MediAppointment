<?php

namespace Modules\Auth\Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Auth\app\Actions\ClientLoginAction;
use Modules\Auth\app\Actions\ClientRegisterAction;
use Modules\Auth\app\DataTransferObjects\LoginDto;
use Modules\Auth\DataTransferObjects\ClientDto;
use Modules\Auth\Models\Client;
use Tests\TestCase;

class LoginClientActionTest extends TestCase
{
    use RefreshDatabase;
    public function test_client_login(): void
    {

        $client= (new ClientRegisterAction())->execute(ClientDto::fromArray([
            "name" => "John Doe",
            "email" => "c1@c.com"
        ]), "12345678");

        $data = [
            'email' => $client->email,
            'password' => '12345678',
        ];

        $action= new ClientLoginAction();
        $data= $action->execute(LoginDto::fromArray(["email" => $client->email, "password" => "12345678"]));
        $this->assertArrayHasKey("token", $data);

    }
}
