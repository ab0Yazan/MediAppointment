<?php

namespace Modules\Geo\app\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @method getModel()
 * @method getDistance()
 */
class GetSearchDoctorResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            "distance" => (string)$this->getDistance(),
            "doctor" => $this->getModel(),
        ];
    }
}
