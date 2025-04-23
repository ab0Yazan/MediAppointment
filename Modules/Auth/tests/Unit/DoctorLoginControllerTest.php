<?php

namespace Modules\Auth\tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Auth\app\Actions\DoctorLoginAction;
use Modules\Auth\app\Actions\DoctorRegisterAction;
use Modules\Auth\app\DataTransferObjects\DoctorDto;
use Modules\Auth\app\Http\Controllers\DoctorLoginController;
use Modules\Auth\app\Http\Controllers\DoctorRegisterController;
use Modules\Auth\Http\Requests\LoginRequest;
use Modules\Auth\Http\Requests\StoreRegisterRequest;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tests\TestCase;
use function PHPUnit\Framework\assertArrayHasKey;

class DoctorLoginControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_doctor_login_invalid_credentials()
    {
        $this->expectException(UnauthorizedHttpException::class);
        $data = [
            "email" => "e@e.c",
            "password" => "password",
        ];
        $request= new LoginRequest($data);
        $controller = new DoctorLoginController();
        $action= new DoctorLoginAction();
        $controller->login($request, $action);
    }

    public function test_doctor_login_valid_credentials()
    {
        $doctor= app(DoctorRegisterAction::class)->execute(new DoctorDto("mohamed", "m@m.com", "test"), "12345678");
        $data = [
            "email" => $doctor->email,
            "password" => "12345678",
        ];
        $request= new LoginRequest($data);
        $controller = new DoctorLoginController();
        $action= new DoctorLoginAction();
        $response= $controller->login($request, $action);
        $data= $response->getData(true);
        assertArrayHasKey('token', $data);
    }
}
