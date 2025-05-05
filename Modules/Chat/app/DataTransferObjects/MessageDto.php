<?php

namespace Modules\Chat\app\DataTransferObjects;

use Modules\Chat\Models\Message;

class MessageDto
{
    public int $messageId;
    public int $conversationId;
    public int $senderId;
    public string $senderType;
    public string $content;

    public function __construct(int $messageId, int $conversationId, int $senderId, string $senderType, string $content)
    {
        $this->messageId = $messageId;
        $this->conversationId = $conversationId;
        $this->senderId = $senderId;
        $this->senderType = $senderType;
        $this->content = $content;
    }

    public static function fromModel(Message $message)
    {
        return new self($message->id, $message->conversation_id, $message->sender_id, $message->sender_type, $message->content);
    }

}
