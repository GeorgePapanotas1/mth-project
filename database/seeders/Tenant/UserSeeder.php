<?php

namespace Database\Seeders\Tenant;

use Illuminate\Database\Seeder;
use Mth\Tenant\Adapters\Models\Company;
use Mth\Tenant\Adapters\Models\User;
use Mth\Tenant\Core\Constants\ColumnNames\UserColumns;
use Mth\Tenant\Core\Constants\Enums\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admins, moderators, and regular users
        $admin = User::create([
            UserColumns::NAME     => 'Admin',
            UserColumns::EMAIL    => 'admin@example.com',
            UserColumns::PASSWORD => bcrypt('password')
        ]);
        $admin->assignRole(Role::ADMIN);

        $moderator = User::create([
            UserColumns::NAME     => 'Moderator',
            UserColumns::EMAIL    => 'moderator@example.com',
            UserColumns::PASSWORD => bcrypt('password')
        ]);
        $moderator->assignRole(Role::MODERATOR);

        User::factory(3)->create();
        User::factory()->withEmail('user@example.com')->withPassword('password')->create();

        // Assign companies to each user
        $companies = Company::all();
        $allUsers  = User::all();
        foreach ($allUsers as $user) {
            $assignedCompanies = $companies->random(rand(1, $companies->count()));
            $user->companies()->attach($assignedCompanies);
        }
    }
}
