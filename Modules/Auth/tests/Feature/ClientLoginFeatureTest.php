<?php

namespace Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Auth\app\Actions\ClientRegisterAction;
use Modules\Auth\app\DataTransferObjects\DoctorDto;
use Modules\Auth\DataTransferObjects\ClientDto;
use Tests\TestCase;

class ClientLoginFeatureTest extends TestCase
{
    use RefreshDatabase;
    public function test_it_login_valid_cradentials (): void
    {
        (new ClientRegisterAction())->execute(new ClientDto("clientx", "clientx@x.c"), "12345678");
        $response= $this->post("api/v1/client/auth/login", ["email" => "clientx@x.c", "password"=>"12345678"], ['Accept' => 'application/json']);
        $response->assertStatus(200);
    }
}
