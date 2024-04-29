<?php

namespace Tests\Feature\Landlord\Tenant\Core\Services\Internal;

use Mth\Tenant\Adapters\Models\Project;
use Mth\Tenant\Core\Services\Internal\ProjectCrudService;
use Tests\Helpers\TestSuite;

beforeAll(function () {
    TestSuite::refreshDatabaseAsTenant();
});

beforeEach(function () {
    TestSuite::cleanupTable(new Project());
});

testBasicCrudOperations(Project::class, app()->make(ProjectCrudService::class));

afterAll(function () {
    TestSuite::cleanDatabase();
});
