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
        return $this->meters;
    }

    public function getKilometers(): float
    {
        return $this->meters / 1000;
    }
}

