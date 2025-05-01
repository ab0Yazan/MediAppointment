<?php

namespace Modules\Geo\app\DataTransferObjects;

use Illuminate\Database\Eloquent\Model;
use Modules\Geo\app\ValueObjects\Distance;
use Modules\Geo\app\ValueObjects\GeoPoint;

class NearestGeoPointDto
{
    protected Distance $distance;
    protected GeoPoint $point;
    protected Model $model;
    public function __construct(float $distance, GeoPoint $point, Model $model)
    {
        $this->distance = new Distance($distance);
        $this->point = $point;
        $this->model = $model;
    }

    public function getDistance(): Distance
    {
        return $this->distance;
    }

    public function getGeoPoint(): GeoPoint
    {
        return $this->point;
    }

    public function getModel(): Model
    {
        return $this->model;
    }
}
