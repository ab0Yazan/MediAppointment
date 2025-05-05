<?php

namespace Modules\Chat\app\Repositories;

use Modules\Chat\app\Repositories\Contracts\ConversationRepositoryInterface;
use Illuminate\Contracts\Cache\Repository as CacheRepository;


class ConversationCacheRepository implements ConversationRepositoryInterface
{
    protected ConversationRepositoryInterface $repository;
    protected CacheRepository $cache;
    protected string $cacheKey = 'repo:conversations';
    protected int $cacheExpiration = 60;

    public function __construct(ConversationRepositoryInterface $repository, CacheRepository $cache)
    {
        $this->repository = $repository;
        $this->cache = $cache;
    }


    public function create(array $data)
    {
        return $this->repository->create($data);
    }
}
