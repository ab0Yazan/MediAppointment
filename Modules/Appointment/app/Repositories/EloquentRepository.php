<?php

namespace Modules\Appointment\app\Repositories;

use Illuminate\Database\Eloquent\Model;
use Modules\Appointment\app\Repositories\Contracts\RepositoryInterface;

abstract class EloquentRepository implements RepositoryInterface
{

    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(array $columns = ['*']){
        return $this->model->get($columns);
    }
    public function find($id, array $columns = ['*']){
        return $this->model->findOrFail($id, $columns);
    }
    public function findBy(array $criteria, array $columns = ['*']){

    }
    public function findOneBy(array $criteria, array $columns = ['*']){

    }
    public function create(array $data){

    }
    public function update($id, array $data){

    }
    public function delete($id){

    }
    public function paginate($perPage = 15, array $columns = ['*']){

    }


    public function getModel(): Model
    {
       return $this->model;
    }
}
