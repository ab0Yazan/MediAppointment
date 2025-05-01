<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Auth\app\Actions\DoctorRegisterAction;
use Modules\Auth\app\DataTransferObjects\DoctorDto;
use Modules\Auth\app\Models\Doctor;

abstract class TestCase extends BaseTestCase
{
    public function createDoctor(): Doctor
    {
        return  (new DoctorRegisterAction())->execute(DoctorDto::fromArray([
            "name" => "John Doe",
            "email" => "doc1@d.c",
            "speciality" => "heart",
        ]), "12345678");
    }
}
