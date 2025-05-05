<?php

namespace Modules\Chat\app\Repositories;

use Modules\Chat\app\Repositories\Contracts\ConversationRepositoryInterface;
use Modules\Chat\Models\Conversation;

class ConversationEloquentRepository implements ConversationRepositoryInterface
{
    protected Conversation $model;
    public function __construct(Conversation $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }
}
