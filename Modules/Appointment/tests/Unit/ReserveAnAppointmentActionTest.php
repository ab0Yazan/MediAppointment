<?php

namespace Modules\Appointment\tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Appointment\app\Actions\ReserveSlotAction;
use Modules\Appointment\app\DataTransferObjects\ReservationDto;
use Modules\Appointment\app\Models\Slot;
use Modules\Appointment\Models\Reservation;
use Modules\Auth\Models\Client;
use Spatie\Fork\Fork;
use Tests\TestCase;

class ReserveAnAppointmentActionTest extends TestCase
{
    use RefreshDatabase;
    public function test_it_reserve_an_appointment(): void
    {
        $client= $this->createClient();
        $doctor= $this->createDoctorAndSchedule();
        $slot = Slot::first();
        $action = resolve(ReserveSlotAction::class);
        $reservationDto= $action->execute($slot->id, $client);
        $this->assertInstanceOf(ReservationDto::class, $reservationDto);
        $this->assertTrue($slot->fresh()->isReserved());
    }

//    public function test_concurrent_reservation_should_only_create_one()
//    {
//        $client1 = $this->createClient();
//        $client2 = $this->createClient();
//        $this->createDoctorAndSchedule();
//        $slot = Slot::first();
//
//        $result= Fork::new()
//            ->run(
//                fn () => $this->attemptReservation($slot->id, $client1->id),
//                fn () => $this->attemptReservation($slot->id, $client2->id),
//                fn () => $this->attemptReservation($slot->id, $client2->id),
//                fn () => $this->attemptReservation($slot->id, $client2->id)
//            );
//
//
//        // Only one reservation should exist
//        $this->assertEquals(1, Reservation::count());
//    }
//
//    private function attemptReservation(int $slotId, int $clientId): void
//    {
//        $client = Client::find($clientId);
//        $action = resolve(ReserveSlotAction::class);
//
//        try {
//            $action->execute($slotId, $client);
//        } catch (\Throwable $e) {
//
//        }
//    }


}
