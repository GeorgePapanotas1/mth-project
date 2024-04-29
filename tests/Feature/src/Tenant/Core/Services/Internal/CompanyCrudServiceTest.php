<?php

namespace Tests\Feature\Landlord\Tenant\Core\Services\Internal;

use Mth\Tenant\Adapters\Models\Company;
use Mth\Tenant\Core\Services\Internal\CompanyCrudService;
use Tests\Helpers\TestSuite;

beforeAll(function () {
    TestSuite::refreshDatabaseAsTenant();
});

beforeEach(function () {
    TestSuite::cleanupTable(new Company());
});

testBasicCrudOperations(Company::class, app()->make(CompanyCrudService::class));

afterAll(function () {
    TestSuite::cleanDatabase();
});
