<?php

namespace Database\Seeders\Landlord;

use Illuminate\Database\Seeder;
use Mth\Tenant\Adapters\Models\User;
use Mth\Tenant\Core\Constants\ColumnNames\UserColumns;

class SuperuserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            UserColumns::NAME     => 'Super Admin',
            UserColumns::EMAIL    => 'superadmin@example.com',
            UserColumns::PASSWORD => bcrypt('password')
        ]);
    }
}
