<?php

namespace Modules\Appointment\app\Repositories;

use Modules\Appointment\app\Repositories\Contracts\RepositoryInterface;
use Illuminate\Contracts\Cache\Repository as CacheRepository;


/**
 * @template T of RepositoryInterface
 * @implements T
 */
final class CachingRepository implements RepositoryInterface
{
    /** @var T */
    private $repository;
    private CacheRepository $cache;
    private int $cacheTime;

    /**
     * @param T $repository
     */
    public function __construct($repository, CacheRepository $cache, int $cacheTime = 60)
    {
        $this->repository = $repository;
        $this->cache = $cache;
        $this->cacheTime = $cacheTime;
    }

    public function all(array $columns = ['*'])
    {
        $key = $this->getCacheKey('all', $columns);

        return $this->cache->remember($key, $this->cacheTime, function () use ($columns) {
            return $this->repository->all($columns);
        });
    }

    public function find($id, array $columns = ['*'])
    {
        $key = $this->getCacheKey('find', $id, $columns);

        return $this->cache->remember($key, $this->cacheTime, function () use ($id, $columns) {
            return $this->repository->find($id, $columns);
        });
    }

    public function findBy(array $criteria, array $columns = ['*'])
    {
        $key = $this->getCacheKey('findBy', $criteria, $columns);

        return $this->cache->remember($key, $this->cacheTime, function () use ($criteria, $columns) {
            return $this->repository->findBy($criteria, $columns);
        });
    }

    public function findOneBy(array $criteria, array $columns = ['*'])
    {
        $key = $this->getCacheKey('findOneBy', $criteria, $columns);

        return $this->cache->remember($key, $this->cacheTime, function () use ($criteria, $columns) {
            return $this->repository->findOneBy($criteria, $columns);
        });
    }

    public function create(array $data)
    {
        $result = $this->repository->create($data);
        $this->flushModelCache();
        return $result;
    }

    public function update($id, array $data)
    {
        $result = $this->repository->update($id, $data);
        $this->flushModelCache();
        $this->flushItemCache($id);
        return $result;
    }

    public function delete($id)
    {
        $result = $this->repository->delete($id);
        $this->flushModelCache();
        $this->flushItemCache($id);
        return $result;
    }

    public function paginate($perPage = 15, array $columns = ['*'])
    {
        $key = $this->getCacheKey('paginate', $perPage, $columns);

        return $this->cache->remember($key, $this->cacheTime, function () use ($perPage, $columns) {
            return $this->repository->paginate($perPage, $columns);
        });
    }

    private function getCacheKey(): string
    {
        $prefix = $this->getModelCachePrefix();
        $args = func_get_args();
        $method = array_shift($args);

        return sprintf('%s:%s:%s',
            $prefix,
            $method,
            md5(json_encode($args))
        );
    }

    private function getModelCachePrefix(): string
    {
        return strtolower(class_basename($this->repository->getModel()));
    }

    private function flushModelCache(): void
    {
        if (method_exists($this->cache, 'tags')) {
            $this->cache->tags($this->getModelCachePrefix())->flush();
        }
    }

    private function flushItemCache($id): void
    {
        $key = $this->getCacheKey('item', $id);
        $this->cache->forget($key);
    }

    public function getModel()
    {
        return $this->repository->getModel();
    }

    public function __call($method, $parameters)
    {
        if (!method_exists($this->repository, $method)) {
            throw new \BadMethodCallException(sprintf(
                'Method %s::%s does not exist',
                get_class($this->repository),
                $method
            ));
        }

        $key = $this->getCacheKey($method, $parameters);

        return $this->cache->remember($key, $this->cacheTime, function() use ($method, $parameters) {
            return $this->repository->$method(...$parameters);
        });
    }
}
