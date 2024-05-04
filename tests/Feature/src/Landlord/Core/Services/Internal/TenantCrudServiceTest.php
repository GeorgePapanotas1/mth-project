<?php

namespace Tests\Feature\Landlord\Core\Services\Internal;

use Mth\Landlord\Adapters\Models\Tenant;
use Mth\Landlord\Core\Services\Internal\TenantCrudService;
use Tests\Helpers\TestSuite;

beforeAll(function () {
    TestSuite::refreshDatabaseAsLandlord();
});

beforeEach(function () {
    TestSuite::cleanupTable(new Tenant());
});

testBasicCrudOperations(Tenant::class, app()->make(TenantCrudService::class));

test('it fetches a tenant by its domain', function () {
    Tenant::factory()->domain('testdomain')->create();

    $tenancyService = getTenantCrudService();

    $tenant = $tenancyService->getTenantWithDomain('testdomain');

    expect($tenant)
        ->not()
        ->toBeNull()
        ->and($tenant)
        ->toBeInstanceOf(Tenant::class);
});

afterAll(function () {
    TestSuite::cleanDatabase();
});
