<?php

namespace Modules\Shared\src;

use Exception;
use Modules\Shared\src\Contracts\MessageQueueInterface;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQService implements MessageQueueInterface
{
    protected AMQPStreamConnection $connection;
    protected AMQPChannel $channel;

    public function __construct(AMQPStreamConnection $connection)
    {
        $this->connection = $connection;
        $this->channel = $this->connection->channel();
    }

    public function publish($message, $queue): void
    {
        $this->channel->queue_declare($queue, false, true, false, false);

        $msg = new AMQPMessage($message);

        $this->channel->basic_publish($msg, '', $queue);
    }

    public function consume($queue, $callback): void
    {
        $this->channel->queue_declare($queue, false, true, false, false);
        $this->channel->basic_consume($queue, '', false, true, false, false, $callback);

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }

    public function isConsuming(): bool
    {
        return $this->channel->is_consuming();
    }

    public function wait(): void
    {
        $this->channel->wait();
    }

    /**
     * @throws Exception
     */
    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
