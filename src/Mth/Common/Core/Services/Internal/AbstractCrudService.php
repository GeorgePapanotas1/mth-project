<?php

namespace Mth\Common\Core\Services\Internal;

use Mth\Common\Core\Contracts\ICrudRepository;
use Mth\Common\Core\Contracts\ICrudService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class AbstractCrudService implements ICrudService
{
    abstract protected function repository(): ICrudRepository;

    public function find(string $id): ?Model
    {
        return $this->repository()->find($id);
    }

    public function findBy(array $criteria, array $columns = ['*']): ?Model
    {
        return $this->repository()->findBy($criteria, $columns);
    }

    public function findAll(array $criteria = []): Collection
    {
        return $this->repository()->findAll($criteria);
    }

    public function findWhereIn(string $column, array $values, array $columns = ['*']): Collection
    {
        return $this->repository()->findWhereIn($column, $values, $columns);
    }

    public function findWhereNotIn(string $column, array $values, array $columns = ['*']): Collection
    {
        return $this->repository()->findWhereNotIn($column, $values, $columns);
    }

    public function create(array $attributes): Model
    {
        return $this->repository()->create($attributes);
    }

    public function update(string $id, array $attributes): ?Model
    {
        $model = $this->repository()->find($id);
        if ($model) {
            return $this->repository()->update($model, $attributes);
        }

        return null;
    }

    public function delete(string $id): bool
    {
        $model = $this->repository()->find($id);
        if ($model) {
            return $this->repository()->delete($model);
        }

        return false;
    }

    public function all(array $columns = ['*']): Collection
    {
        return $this->repository()->all($columns);
    }

    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null, $total = null): LengthAwarePaginator
    {

        return $this->repository()->paginate($perPage, $columns, $pageName, $page, $total);
    }

    public function bulkCreate(array $attributes): Collection
    {
        return $this->repository()->bulkCreate($attributes);
    }

    public function bulkUpdate(array $criteria, array $attributes): bool
    {
        return $this->repository()->bulkUpdate($criteria, $attributes);
    }

    public function bulkDelete(array $criteria): bool
    {
        return $this->repository()->bulkDelete($criteria);
    }
}
