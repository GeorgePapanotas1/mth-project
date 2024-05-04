<?php

namespace Tests\Feature\src\Landlord\Core\Services;

use Mth\Landlord\Adapters\Models\Tenant;
use Mth\Landlord\Core\Dto\Forms\CreateTenantForm;
use Tests\Helpers\TestSuite;

$tenantName   = 'test';
$tenantDb     = 'tenant_workspace';
$tenantDomain = 'workspace';

beforeAll(function () {
    TestSuite::refreshDatabaseAsLandlord();
});

beforeEach(function () {
    TestSuite::cleanupTable(new Tenant());
});

test('true', function () use ($tenantName, $tenantDomain) {
    $newTenantForm = (new CreateTenantForm())
        ->setName($tenantName)
        ->setDomain($tenantDomain);

    $tenantService = getTenancyService();

    $tenantService->createTenant($newTenantForm);
    $tenantCrudService = getTenantCrudService();
    expect($tenantCrudService->all())
        ->toHaveCount(1);

    $tenant = $tenantCrudService->getTenantWithDomain($tenantDomain);

    $tenant->makeCurrent();

    $authService = getAuthorizationService();

    $roles = $authService->listRoles();

    expect($roles)->toHaveCount(2);

    $tenant->forgetCurrent();
});

afterEach(function () use ($tenantDb) {
    TestSuite::cleanDatabase();
    TestSuite::cleanTenant($tenantDb);
});
