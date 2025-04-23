<?php

namespace Modules\Auth\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Auth\app\Actions\DoctorRegisterAction;
use Modules\Auth\Http\Requests\StoreRegisterRequest;

class DoctorRegisterController extends Controller
{
    public function register(StoreRegisterRequest $request, DoctorRegisterAction $registerDoctorAction): \Illuminate\Http\JsonResponse
    {
        $doctor= $registerDoctorAction->execute($request->getDoctorDto(), $request->getPassword());
        return response()->json([
            "data" => $doctor,
        ], 201);
    }

}
