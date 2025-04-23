<?php

namespace Modules\Auth\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Auth\app\Actions\DoctorRegisterAction;
use Modules\Auth\app\DataTransferObjects\DoctorDto;
use Tests\TestCase;

class DoctorLoginFeatureTest extends TestCase
{
    use RefreshDatabase;
    public function test_it_login_valid_cradentials (): void
    {
        (new DoctorRegisterAction())->execute(new DoctorDto("docx", "dox@x.c", "spec1"), "12345678");
        $response= $this->post("api/v1/doctor/auth/login", ["email" => "dox@x.c", "password"=>"12345678"], ['Accept' => 'application/json']);
        $response->assertStatus(200);
    }
}
