<?php

namespace Database\Factories\Mth\Tenant\Adapters\Models;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Mth\Tenant\Adapters\Models\Project;
use Mth\Tenant\Adapters\Models\UsersCompanies;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'user_company_id' => UsersCompanies::factory(),
        ];
    }
}
