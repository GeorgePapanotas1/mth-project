<?php

namespace Database\Factories\Mth\Tenant\Adapters\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Mth\Tenant\Adapters\Models\Company;
use Mth\Tenant\Adapters\Models\Project;
use Mth\Tenant\Adapters\Models\User;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'name'        => $this->faker->word,
            'description' => $this->faker->paragraph,
            'creator_id'  => User::factory(),
            'company_id'  => Company::factory()
        ];
    }
}
