<?php

namespace Database\Factories\Mth\Tenant\Adapters\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Mth\Tenant\Adapters\Models\Company;
use Mth\Tenant\Adapters\Models\User;
use Mth\Tenant\Adapters\Models\UsersCompanies;
use Mth\Tenant\Core\Constants\ColumnNames\UsersCompaniesColumns;

/**
 * @extends Factory<UsersCompanies>
 */
class UsersCompaniesFactory extends Factory
{
    protected $model = UsersCompanies::class;

    public function definition(): array
    {
        return [
            UsersCompaniesColumns::COMPANY_ID => Company::factory(),
            UsersCompaniesColumns::USER_ID    => User::factory(),
        ];
    }
}
