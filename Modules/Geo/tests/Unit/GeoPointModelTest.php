<?php

namespace Modules\Geo\tests\Unit;

use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Auth\app\Models\Doctor;
use Modules\Geo\app\DataTransferObjects\NearestGeoPointDto;
use Modules\Geo\app\Models\GeoPoint;
use Tests\TestCase;

class GeoPointModelTest extends TestCase
{
    use RefreshDatabase;


    public function test_geo_point_model_columns(): void
    {
        $doctor= Doctor::create([
            'name' => 'Doctor',
            'speciality' => 'heart',
            'email' => 'em@a.c',
            'password' => 'password',
        ]);

        $geoPoint = GeoPoint::create([
            'latitude' => 30.0444,
            'longitude' => 31.2357,
            'pointable_id' => $doctor->id,
            'pointable_type' => Doctor::class,
        ]);

        $this->assertDatabaseHas('geo_points', [
            'latitude' => 30.0444,
            'longitude' => 31.2357,
        ]);

        $this->assertEquals(30.0444, $geoPoint->latitude);
        $this->assertEquals(31.2357, $geoPoint->longitude);

        $this->assertNull($geoPoint->locationable);
    }

    public function test_geo_point_model_unique(): void
    {
        $this->expectException(UniqueConstraintViolationException::class);
        $doctor= Doctor::create([
            'name' => 'Doctor',
            'speciality' => 'heart',
            'email' => 'em@a.c',
            'password' => 'password',
        ]);

        $geoPoint = GeoPoint::create([
            'latitude' => 30.0444,
            'longitude' => 31.2357,
            'pointable_id' => $doctor->id,
            'pointable_type' => Doctor::class,
        ]);

        $geoPoint = GeoPoint::create([
            'latitude' => 30.0444,
            'longitude' => 31.2357,
            'pointable_id' => $doctor->id,
            'pointable_type' => Doctor::class,
        ]);

        $this->assertDatabaseHas('geo_points', [
            'latitude' => 30.0444,
            'longitude' => 31.2357,
        ]);

        $this->assertEquals(30.0444, $geoPoint->latitude);
        $this->assertEquals(31.2357, $geoPoint->longitude);

        $this->assertNull($geoPoint->locationable);
    }

    public function test_get_nearest_models()
    {
        $doctor1= Doctor::create([
            'name' => 'Doctor1',
            'speciality' => 'heart',
            'email' => 'em1@a.c',
            'password' => 'password',
        ]);

        GeoPoint::create([
            'latitude' => 30.0444,
            'longitude' => 31.2357,
            'pointable_id' => $doctor1->id,
            'pointable_type' => Doctor::class,
        ]);

        $doctor2= Doctor::create([
            'name' => 'Doctor2',
            'speciality' => 'heart',
            'email' => 'em2@a.c',
            'password' => 'password',
        ]);

        GeoPoint::create([
            'latitude' => 500.0448,
            'longitude' => 700.2359,
            'pointable_id' => $doctor2->id,
            'pointable_type' => Doctor::class,
        ]);

        $array= $doctor1->getNearestGeoPoints($doctor1->getGeoPoint());
        $this->assertIsArray($array);
        $this->assertCount(2, $array);
        $this->assertInstanceOf(NearestGeoPointDto::class, $array[0]);
        $this->assertEquals($doctor1->getGeoPoint()->getLatitude(), $array[0]->getGeoPoint()->getLatitude());
        $this->assertEquals($doctor1->name, $array[0]->getModel()->name);
    }

}
