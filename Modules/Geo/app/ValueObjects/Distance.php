<?php

namespace Modules\Geo\app\ValueObjects;

final class Distance
{
    private float $meters;

    public function __construct(float $meters)
    {
        $this->meters = $meters;
    }

    public function getMeters(): float
    {
        return round($this->meters, 1);
    }

    public function getKilometers(): float
    {
        return $this->meters / 1000;
    }

    public function __toString()
    {
        return $this->getMeters() . " Meters";
    }
}

