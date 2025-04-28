<?php

namespace Modules\Appointment\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Appointment\app\Actions\CreateDoctorScheduleAction;
use Modules\Appointment\app\Http\Requests\CreateDoctorScheduleRequest;

class DoctorScheduleController extends Controller
{
    public function create(CreateDoctorScheduleRequest $request, CreateDoctorScheduleAction $action): JsonResponse
    {
        $doctorSchedule = $action->execute($request->getDto());
        return response()->json($doctorSchedule, 201);
    }
}
