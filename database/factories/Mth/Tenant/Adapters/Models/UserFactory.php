<?php

namespace Database\Factories\Mth\Tenant\Adapters\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mth\Tenant\Adapters\Models\User;
use Mth\Tenant\Core\Constants\ColumnNames\UserColumns;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            UserColumns::NAME           => fake()->name(),
            UserColumns::EMAIL          => fake()->unique()->safeEmail(),
            UserColumns::PASSWORD       => Hash::make('password'),
            UserColumns::REMEMBER_TOKEN => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            UserColumns::EMAIL_VERIFIED_AT => null,
        ]);
    }

    public function withPassword(string $password): static
    {
        return $this->state(fn (array $attributes) => [
            UserColumns::PASSWORD => Hash::make($password),
        ]);
    }

    public function withEmail(string $email): static
    {
        return $this->state(fn (array $attributes) => [
            UserColumns::EMAIL => $email,
        ]);
    }
}
