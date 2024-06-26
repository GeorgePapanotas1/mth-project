<?php

declare(strict_types=1);

namespace Mth\Common\Core\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ICrudService
{
    public function find(string $id): ?Model;

    public function findBy(array $criteria, array $columns = ['*']): ?Model;

    public function findAll(array $criteria = []): Collection;

    public function findWhereIn(string $column, array $values, array $columns = ['*']): Collection;

    public function findWhereNotIn(string $column, array $values, array $columns = ['*']): Collection;

    public function create(array $attributes): Model;

    public function update(string $id, array $attributes): ?Model;

    public function delete(string $id): bool;

    public function all(array $columns = ['*']): Collection;

    public function paginate(int $perPage = 15, array $columns = ['*'], int $page = 1): LengthAwarePaginator;

    public function bulkCreate(array $attributes): Collection;

    public function bulkUpdate(array $criteria, array $attributes): bool;

    public function bulkDelete(array $criteria): bool;
}
