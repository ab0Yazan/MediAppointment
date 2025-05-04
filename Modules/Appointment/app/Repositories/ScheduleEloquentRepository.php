<?php

namespace Modules\Appointment\app\Repositories;

use Modules\Appointment\app\Models\DoctorSchedule;
use Modules\Appointment\app\Repositories\Contracts\ScheduleRepositoryInterface;

class ScheduleEloquentRepository implements ScheduleRepositoryInterface
{

    private DoctorSchedule $model;

    public function __construct(DoctorSchedule $model)
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

    public function findBy(array $criteria, array $columns = ['*'])
    {
        return $this->model->where($criteria)->select($columns);
    }

    public function findOneBy(array $criteria, array $columns = ['*'])
    {
        return $this->model->where($criteria)->select($columns)->first();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        return $this->model->update($id, $data);
    }

    public function delete($id)
    {
        $this->model->where('id', $id)->delete();
    }

    public function paginate($perPage = 15, array $columns = ['*'])
    {
        return $this->model->select($columns)->paginate($perPage);
    }

    public function bulkInsert(array $data)
    {
        return $this->model->insert($data);
    }

    public function getModel()
    {
        return $this->model;
    }
}
