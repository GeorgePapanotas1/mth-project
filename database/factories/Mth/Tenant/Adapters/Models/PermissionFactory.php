<?php

namespace Database\Factories\Mth\Tenant\Adapters\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Mth\Tenant\Core\Constants\ColumnNames\PermissionColumns;

class PermissionFactory extends Factory
{
    public function definition(): array
    {
        return [
            PermissionColumns::NAME       => fake()->title,
            PermissionColumns::GUARD_NAME => fake()->title
        ];
    }
}
