<?php

namespace Modules\Auth\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Auth\app\Models\Doctor;

class DoctorCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(protected int $doctorId) {}

    public function getDoctorId(): int
    {
        return $this->doctorId;
    }

    public  function getDoctor(): Doctor
    {
        return  Doctor::findorFail($this->doctorId);
    }
}
