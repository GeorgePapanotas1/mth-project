<?php

namespace Database\Seeders\Tenant;

use Illuminate\Database\Seeder;
use Mth\Tenant\Adapters\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::factory(10)->create();
    }
}
