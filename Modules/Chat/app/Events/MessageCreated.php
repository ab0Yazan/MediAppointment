<?php

namespace Modules\Chat\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Chat\app\DataTransferObjects\MessageDto;

class MessageCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public MessageDto $messageDto;
    public function __construct(MessageDto $messageDto) {
        $this->messageDto = $messageDto;
    }
}
