<?php

namespace Database\Seeders\Tenant;

use Illuminate\Database\Seeder;
use Mth\Tenant\Adapters\Models\Company;
use Mth\Tenant\Adapters\Models\Project;
use Mth\Tenant\Adapters\Models\User;
use Mth\Tenant\Core\Constants\ColumnNames\ProjectColumns;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users     = User::all();
        $companies = Company::all();

        foreach ($users as $user) {
            foreach ($companies as $company) {
                Project::create([
                    ProjectColumns::NAME        => 'Project for ' . $user->name . ' at ' . $company->name,
                    ProjectColumns::DESCRIPTION => 'Project for ' . $user->name . ' at ' . $company->name,
                    ProjectColumns::CREATOR_ID  => $user->id,
                    ProjectColumns::COMPANY_ID  => $company->id,
                ]);
            }
        }
    }
}
