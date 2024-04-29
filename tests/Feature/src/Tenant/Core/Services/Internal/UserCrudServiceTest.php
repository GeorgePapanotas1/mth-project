<?php

namespace Tests\Feature\Landlord\Tenant\Core\Services\Internal;

use Mth\Tenant\Adapters\Models\User;
use Mth\Tenant\Core\Services\Internal\UserCrudService;
use Tests\Helpers\TestSuite;

beforeAll(function () {
    TestSuite::refreshDatabaseAsTenant();
});

beforeEach(function () {
    TestSuite::cleanupTable(new User());
});

testBasicCrudOperations(User::class, app()->make(UserCrudService::class));

afterAll(function () {
    TestSuite::cleanDatabase();
});
