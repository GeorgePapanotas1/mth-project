<?php

namespace Mth\Common\Core\Repositories;

use Mth\Common\Core\Contracts\ICrudRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseCrudRepository implements ICrudRepository
{
    protected Model $model;

    public function __construct()
    {
        $this->model = $this->getModel();
    }

    abstract protected function getModel(): Model;

    public function find(string $id): ?Model
    {
        return $this->model->find($id);
    }

    public function findBy(array $criteria, array $columns = ['*']): ?Model
    {
        return $this->model->where($criteria)->first($columns);
    }

    public function findAll(array $criteria = []): Collection
    {
        return $this->model->where($criteria)->get();
    }

    public function findWhereIn(string $column, array $values, array $columns = ['*']): Collection
    {
        return $this->model->whereIn($column, $values)->get($columns);
    }

    public function findWhereNotIn(string $column, array $values, array $columns = ['*']): Collection
    {
        return $this->model->whereNotIn($column, $values)->get($columns);
    }

    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    public function update(Model $model, array $attributes): Model
    {
        $model->update($attributes);
        return $model;
    }

    public function delete(Model $model): bool
    {
        return $model->delete();
    }

    public function all(array $columns = ['*']): Collection
    {
        return $this->model->all($columns);
    }

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        return $this->model->paginate($perPage, $columns);
    }

    public function bulkCreate(array $attributes): Collection
    {
        return $this->model->insert($attributes);
    }

    public function bulkUpdate(array $criteria, array $attributes): bool
    {
        return $this->model->where($criteria)->update($attributes);
    }

    public function bulkDelete(array $criteria): bool
    {
        return $this->model->where($criteria)->delete();
    }

}
