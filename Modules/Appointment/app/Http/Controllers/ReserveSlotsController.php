<?php

namespace Modules\Appointment\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Appointment\app\Actions\ReserveSlotAction;
use Modules\Appointment\app\Exceptions\CantReserveSlotException;
use Modules\Appointment\app\Models\Slot;
use Modules\Auth\Models\Client;

class ReserveSlotsController extends Controller
{
    public function __invoke(Slot $slot, ReserveSlotAction $action): JsonResponse
    {
        $client = Client::find(auth()->user()->id);
        try {
            $action->execute((int)$slot->id, $client);
        } catch (CantReserveSlotException $e) {
            return response()->json([
                'message' => 'This slot is already reserved',
                'error' => $e->getMessage()
            ], 409);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Reservation failed',
                'error' => $e->getMessage()
            ], 500);
        }
        return response()->json([], 201);
    }
}
