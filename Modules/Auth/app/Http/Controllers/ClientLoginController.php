<?php
namespace Modules\Auth\app\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\Auth\app\Actions\ClientLoginAction;
use Modules\Auth\Http\Requests\LoginRequest;

final class ClientLoginController
{
    public function login(LoginRequest $request, ClientLoginAction $action): JsonResponse
    {
        $data = $action->execute($request->getDto());
        return response()->json($data);
    }
}
