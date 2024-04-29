<?php

namespace Database\Factories\Mth\Tenant\Adapters\Models;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Mth\Tenant\Adapters\Models\Company;
use Mth\Tenant\Adapters\Models\User;
use Mth\Tenant\Adapters\Models\UsersCompanies;

/**
 * @extends Factory<UsersCompanies>
 */
class UsersCompaniesFactory extends Factory
{
    protected $model = UsersCompanies::class;
    public function definition(): array
    {
        return [
            'company_id' => Company::factory(),
            'user_id' => User::factory(),
        ];
    }
}
