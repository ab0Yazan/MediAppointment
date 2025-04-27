<?php

namespace Modules\Auth\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Modules\Auth\app\Actions\DoctorRegisterAction;
use Modules\Auth\app\DataTransferObjects\DoctorDto;
use Modules\Auth\app\Events\DoctorCreated;
use Modules\Auth\app\Models\Doctor;
use Tests\TestCase;

class RegisterDoctorActionTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     */
    public function test_create_doctor(): void
    {
        Event::fake();
        $data = [
          "name" => "Doctor x",
          "email" => "doctor@x.c",
          "speciality" => "Cardiology",
            "password" => "password",
        ];
        $dto = DoctorDto::fromArray($data);
        $action = new DoctorRegisterAction();
        $doctor = $action->execute($dto, $data["password"]);
        $this->assertInstanceOf(Doctor::class, $doctor);
        $this->assertDatabaseHas('doctors', $doctor->getAttributes());
        Event::assertDispatched(DoctorCreated::class);
    }
}
