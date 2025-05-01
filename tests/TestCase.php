<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Auth\app\Actions\DoctorRegisterAction;
use Modules\Auth\app\DataTransferObjects\DoctorDto;
use Modules\Auth\app\Models\Doctor;

abstract class TestCase extends BaseTestCase
{
    public function createDoctor($spec="heart", $email="doc@d.com", $name="doc"): Doctor
    {
        return  (new DoctorRegisterAction())->execute(DoctorDto::fromArray([
            "name" => $name,
            "email" => $email,
            "speciality" => $spec,
        ]), "12345678");
    }
}
