<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    protected string $model;

    public function getPage(
        int $page = 1,
        int $perPage = 10,
        string $orderBy = 'created_at',
        string $order = 'DESC',
        array $filters = [],
        array $relationships = []
    ): LengthAwarePaginator
    {
        $q = $this->model::query();

        foreach ($filters as $field => $values) {
            $q->whereIn($field, $values);
        }

        $q->orderBy($orderBy, $order);

        if ($relationships) {
            $q->with($relationships);
        }

        return $q->paginate($perPage, ['*'], 'page', $page);
    }

    public function getAll(array $filters = [], array $relationships = []): Collection
    {
        $q = $this->model::query();

        foreach ($filters as $field => $values) {
            $q->whereIn($field, $values);
        }

        if ($relationships) {
            $q->with($relationships);
        }

        return $q->get();
    }

    public function getById(int $id): Model
    {
        return $this->model::findOrFail($id);
    }

    public function create(array $data): Model
    {
        return $this->model::create($data);
    }

    public function update(int $id, array $data): void
    {
        $model = $this->getById($id);

        $model->update($data);
    }

    public function delete(int $id): void
    {
        $model = $this->getById($id);

        $model->delete();
    }

    public function deleteAll(array $ids): int
    {
        return $this->model::destroy($ids);
    }
}