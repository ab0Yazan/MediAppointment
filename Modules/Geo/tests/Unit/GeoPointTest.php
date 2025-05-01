<?php

namespace Modules\Geo\tests\Unit;

use Modules\Geo\app\ValueObjects\Distance;
use Modules\Geo\app\ValueObjects\GeoPoint;
use Tests\TestCase;

class GeoPointTest extends TestCase
{

    public function test_geo_point_creation(): void
    {
        $geo = new GeoPoint(30.0444, 31.2357);

        $this->assertEquals(30.0444, $geo->getLatitude());
        $this->assertEquals(31.2357, $geo->getLongitude());
    }

    public function test_get_distance_from_other_point()
    {
        $geo1 = new GeoPoint(30.0444, 31.2357); // Cairo
        $geo2 = new GeoPoint(31.0444, 35.2357); // Approx. Amman, Jordan

        $distance = $geo1->getDistance($geo2);

        $this->assertInstanceOf(Distance::class, $distance);

        $meters = $distance->getMeters();

        $this->assertGreaterThan(390000, $meters);
        $this->assertLessThan(410000, $meters);

        $this->assertEqualsWithDelta(398.8, $distance->getKilometers(), 1);
    }

    public function test_points_are_equal_within_threshold()
    {
        $pointA = new GeoPoint(30.0444, 31.2357);
        $pointB = new GeoPoint(30.0445, 31.2358);

        $this->assertTrue($pointA->isEqual($pointB));
    }

    public function test_points_are_not_equal_when_far_apart(): void
    {
        $pointA = new GeoPoint(30.0444, 31.2357);
        $pointB = new GeoPoint(40.7128, -74.0060);

        $this->assertFalse($pointA->isEqual($pointB));
    }

    public function test_distance_returns_expected_format(): void
    {
        $pointA = new GeoPoint(30.0444, 31.2357);
        $pointB = new GeoPoint(30.0500, 31.2500);

        $distance = $pointA->getDistance($pointB);

        $this->assertInstanceOf(Distance::class, $distance);
        $this->assertGreaterThan(0, $distance->getMeters());
    }

}
