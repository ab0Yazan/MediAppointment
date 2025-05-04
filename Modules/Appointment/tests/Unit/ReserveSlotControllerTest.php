<?php

namespace Modules\Appointment\tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Modules\Appointment\app\Actions\ReserveSlotAction;
use Modules\Appointment\app\Http\Controllers\ReserveSlotsController;
use Modules\Appointment\app\Models\Slot;
use Tests\TestCase;

class ReserveSlotControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_that_true_is_true(): void
    {
        $this->createDoctorAndSchedule();
        $client1 = $this->createClient();
        $this->createClient();
        $slot = Slot::first();
        $slot2 = Slot::orderBy('id', 'DESC')->first();


        Sanctum::actingAs($client1);

        $controller = new ReserveSlotsController();
        $action= resolve(ReserveSlotAction::class);
        $controller->__invoke($slot, $action);
        $this->assertDatabaseHas('reservations', ['id' => 1, 'client_id' => $client1->id, 'slot_id' => $slot->id]);
        $this->assertDatabaseCount('reservations', 1);
        $this->assertDatabaseHas('slots', ['id' => $slot->id, 'is_reserved'=>true]);
        $this->assertDatabaseHas('slots', ['id' => $slot2->id, 'is_reserved'=>false]);
    }
}
