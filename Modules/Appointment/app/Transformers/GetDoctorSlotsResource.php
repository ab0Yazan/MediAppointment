<?php

namespace Modules\Appointment\app\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetDoctorSlotsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "slotId" => $this->getSlotId(),
            "startDateTime" => $this->getStartDatetime(),
            "endDateTime" => $this->getEndDatetime()
        ];
    }
}
