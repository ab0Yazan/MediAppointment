<?php

namespace Modules\Notification\Console;

use Illuminate\Console\Command;
use Modules\Notification\Events\ChatMessageSent;
use Modules\Shared\src\Contracts\MessageQueueInterface;

final class ConsumeNotificationCommand extends Command
{
    protected $signature = 'rabbitmq:consume-notification';

    protected $description = 'Consume notifications from RabbitMQ';

    private MessageQueueInterface $rbmq;

    public function __construct(MessageQueueInterface $rbmq)
    {
        $this->rbmq = $rbmq;
        parent::__construct();
    }


    public function handle()
    {
        $this->info('listening........');
        $this->rbmq->consume('real_time', function ($msg) {
            $data = json_decode($msg->body, true);

            switch ($data['event']) {
                case 'MessageCreated':
                    broadcast(new ChatMessageSent($data));
                    break;
                default:
                    throw new \Exception('Unexpected event');
            }
            $this->info("Processed");
        });

    }
}
