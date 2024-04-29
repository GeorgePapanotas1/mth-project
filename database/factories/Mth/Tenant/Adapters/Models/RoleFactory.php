<?php

namespace Database\Factories\Mth\Tenant\Adapters\Models;
use Illuminate\Database\Eloquent\Factories\Factory;
use Mth\Tenant\Adapters\Models\Role;

class RoleFactory extends Factory
{
    protected $model = Role::class;
    public function definition(): array
    {
        return [
            'name' => 'Admin',
            'guard_name' => 'Admin'
        ];
    }
}
