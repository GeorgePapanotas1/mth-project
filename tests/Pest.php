<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Mth\Common\Core\Contracts\ICrudService;
use Mth\Tenant\Adapters\Models\User;
use Mth\Tenant\Core\Dto\Authorization\Forms\CreateRoleForm;
use Mth\Tenant\Core\Services\Authorization\AuthorizationService;
use Mth\Tenant\Core\Services\CompanyService;
use Mth\Tenant\Core\Services\ProjectService;
use Mth\Tenant\Core\Services\UserService;
use Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

uses(TestCase::class, RefreshDatabase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function something()
{
    // ..
}

function testBasicCrudOperations(string $modelClass, ICrudService $service): void
{

    test('creates a model', function () use ($modelClass, $service) {
        $modelData = $modelClass::factory()->make()->toArray();

        if (isUserClass($modelClass)) {
            $modelData['password'] = Hash::make('password');
        }

        $createdModel = $service->create($modelData);
        expect($createdModel)->toBeInstanceOf($modelClass);
        $this->assertDatabaseHas((new $modelClass)->getTable(), $modelData);
    });

    test('retrieves a model by id', function () use ($modelClass, $service) {
        $model      = $modelClass::factory()->create();
        $foundModel = $service->find($model->id);
        expect($foundModel)->toBeInstanceOf($modelClass)
                           ->and($foundModel->id)->toEqual($model->id);
    });

    test('updates a model', function () use ($modelClass, $service) {
        $model      = $modelClass::factory()->create();
        $updateData = $modelClass::factory()->make()->toArray();

        if (isUserClass($modelClass)) {
            $updateData['password'] = Hash::make('password');
        }

        $updatedModel = $service->update($model->id, $updateData);

        if (isUserClass($modelClass)) {
            unset($updateData['password']);
        }
        expect($updatedModel->fresh()->toArray())->toMatchArray($updateData);
    });

    test('deletes a model', function () use ($modelClass, $service) {
        $model = $modelClass::factory()->create();
        $service->delete($model->id);
        $this->assertDatabaseMissing((new $modelClass)->getTable(), ['id' => $model->id]);
    });

    test('lists all models', function () use ($modelClass, $service) {
        $modelClass::factory()->count(3)->create();
        $models = $service->all();
        expect($models)->toHaveCount(3);
    });
}

function isUserClass(string $modelClass): bool
{
    return $modelClass === 'Mth\Tenant\Adapters\Models\User';
}

function getUserService(): UserService
{
    return app()->get(UserService::class);
}

function getAuthorizationService(): AuthorizationService
{
    return app()->get(AuthorizationService::class);
}

function getCompanyService(): CompanyService
{
    return app()->get(CompanyService::class);
}

function getProjectService(): ProjectService
{
    return app()->get(ProjectService::class);
}

function createUserAndAssignRole(string $role): User
{
    $authorizationService = getAuthorizationService();

    $authorizationService->createRole((new CreateRoleForm())->setName($role));

    $user = User::factory()->create();

    $authorizationService->assignRole($user, $role);

    return $user;
}
