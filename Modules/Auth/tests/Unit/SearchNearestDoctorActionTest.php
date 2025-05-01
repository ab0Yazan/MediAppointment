<?php

namespace Modules\Auth\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Auth\app\Models\Doctor;
use Modules\Geo\app\Actions\SearchNearestModelAction;
use Modules\Geo\app\ValueObjects\GeoPoint;
use Tests\TestCase;

class SearchNearestDoctorActionTest extends TestCase
{

    use RefreshDatabase;
    public function test_search_nearest_doctor(): void
    {
        $latitude = 31.2357;
        $longitude = 20.2645;
        $type = Doctor::class;

        $point = new GeoPoint($latitude, $longitude);

        $action = new SearchNearestModelAction();

        $doctor1 = Doctor::create([
            'name' => 'Doctor',
            'speciality' => 'heart',
            'email' => 'em1@a.c',
            'password' => 'password',
        ]);

        $doctor2 = Doctor::create([
            'name' => 'Doctor',
            'speciality' => 'heart',
            'email' => 'em2@a.c',
            'password' => 'password',
        ]);

        \Modules\Geo\app\Models\GeoPoint::create([
            'latitude' => 30.0444,
            'longitude' => 31.2357,
            'pointable_id' => $doctor1->id,
            'pointable_type' => Doctor::class,
        ]);

        \Modules\Geo\app\Models\GeoPoint::create([
            'latitude' => 31.0444,
            'longitude' => 20.2357,
            'pointable_id' => $doctor2->id,
            'pointable_type' => Doctor::class,
        ]);


        $array = $action->execute($point, $type, ["speciality" => "heart"]);

        $this->assertIsArray($array);
        $this->assertCount(2, $array);
        $this->assertEquals(31.0444, $array[0]->getGeoPoint()->getLatitude());
        $this->assertEquals("heart", $array[0]->getModel()->speciality);
    }
}
