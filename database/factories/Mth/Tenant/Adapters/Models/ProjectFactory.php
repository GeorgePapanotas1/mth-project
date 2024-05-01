<?php

namespace Database\Factories\Mth\Tenant\Adapters\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Mth\Tenant\Adapters\Models\Company;
use Mth\Tenant\Adapters\Models\Project;
use Mth\Tenant\Adapters\Models\User;
use Mth\Tenant\Core\Constants\ColumnNames\ProjectColumns;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            ProjectColumns::NAME        => $this->faker->word,
            ProjectColumns::DESCRIPTION => $this->faker->paragraph,
            ProjectColumns::CREATOR_ID  => User::factory(),
            ProjectColumns::COMPANY_ID  => Company::factory(),
        ];
    }

    public function ofCreator(string $creatorId): self
    {
        return $this->state(function (array $attributes) use ($creatorId) {
            return [ProjectColumns::CREATOR_ID => $creatorId];
        });
    }

    public function ofCompany(string $companyId): self
    {
        return $this->state(function (array $attributes) use ($companyId) {
            return [ProjectColumns::COMPANY_ID => $companyId];
        });
    }
}
