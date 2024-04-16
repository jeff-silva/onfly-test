<?php

namespace App\Repositories;

use App\Models\AppUser;
use Illuminate\Http\Request;
use App\Contracts\AppUserRepositoryInterface;

class AppUserRepository implements AppUserRepositoryInterface
{
    public function __construct(private AppUser $model)
    {
    }

    protected function dataArray($data)
    {
        return $data instanceof Request ? $data->all() : $data;
    }

    public function index($data)
    {
        $data = $this->dataArray($data);
        return $this->model->searchPaginated($data);
    }

    public function store($data)
    {
        $data = $this->dataArray($data);
        return $this->model->create($data);
    }

    public function show($id)
    {
        return $this->model->find($id);
    }

    public function update($data, $id)
    {
        $data = $this->dataArray($data);
        if ($model = $this->show($id)) $model->update($data);
        return $model;
    }

    public function destroy($id)
    {
        if ($model = $this->show($id)) $model->delete();
        return $model;
    }
}
