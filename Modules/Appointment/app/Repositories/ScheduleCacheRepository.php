<?php

namespace Modules\Appointment\app\Repositories;

use Modules\Appointment\app\Repositories\Contracts\ScheduleRepositoryInterface;
use Illuminate\Contracts\Cache\Repository as CacheRepository;

class ScheduleCacheRepository implements ScheduleRepositoryInterface
{
    protected ScheduleRepositoryInterface $repository;
    protected CacheRepository $cache;
    protected string $cacheKey = 'repo:schedules';
    protected int $cacheExpiration = 60;

    public function __construct(ScheduleRepositoryInterface $repository, CacheRepository $cache)
    {
        $this->repository = $repository;
        $this->cache = $cache;
    }


    public function all(array $columns = ['*'])
    {
        return $this->cache->tags([$this->cacheKey])->remember(
            "{$this->cacheKey}:all",
            $this->cacheExpiration,
            function () {
                return $this->repository->all();
            }
        );
    }

    public function find($id, array $columns = ['*'])
    {
        return $this->cache->tags([$this->cacheKey])->remember(
            "{$this->cacheKey}:{$id}",
            $this->cacheExpiration,
            function () use ($id) {
                return $this->repository->find($id);
            }
        );
    }

    public function findBy(array $criteria, array $columns = ['*'])
    {
        $str= json_encode($criteria) . ':' . json_encode($columns);
        return $this->cache->tags([$this->cacheKey])->remember(
            "{$this->cacheKey}:filter:{$str}",
            $this->cacheExpiration,
            function () use ($criteria, $columns) {
                return $this->repository->findBy($criteria, $columns);
            }
        );
    }

    public function findOneBy(array $criteria, array $columns = ['*'])
    {
        $str= json_encode($criteria) . ':' . json_encode($columns);
        return $this->cache->tags([$this->cacheKey])->remember(
            "{$this->cacheKey}:filter:{$str}",
            $this->cacheExpiration,
            function () use ($criteria, $columns) {
                return $this->repository->findOneBy($criteria, $columns);
            }
        );
    }

    public function create(array $data)
    {
        $slot = $this->repository->create($data);
        $this->cache->tags([$this->cacheKey])->flush();
        return $slot;
    }

    public function update($id, array $data)
    {
        $result = $this->repository->update($id, $data);
        $this->cache->tags([$this->cacheKey])->flush();
        return $result;
    }

    public function delete($id)
    {
        $result = $this->repository->delete($id);
        $this->cache->tags([$this->cacheKey])->flush();
        return $result;
    }

    public function paginate($perPage = 15, array $columns = ['*'])
    {
        $cacheKey = "{$this->cacheKey}:paginate:{$perPage}";
        return $this->cache->tags([$this->cacheKey])->remember(
            $cacheKey,
            $this->cacheExpiration,
            function () use ($perPage, $columns) {
                return $this->repository->paginate($perPage, $columns);
            }
        );
    }

    public function bulkInsert(array $data)
    {
        return $this->repository->bulkInsert($data);
    }

    public function getModel()
    {
        return $this->repository->getModel();
    }
}
