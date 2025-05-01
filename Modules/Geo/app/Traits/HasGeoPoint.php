<?php

namespace Modules\Geo\app\Traits;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\DB;
use Modules\Geo\app\DataTransferObjects\NearestGeoPointDto;
use Modules\Geo\app\Models\GeoPoint;

trait HasGeoPoint
{
    public function getGeoPoint(): \Modules\Geo\app\ValueObjects\GeoPoint
    {
        return new \Modules\Geo\app\ValueObjects\GeoPoint($this->geoPoint->latitude, $this->geoPoint->longitude);
    }

    public function geoPoint(): MorphOne
    {
        return $this->morphOne(GeoPoint::class, 'pointable');
    }


    public function getNearestGeoPoints(\Modules\Geo\app\ValueObjects\GeoPoint $point)
    {
        $lat = $point->getLatitude();
        $lon = $point->getLongitude();

        $collection= GeoPoint::select("id", "latitude", "longitude", "pointable_type", "pointable_id"
            ,DB::raw("6371 * acos(cos(radians(" . $lat . "))
                        * cos(radians(geo_points.latitude))
                        * cos(radians(geo_points.longitude) - radians(" . $lon . "))
                        + sin(radians(" .$lat. "))
                        * sin(radians(geo_points.latitude))) AS distance"))
            ->with('pointable')->get();



        return $collection->map(fn($item) => new NearestGeoPointDto(
            $item->distance,
            new \Modules\Geo\app\ValueObjects\GeoPoint($item->latitude, $item->longitude),
            $item->pointable
        )
        )->all();
    }


    public function createGeoPoint(float $latitude, float $longitude): GeoPoint
    {
        return $this->geoPoint()->updateOrCreate([
            'pointable_id' => $this->id,
            'pointable_type' => get_class($this),
        ], [
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);
    }
}
