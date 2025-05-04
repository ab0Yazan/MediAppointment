<?php

namespace Modules\Appointment\app\Repositories;

use Illuminate\Database\Eloquent\Model;
use Modules\Appointment\app\Repositories\Contracts\ReservationRepositoryInterface;

class ReservationEloquentRepository implements ReservationRepositoryInterface
{
    private Model $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
    public function all(array $columns = ['*'])
    {
        // TODO: Implement all() method.
    }

    public function find($id, array $columns = ['*'])
    {
        // TODO: Implement find() method.
    }

    public function findWithLoad($id, array $with, array $columns = ['*'])
    {
        return $this->model->with($with)->find($id);
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
        return $this->model->create($data);
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
}
