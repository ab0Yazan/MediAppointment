<?php

namespace Modules\Auth\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Auth\app\Actions\ClientLoginAction;
use Modules\Auth\app\Actions\ClientRegisterAction;
use Modules\Auth\app\Http\Controllers\ClientLoginController;
use Modules\Auth\DataTransferObjects\ClientDto;
use Modules\Auth\Http\Requests\LoginRequest;
use Tests\TestCase;
use function PHPUnit\Framework\assertArrayHasKey;

class ClientLoginControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_login(): void
    {
        $client= app(ClientRegisterAction::class)->execute(new ClientDto("client", "c@c.com"), "12345678");

        $data = [
            "email" => $client->email,
            "password" => "12345678",
        ];

        $request = new LoginRequest($data);
        $action = new ClientLoginAction();
        $controller = new ClientLoginController();
        $response = $controller->login($request, $action);
        $data= $response->getData(true);
        assertArrayHasKey('token', $data);
    }
}
