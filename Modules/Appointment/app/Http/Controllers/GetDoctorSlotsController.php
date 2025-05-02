<?php

namespace Modules\Appointment\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Appointment\app\Actions\GetDoctorSlotsAction;
use Modules\Appointment\app\Transformers\GetDoctorSlotsResource;
use Modules\Auth\app\Models\Doctor;

class GetDoctorSlotsController extends Controller
{
    public function __invoke(Doctor $doctor, GetDoctorSlotsAction $action): JsonResponse
    {
        $slots= $action->execute($doctor->id);
        $slots= GetDoctorSlotsResource::collection($slots);
        return response()->json($slots);
    }
}
