<?php

namespace Modules\Appointment\app\Repositories;

use Illuminate\Database\Eloquent\Model;
use Modules\Appointment\app\Models\Slot;
use Modules\Appointment\app\Repositories\Contracts\SlotRepositoryInterface;

final class SlotEloquentRepository implements SlotRepositoryInterface
{
    private Model $model;

    public function __construct(Slot $model)
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

    public function getAvailableSlotsByDoctor(int $doctorId)
    {
        return $this->model->join('doctor_schedules', 'doctor_schedules.id', '=', 'slots.doctor_schedule_id')
            ->where("doctor_schedules.doctor_id", $doctorId)
            ->whereDate("slots.date", ">=", now())
            ->select("slots.start_time", "slots.end_time", "slots.date", "slots.id")
            ->get();
    }


    public function findWithLock(int $id)
    {
        return $this->model->lockForUpdate($id);
    }

public function isReserved(int $id):bool
    {
        return $this->find($id)->isReserved();
    }
}
