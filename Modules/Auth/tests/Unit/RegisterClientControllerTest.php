<?php

namespace Modules\Auth\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Auth\app\Actions\ClientRegisterAction;
use Modules\Auth\Http\Controllers\RegisterClientController;
use Modules\Auth\Http\Requests\StoreClientRequest;
use Tests\TestCase;

class RegisterClientControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_client_register(): void
    {
        $data = [
          "name" => "john doe",
          "email" => "c1@c.com",
          "password" => "12345678",
          "password_confirmation" => "12345678"
        ];

        $controller= new RegisterClientController();
        $request = new StoreClientRequest($data);
        $action= new ClientRegisterAction();
        $response= $controller->register($request, $action);
        $json= $response->getData(true);
        $this->assertArrayHasKey("email", $json["data"]);
        $this->assertDatabaseHas("clients", ["name" => "john doe", "email" => "c1@c.com"]);
    }
}
