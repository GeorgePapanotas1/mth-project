<?php

namespace Mth\Landlord\Adapters\Commands;

use Illuminate\Console\Command;
use Mth\Landlord\Core\Dto\Forms\CreateTenantForm;
use Mth\Landlord\Core\Exceptions\Tenancy\GeneralTenantCreationException;
use Mth\Landlord\Core\Services\TenancyService;

class CreateTenant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mth:create-tenant {tenantName} {tenantDomain}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a tenant';

    /**
     * Execute the console command.
     */
    public function handle(
        TenancyService $tenancyService
    ): int {
        $newTenant = (new CreateTenantForm())
            ->setName($this->argument('tenantName'))
            ->setDomain($this->argument('tenantDomain'));

        try {
            return (int)$tenancyService->createTenant($newTenant);
        } catch (GeneralTenantCreationException $e) {
            return parent::FAILURE;
        }
    }
}
