<?php

namespace Database\Factories\Mth\Tenant\Adapters\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Mth\Tenant\Adapters\Models\Company;
use Mth\Tenant\Core\Constants\ColumnNames\CompanyColumns;

/**
 * @extends Factory<Company>
 */
class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition(): array
    {
        return [
            CompanyColumns::NAME    => $this->faker->company,
            CompanyColumns::ADDRESS => $this->faker->address,
        ];
    }
}
