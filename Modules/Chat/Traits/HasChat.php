<?php

namespace Modules\Chat\Traits;

use Modules\Chat\Models\Conversation;
use Modules\Chat\Models\Message;

trait HasChat
{
    public function conversationsInitiated()
    {
        return $this->morphMany(Conversation::class, 'initiator');
    }

    public function conversations()
    {
        return $this->morphToMany(Conversation::class, 'participable', 'participants');
    }

    public function messages()
    {
        return $this->morphMany(Message::class, 'sender');
    }
}
