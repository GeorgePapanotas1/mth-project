<?php

namespace Database\Factories\Mth\Tenant\Adapters\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Mth\Tenant\Adapters\Models\Role;
use Mth\Tenant\Core\Constants\ColumnNames\RoleColumns;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition(): array
    {
        return [
            RoleColumns::NAME       => fake()->title,
            RoleColumns::GUARD_NAME => fake()->title
        ];
    }
}
