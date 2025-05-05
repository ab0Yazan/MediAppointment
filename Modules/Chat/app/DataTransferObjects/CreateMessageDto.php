<?php

namespace Modules\Chat\app\DataTransferObjects;

use Illuminate\Contracts\Auth\Authenticatable;

class CreateMessageDto
{
    public ?int $conversationId;
    public string $content;
    public string $senderId;
    public string $senderType;
    public Authenticatable $to;

    public function __construct(string $content, string $senderId, string $senderType, ?int $conversationId=null, ?Authenticatable $to=null)
    {
        $this->conversationId = $conversationId;
        $this->content = $content;
        $this->senderId = $senderId;
        $this->senderType = $senderType;
        $this->to = $to;
    }

    public static function fromArray(array $data): CreateMessageDto
    {
        return new self($data['content'], $data['sender_id'], $data['sender_type'], $data['conversation_id']??null, $data['to']??null);
    }
}
