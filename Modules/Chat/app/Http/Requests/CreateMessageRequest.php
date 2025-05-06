<?php

namespace Modules\Chat\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Auth\app\Models\Doctor;
use Modules\Auth\Models\Client;
use Modules\Chat\app\DataTransferObjects\CreateMessageDto;

class CreateMessageRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'content' => 'required|string',
            'receiver_id' => 'required',
            'receiver_type' => 'required',
            'conversation_id' => 'nullable|numeric',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function getDto(): CreateMessageDto
    {
        $receiver= $this->receiver_type == "client"? Client::find($this->receiver_id): Doctor::find($this->receiver_id);
        return new CreateMessageDto(
            $this->content,
            auth()->user()->id,
            get_class(auth()->user()),
            $this->conversation_id>>null,
            $receiver,
        );
    }
}
