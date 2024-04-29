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

afterAll(function () {
    TestSuite::cleanDatabase();
});
