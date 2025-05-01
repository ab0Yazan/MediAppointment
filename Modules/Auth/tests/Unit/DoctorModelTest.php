<?php

namespace Modules\Auth\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Geo\app\Models\GeoPoint;
use Tests\TestCase;

class DoctorModelTest extends TestCase
{
    use RefreshDatabase;
    public function test_doctor_create_geo_point(): void
    {
        $doctor = $this->createDoctor();

        $longtitude = 20.2645;
        $latitude = 31.2357;
        $geoPoint= $doctor->createGeoPoint($latitude, $longtitude);
        $this->assertInstanceOf(GeoPoint::class, $geoPoint);
        $this->assertDatabaseHas('geo_points', ['longitude' => $longtitude, 'latitude' => $latitude]);
    }
}
