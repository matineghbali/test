<?php

namespace App\Repositories;

use App\Models\Property;

abstract class Repository
{
    protected $model;

    public function __construct()
    {
        $this->model = app($this->model());
    }

    abstract public function model();

    public function all()
    {
        return $this->model->orderBy('id', 'desc')->get();
    }

    public function paginate($limit = 15)
    {
        return $this->model->orderBy('id', 'desc')->paginate($limit);
    }

    public function getBy($col, $value, $limit = 15)
    {
        return $this->model->where($col, $value)->limit($limit)->get();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function update($model, array $data)
    {
        return $model->update($data);
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function exists($id)
    {
        return $this->model->where('id', $id)->exists();
    }

    public function findWith($id,$rel_model){
        return $this->model->with($rel_model)->find($id);
    }

    public function allWith($rel_model)
    {
        return $this->model->with($rel_model)->get();
    }
}
