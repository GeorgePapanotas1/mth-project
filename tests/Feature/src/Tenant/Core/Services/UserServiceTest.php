<?php

namespace Tests\Feature\src\Tenant\Core\Services;

use Mth\Tenant\Adapters\Models\Role;
use Mth\Tenant\Adapters\Models\User;

use Mth\Tenant\Core\Dto\Authorization\Forms\CreateRoleForm;
use Mth\Tenant\Core\Dto\User\Forms\CreateUserForm;
use Mth\Tenant\Core\Dto\User\Forms\UpdateUserForm;
use Mth\Tenant\Core\Dto\User\Projections\UserProjection;
use Mth\Tenant\Core\Exceptions\Authorization\UnauthorizedException;
use Tests\Helpers\TestSuite;

beforeAll(function () {
    TestSuite::refreshDatabaseAsTenant();
});

beforeEach(function () {
    User::truncate();
    Role::truncate();
});

test('it creates a user', function () {

    $newUserForm = (new CreateUserForm())
        ->setName('New user')
        ->setEmail('new_user@google.com')
        ->setPassword('test_password');

    $user = createUserAndAssignRole('Admin');

    $userService = getUserService();

    $newUser = $userService->create($user, $newUserForm);

    expect($newUser)
        ->toBeInstanceOf(User::class)
        ->and($newUser->id)
        ->not()
        ->toBeNull();
});

test('it throws unauthorized exception on creation', function () {

    $newUserForm = (new CreateUserForm())
        ->setName('New user')
        ->setEmail('new_user@google.com')
        ->setPassword('test_password');

    $user = User::factory()->create();

    $userService = getUserService();

    $userService->create($user, $newUserForm);
})->throws(UnauthorizedException::class);

test('it updates a user', function () {
    $existingUser = User::factory()->create();

    $admin = createUserAndAssignRole('Admin');

    $updateUserForm = (new UpdateUserForm())
        ->setId($existingUser->id)
        ->setName('New user name')
        ->setEmail('new_user@google.com')
        ->setPassword('test_password');

    $userService = getUserService();

    $updatedUser = $userService->update($admin, $updateUserForm);

    expect($updatedUser->id)
        ->toEqual($existingUser->id)
        ->and($updatedUser->name)->toEqual($updateUserForm->getName())
        ->and($updatedUser->email)->toEqual($updateUserForm->getEmail());
});

test('it throws unauthorized exception on updating', function () {
    $existingUser = User::factory()->create();
    $actor        = User::factory()->create();

    $updateUserForm = (new UpdateUserForm())
        ->setId($existingUser->id)
        ->setName('New user name')
        ->setEmail('new_user@google.com')
        ->setPassword('test_password');

    $userService = getUserService();

    $userService->update($actor, $updateUserForm);
})->throws(UnauthorizedException::class);

test('it fetches all users paginated', function () {

    $users = User::factory(16)->create();

    $userService = getUserService();

    $firstBatch = $userService->getUsers();

    expect($firstBatch)->toHaveCount(15);

    $secondBatch = $userService->getUsers(15, 2);

    expect($secondBatch)->toHaveCount(1);
});

test('only admin can delete a user', function () {

    Role::create(['name' => 'Admin']);
    Role::create(['name' => 'Moderator']);

    $admin = User::factory()->create()->assignRole('Admin');
    $mod = User::factory()->create()->assignRole('Moderator');

    $users = User::factory()->count(2)->create();

    $userService = getUserService();

    $result = $userService->delete($admin, $users[0]->id);

    expect($result)->toBeTrue();

    $result = $userService->delete($mod, $users[1]->id);


})->throws(UnauthorizedException::class);

test('find returns projection', function () {
   $user = User::factory()->create();

   $userService = getUserService();

   $userFound = $userService->find($user->id);

   expect($userFound)
       ->toBeInstanceOf(UserProjection::class);
});

test('find returns null', function () {

    $userService = getUserService();

    $userFound = $userService->find('9bf656d2-e79a-403c-a46e-a78fef60cee6');

    expect($userFound)
        ->toBeNull();
});
