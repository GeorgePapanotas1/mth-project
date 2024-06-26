<?php

namespace Mth\Common\Core\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ICrudRepository
{
    public function find(string $id): ?Model;

    public function findBy(array $criteria, array $columns = ['*']): ?Model;

    public function findAll(array $criteria = []): Collection;

    public function findWhereIn(string $column, array $values, array $columns = ['*']): Collection;

    public function findWhereNotIn(string $column, array $values, array $columns = ['*']): Collection;

    public function create(array $attributes): Model;

    public function update(Model $model, array $attributes): Model;

    public function delete(Model $model): bool;

    public function all(array $columns = ['*']): Collection;

    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null, $total = null): LengthAwarePaginator;

    public function bulkCreate(array $attributes): Collection;

    public function bulkUpdate(array $criteria, array $attributes): bool;

    public function bulkDelete(array $criteria): bool;
}
