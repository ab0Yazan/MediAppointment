<?php

namespace Modules\Appointment\app\DataTransferObjects;

use Modules\Appointment\app\Enums\ReservationStatus;

final readonly class ReservationDto
{
    private ReservationStatus $status;
    private int $reservationId;
    private int $clientId;
    private int $slotId;

    private string $clientName;
    private string $doctorName;

    public function __construct(int $reservationId, int $clientId, int $slotId, ReservationStatus $status, string $clientName, string $doctorName)
    {
        $this->slotId = $slotId;
        $this->clientId = $clientId;
        $this->reservationId = $reservationId;
        $this->status = $status;
        $this->clientName = $clientName;
        $this->doctorName = $doctorName;
    }

    public function getStatus(): ReservationStatus
    {
        return $this->status;
    }

    public function getReservationId(): int
    {
        return $this->reservationId;
    }

    public function getClientId(): int
    {
        return $this->clientId;
    }

    public function getSlotId(): int
    {
        return $this->slotId;
    }

    public static function fromArray(array $data): self
    {
        return new self($data["reservationId"], $data["clientId"], $data["slotId"], $data["status"], $data["clientName"], $data["doctorName"]);
    }

    public function getDoctorName(): string
    {
        return $this->doctorName;
    }

    public function getClientName(): string
    {
        return $this->clientName;
    }

}
