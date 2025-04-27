<?php

namespace Modules\Auth\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Auth\app\Actions\DoctorLoginAction;
use Modules\Auth\Http\Requests\LoginRequest;

final class DoctorLoginController extends Controller
{
    public function login(LoginRequest $request, DoctorLoginAction $action)
    {
        $data= $action->execute($request->getDto());
        return response()->json($data);
    }
}
