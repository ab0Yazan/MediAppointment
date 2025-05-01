<?php

namespace Modules\Geo\app\ValueObjects;

class GeoPoint
{

    private float $latitude;
    private float $longitude;

    public function __construct(float $latitude, float $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function getDistance(GeoPoint $other): Distance
    {
        $earthRadius = 6371000; // meters

        $latFrom = deg2rad($this->latitude);
        $lonFrom = deg2rad($this->longitude);
        $latTo = deg2rad($other->getLatitude());
        $lonTo = deg2rad($other->getLongitude());

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(
                pow(sin($latDelta / 2), 2) +
                cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)
            ));

        $distanceInMeters = $earthRadius * $angle;

        return new Distance($distanceInMeters);
    }

    public function isEqual(GeoPoint $other): bool
    {
        return $this->getDistance($other)->getMeters() < 50;
    }


}
