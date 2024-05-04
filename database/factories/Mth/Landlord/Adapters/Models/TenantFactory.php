<?php

namespace Database\Factories\Mth\Landlord\Adapters\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Mth\Landlord\Adapters\Models\Tenant;

class TenantFactory extends Factory
{

    protected $model = Tenant::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'domain' => $this->faker->unique()->lexify('??????'),
            'database' => 'tenant_' . $this->faker->unique()->lexify('??????'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Set a specific name for the tenant.
     *
     * @param string $name
     * @return TenantFactory
     */
    public function name(string $name): self
    {
        return $this->state(function (array $attributes) use ($name) {
            return ['name' => $name];
        });
    }

    /**
     * Set a specific domain for the tenant.
     *
     * @param string $domain
     * @return TenantFactory
     */
    public function domain(string $domain): self
    {
        return $this->state(function (array $attributes) use ($domain) {
            return ['domain' => $domain];
        });
    }

    /**
     * Set a specific database name for the tenant.
     *
     * @param string $database
     * @return TenantFactory
     */
    public function database(string $database): self
    {
        return $this->state(function (array $attributes) use ($database) {
            return ['database' => $database];
        });
    }
}
