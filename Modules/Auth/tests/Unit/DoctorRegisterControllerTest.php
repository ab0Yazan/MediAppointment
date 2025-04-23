<?php

namespace Modules\Auth\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Auth\app\Actions\DoctorRegisterAction;
use Modules\Auth\app\Http\Controllers\DoctorRegisterController;
use Modules\Auth\Http\Requests\StoreRegisterRequest;
use Tests\TestCase;

class DoctorRegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_doctor_register()
    {
        $data = [
            "name" => "Doctor x",
            "password" => "password",
            "password_confirmation" => "password",
            "speciality" => "speciality",
            "email" => "e@e.c",
        ];
        $request= new StoreRegisterRequest($data);
        $controller = new DoctorRegisterController();
        $action= new DoctorRegisterAction();
        $response= $controller->register($request, $action);
        $json= $response->getData(true);
        $this->assertArrayHasKey("email", $json["data"]);
        $this->assertDatabaseHas("doctors", ["name" => "Doctor x", "email" => "e@e.c"]);
    }

}
