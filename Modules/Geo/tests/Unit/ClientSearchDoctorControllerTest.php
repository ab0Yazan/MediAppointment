<?php

namespace Modules\Geo\tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Geo\app\Actions\SearchNearestModelAction;
use Modules\Geo\app\Http\Controllers\SearchNearestDoctorController;
use Modules\Geo\app\Http\Requests\SearchNearestDoctorRequest;
use Tests\TestCase;

class ClientSearchDoctorControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_it_search_for_nearest_doctor_by_speciality(): void
    {
        $this->createDoctor("heart", fake()->email, "doc1")->createGeoPoint(fake()->latitude, fake()->longitude);
        $this->createDoctor("heart", fake()->email, "doc2")->createGeoPoint(fake()->latitude, fake()->longitude);
        $this->createDoctor("atomic", fake()->email, "doc3")->createGeoPoint(fake()->latitude, fake()->longitude);
        $this->createDoctor("brain", fake()->email, "doc4")->createGeoPoint(fake()->latitude, fake()->longitude);

        $data = [
            "latitude" => 30.4455,
            "longitude" => -82.8787,
            "speciality" => "heart",
        ];

        $request = new SearchNearestDoctorRequest($data);

        $action = new SearchNearestModelAction();

        $controller = new SearchNearestDoctorController();

        $response = $controller->__invoke($request, $action);

        $data= $response->getData(true);


        $this->assertCount(2, $data);

        $this->assertEquals("heart", $data[0]["doctor"]["speciality"]);
    }
}
