<?php

namespace Database\Seeders\Landlord;

use Illuminate\Database\Seeder;
use Mth\Landlord\Core\Dto\Forms\CreateTenantForm;
use Mth\Landlord\Core\Services\TenancyService;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(
        TenancyService $tenancyService
    ): void {

        $newTenancyForm = (new CreateTenantForm())
            ->setName('Tenant A')
            ->setDomain('workspace_a');

        $tenancyService->createTenant($newTenancyForm);

        $newTenancyForm = (new CreateTenantForm())
            ->setName('Tenant B')
            ->setDomain('workspace_b');

        $tenancyService->createTenant($newTenancyForm);
    }
}
