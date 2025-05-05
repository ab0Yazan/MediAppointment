<?php

namespace Modules\Shared\src\Contracts;

interface MessageQueueInterface
{
    public function publish(string $message, string $queue) : void;
    public function consume(string $queue, callable $callback) : void;
    public function __destruct();
}
