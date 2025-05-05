<?php

namespace Modules\Chat\app\Actions;

use Illuminate\Contracts\Auth\Authenticatable;
use Modules\Chat\app\DataTransferObjects\CreateMessageDto;
use Modules\Chat\app\DataTransferObjects\MessageDto;
use Modules\Chat\app\Repositories\Contracts\ConversationRepositoryInterface;
use Modules\Chat\app\Repositories\Contracts\MessageRepositoryInterface;
use Modules\Chat\Events\MessageCreated;

final class CreateMessageAction
{
    private MessageRepositoryInterface $messageRepo;
    private ConversationRepositoryInterface $conversationRepo;
    public function __construct(MessageRepositoryInterface $messageRepo, ConversationRepositoryInterface $conversationRepo)
    {
        $this->messageRepo = $messageRepo;
        $this->conversationRepo = $conversationRepo;
    }

    public function execute(CreateMessageDto $dto, Authenticatable $sender, Authenticatable $receiver)
    {
        if(!$dto->conversationId)
        {
            $conversation= $this->conversationRepo->create([
                "title" => "privateChat:{$sender->name}",
                "creator_id" => $sender->id,
                "creator_type" => get_class($sender),
                "participant_id" => $dto->to
            ]);

            $conversation->participants()->create([
                "participable_type" => get_class($receiver),
                "participable_id" => $receiver->id
            ]);


            $dto->conversationId = $conversation->id;
        }

        $message= $this->messageRepo->create([
            "conversation_id" => $dto->conversationId,
            "content" => $dto->content,
            "sender_id" => $dto->senderId,
            "sender_type" => $dto->senderType
        ]);

        $messageDto=  MessageDto::fromModel($message);

        event(new MessageCreated($messageDto));

        return $messageDto;
    }
}
