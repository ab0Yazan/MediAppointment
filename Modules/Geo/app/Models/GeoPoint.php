<?php

namespace Modules\Geo\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method static create(array $array)
 */
class GeoPoint extends Model
{
    use HasFactory;

    protected $fillable = ['latitude', 'longitude', 'pointable_type', 'pointable_id'];

    public function pointable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }
}
