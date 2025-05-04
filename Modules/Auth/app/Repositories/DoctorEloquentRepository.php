<?php

namespace Modules\Auth\app\Repositories;

use Modules\Auth\app\Repositories\Contracts\DoctorRepositoryInterface;
use Modules\Auth\app\Models\Doctor;

final class DoctorEloquentRepository implements DoctorRepositoryInterface
{
    private Doctor $model;

    public function __construct(Doctor $model)
    {
        $this->model = $model;
    }

    public function all(array $columns = ['*'])
    {
        return $this->model->all();
    }

    public function find($id, array $columns = ['*'])
    {
        return $this->model->find($id, $columns);
    }

    public function findBy(array $criteria, array $columns = ['*'], $with=[])
    {

        return $this->model->where($criteria)->when($with, function ($query) use ($with){
            $query->with($with);
        })->select($columns)->get();
    }

    public function findOneBy(array $criteria, array $columns = ['*'])
    {
        // TODO: Implement findOneBy() method.
    }

    public function create(array $data)
    {
        // TODO: Implement create() method.
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

    public function getModel()
    {
        // TODO: Implement getModel() method.
    }

    public function bulkInsert(array $data)
    {
        return $this->model->insert($data);
    }
}
