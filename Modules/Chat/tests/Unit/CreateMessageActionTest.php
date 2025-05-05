<?php

namespace Modules\Chat\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Modules\Chat\app\Actions\CreateMessageAction;
use Modules\Chat\app\DataTransferObjects\CreateMessageDto;
use Modules\Chat\Events\MessageCreated;
use Tests\TestCase;

class CreateMessageActionTest extends TestCase
{
    use RefreshDatabase;
    public function test_send_message_action_first_conversation_init(): void
    {
        \Event::fake();

        $doctor = $this->createDoctor();

        $receiver= $this->createClient();

        $sender= Sanctum::actingAs($doctor);

        $dto = CreateMessageDto::fromArray([
            "sender_type" => get_class($sender),
            "sender_id" => $sender->id,
            "content" => "new message",
            "to" => $receiver,
        ]);

        $action = resolve(CreateMessageAction::class);
        $messageDto= $action->execute($dto, $sender, $receiver);

        \Event::assertDispatched(MessageCreated::class);

        $this->assertDatabaseHas('messages', [
            'id' => $messageDto->messageId,
            'content' => "new message",
        ]);

        $this->assertDatabaseCount('conversations', 1);
        $this->assertDatabaseHas('conversations', ['creator_id' => $doctor->id, 'creator_type' => get_class($doctor)]);
        $this->assertDatabaseHas('participants', ['participable_id' => $receiver->id, 'participable_type' => get_class($receiver)]);


    }
}
