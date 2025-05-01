<?php

namespace Modules\Geo\app\Actions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Geo\app\DataTransferObjects\NearestGeoPointDto;
use Modules\Geo\app\ValueObjects\GeoPoint;

class SearchNearestModelAction
{
    public function execute(GeoPoint $point, string $model, $where=[]): array
    {
        $lat = $point->getLatitude();
        $lon = $point->getLongitude();
        $joinTable = app($model)->getTable();

        if(!empty($where)){
            foreach($where as $key => $value){
                if (!Schema::hasColumn($joinTable, $key)){
                   throw new \InvalidArgumentException("no column with $key in $joinTable");
                }
            }
        }

        $collection = \Modules\Geo\app\Models\GeoPoint::join($joinTable, function ($join) use ($model, $joinTable, $where) {
            $join->on($joinTable . ".id", '=', 'geo_points.pointable_id');

            $join->where(function($query) use ($where, $joinTable, $model) {
                $query->where('geo_points.pointable_type', '=', $model);
                $query->when($where, function ($query) use ($where, $joinTable, $model) {
                    foreach ($where as $key => $value){
                        $query->where("$joinTable.$key", '=', $value);
                    }
                });

            });
        })
            ->select("geo_points.id", "latitude", "longitude", "pointable_type", "pointable_id"
                , DB::raw("6371 * acos(cos(radians(" . $lat . "))
                        * cos(radians(geo_points.latitude))
                        * cos(radians(geo_points.longitude) - radians(" . $lon . "))
                        + sin(radians(" . $lat . "))
                        * sin(radians(geo_points.latitude))) AS distance"))

            ->orderBy("distance", 'ASC')
            ->get();


        return $collection->map(fn($item) => new NearestGeoPointDto(
            $item->distance,
            new \Modules\Geo\app\ValueObjects\GeoPoint($item->latitude, $item->longitude),
            $item->pointable
        )
        )->all();
    }
}
