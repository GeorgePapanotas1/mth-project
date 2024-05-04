<?php

namespace Database\Seeders;

use Database\Seeders\Landlord\SuperuserSeeder;
use Database\Seeders\Landlord\TenantSeeder;
use Database\Seeders\Tenant\CompanySeeder;
use Database\Seeders\Tenant\ProjectSeeder;
use Database\Seeders\Tenant\UserSeeder;
use Illuminate\Database\Seeder;
use Mth\Landlord\Adapters\Models\Tenant;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(SuperuserSeeder::class);
        $this->call(TenantSeeder::class);

        Tenant::all()->each(function ($tenant) {
            $tenant->makeCurrent();
            sleep(1);
            $tenant->execute(function () {
                $this->call([
                    CompanySeeder::class,
                    UserSeeder::class,
                    ProjectSeeder::class,
                ]);
            });
            $tenant->forgetCurrent();
        });
    }
}
