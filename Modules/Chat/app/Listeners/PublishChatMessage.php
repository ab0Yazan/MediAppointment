<?php

namespace Modules\Chat\Listeners;

use Modules\Chat\Events\MessageCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Shared\src\RabbitMQService;

class PublishChatMessage
{
    public function __construct() {}

    public function handle(MessageCreated $event): void {
        $rmqs= resolve(RabbitMQService::class);
        $rmqs->publish(json_encode($event), 'real_time');
    }
}
