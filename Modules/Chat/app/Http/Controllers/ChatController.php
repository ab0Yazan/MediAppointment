<?php

namespace Modules\Chat\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Chat\app\Actions\CreateMessageAction;
use Modules\Chat\Http\Requests\CreateMessageRequest;

class ChatController extends Controller
{
    public function sendMessage(CreateMessageRequest $request, CreateMessageAction $action)
    {
        $messageDto= $action->execute($request->getDto(), auth()->user(), $request->getDto()->to);
        return response()->json($messageDto);
    }
}
