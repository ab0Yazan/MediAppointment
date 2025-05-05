<?php

namespace Modules\Chat\app\Repositories;

use Modules\Chat\app\Repositories\Contracts\MessageRepositoryInterface;
use Modules\Chat\Models\Message;

class MessageEloquentRepository implements MessageRepositoryInterface
{
    protected Message $model;
    public function __construct(Message $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }
}
