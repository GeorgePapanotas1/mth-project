<?php

namespace Tests\Feature\src\Landlord\Core\Services;

use Mth\Landlord\Adapters\Models\Tenant;
use Mth\Landlord\Core\Dto\Forms\CreateTenantForm;
use Mth\Tenant\Adapters\Models\User;
use Mth\Tenant\Core\Constants\Enums\Role;
use Mth\Tenant\Core\Dto\User\Forms\CreateUserForm;
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

test('New tenant is created with proper setup', function () use ($tenantName, $tenantDomain) {
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

test('new tenant with default user is properly setup', function () use ($tenantName, $tenantDomain){

    $newTenantForm = (new CreateTenantForm())
        ->setName($tenantName)
        ->setDomain($tenantDomain);

    $newUserForm = (new CreateUserForm())
        ->setName('TEST')
        ->setEmail('test@test.com')
        ->setPassword('password');

    $tenantService = getTenancyService();

    $newTenant = $tenantService->registerUserWithTenant($newTenantForm, $newUserForm);

    $tenantCrudService = getTenantCrudService();
    expect($tenantCrudService->all())
        ->toHaveCount(1);

    $newTenant->makeCurrent();

    $authService = getAuthorizationService();
    $tenantUsers = User::all();
    expect($tenantUsers)
        ->toHaveCount(1)
        ->and($authService->getUserRole($tenantUsers[0]))
        ->toBe(Role::ADMIN);

    $newTenant->forgetCurrent();

});

test('tenants are returned paginated', function () {
    Tenant::factory()->count(16)->create();

    $tenancyService = getTenancyService();

    $tenants = $tenancyService->getTenantsPaginated();

    expect($tenants->items())
        ->toHaveCount(15);
});

test('On tenant context check returns the tenant', function () use ($tenantName, $tenantDomain){
    $newTenantForm = (new CreateTenantForm())
        ->setName($tenantName)
        ->setDomain($tenantDomain);

    $tenancyService = getTenancyService();

    $tenancyService->createTenant($newTenantForm);

    $tenantCrudService = getTenantCrudService();

    expect($tenantCrudService->all())
        ->toHaveCount(1);

    $tenant = $tenantCrudService->getTenantWithDomain($tenantDomain);

    $tenant->makeCurrent();
    $tenant = $tenancyService->checkCurrent();

    expect($tenant)
        ->not()
        ->toBeNull();

    $tenant->forgetCurrent();
});

test('On landlord context check returns null', function () use ($tenantName, $tenantDomain){
    $newTenantForm = (new CreateTenantForm())
        ->setName($tenantName)
        ->setDomain($tenantDomain);

    $tenancyService = getTenancyService();

    $tenancyService->createTenant($newTenantForm);

    $tenantCrudService = getTenantCrudService();

    expect($tenantCrudService->all())
        ->toHaveCount(1);

    $tenant = $tenancyService->checkCurrent();

    expect($tenant)
        ->toBeNull();

});

afterEach(function () use ($tenantDb) {
    TestSuite::cleanTenant($tenantDb);
});

afterAll(function () {
    TestSuite::cleanDatabase();
});
