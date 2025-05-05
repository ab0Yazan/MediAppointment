<?php

namespace Modules\Chat\app\Repositories;

use Modules\Chat\app\Repositories\Contracts\MessageRepositoryInterface;
use Illuminate\Contracts\Cache\Repository as CacheRepository;


class MessageCacheRepository implements MessageRepositoryInterface
{
    protected MessageRepositoryInterface $repository;
    protected CacheRepository $cache;
    protected string $cacheKey = 'repo:messages';
    protected int $cacheExpiration = 60;

    public function __construct(MessageRepositoryInterface $repository, CacheRepository $cache)
    {
        $this->repository = $repository;
        $this->cache = $cache;
    }


    public function create(array $data)
    {
        return $this->repository->create($data);
    }
}
