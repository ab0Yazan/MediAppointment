<?php

namespace Modules\Appointment\app\Repositories;

use Modules\Appointment\app\Repositories\Contracts\ReservationRepositoryInterface;
use Illuminate\Contracts\Cache\Repository as CacheRepository;

class ReservationCacheRepository implements ReservationRepositoryInterface
{

    protected ReservationRepositoryInterface $repository;
    protected CacheRepository $cache;
    protected string $cacheKey = 'repo:reservations';
    protected int $cacheExpiration = 60;

    public function __construct(ReservationRepositoryInterface $repository, CacheRepository $cache)
    {
        $this->repository = $repository;
        $this->cache = $cache;
    }

    public function all(array $columns = ['*'])
    {
        // TODO: Implement all() method.
    }

    public function find($id, array $columns = ['*'])
    {
        // TODO: Implement find() method.
    }

    public function findBy(array $criteria, array $columns = ['*'])
    {
        // TODO: Implement findBy() method.
    }

    public function findOneBy(array $criteria, array $columns = ['*'])
    {
        // TODO: Implement findOneBy() method.
    }

    public function create(array $data)
    {
        $reservation= $this->repository->create($data);
        $this->cache->tags([$this->cacheKey])->flush();
        return $reservation;
    }

    public function update($id, array $data)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    public function paginate($perPage = 15, array $columns = ['*'])
    {
        // TODO: Implement paginate() method.
    }

    public function bulkInsert(array $data)
    {
        // TODO: Implement bulkInsert() method.
    }

    public function getModel()
    {
        // TODO: Implement getModel() method.
    }

    public function findWithLoad($id, array $with, array $columns = ['*'])
    {
        return $this->cache->tags([$this->cacheKey])->remember(
            "{$this->cacheKey}:{$id}:findWithLoad",
            $this->cacheExpiration,
            function () use ($id, $with) {
                return $this->repository->findWithLoad($id, $with);
            }
        );
    }
}
