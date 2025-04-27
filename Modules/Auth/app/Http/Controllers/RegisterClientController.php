<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Auth\app\Actions\ClientRegisterAction;
use Modules\Auth\Http\Requests\StoreClientRequest;

final class RegisterClientController extends Controller
{
    public function register(StoreClientRequest $request, ClientRegisterAction $action) : JsonResponse
    {
        $client = $action->execute($request->getClientDto(), $request->getPassword());
        return response()->json([
            "data" => $client,
        ], 201);
    }
}
