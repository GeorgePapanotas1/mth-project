<?php

namespace Tests\Feature\src\Tenant\Core\Services;

use Mth\Tenant\Adapters\Models\Company;
use Mth\Tenant\Adapters\Models\Role;
use Mth\Tenant\Adapters\Models\User;
use Mth\Tenant\Adapters\Models\UsersCompanies;
use Mth\Tenant\Core\Constants\ColumnNames\UsersCompaniesColumns;
use Mth\Tenant\Core\Dto\Authorization\Forms\CreateRoleForm;
use Mth\Tenant\Core\Dto\Company\Forms\CreateCompanyForm;
use Mth\Tenant\Core\Dto\Company\Forms\UpdateCompanyForm;
use Mth\Tenant\Core\Exceptions\Authorization\RoleCreationException;
use Mth\Tenant\Core\Exceptions\Authorization\UnauthorizedException;
use Mth\Tenant\Core\Services\Authorization\AuthorizationService;
use Mth\Tenant\Core\Services\CompanyService;
use Tests\Helpers\TestSuite;

beforeAll(function () {
    TestSuite::refreshDatabaseAsTenant();
});

beforeEach(function () {
    Company::truncate();
    User::truncate();
    Role::truncate();
    UsersCompanies::truncate();
});

test('it creates a company', function () {

    $user = createUserAndAssignRole('Admin');

    $companyDTO = (new CreateCompanyForm)
        ->setName('Test Company')
        ->setAddress('Test Address');

    $companyService = getCompanyService();

    $newCompany = $companyService->create($user, $companyDTO);

    testCompanyCreation($newCompany, $companyDTO);
});

test('it throws unauthorized exception on creation', function () {
    $user = User::factory()->create();

    $companyDTO = (new CreateCompanyForm)
        ->setName('Test Company')
        ->setAddress('Test Address');

    $companyService = getCompanyService();

    $newCompany = $companyService->create($user, $companyDTO);
})->throws(UnauthorizedException::class);

test('it updates a company', function () {

    $user = createUserAndAssignRole('Admin');

    $companyDTO = (new CreateCompanyForm)
        ->setName('Test Company')
        ->setAddress('Test Address');

    $companyService = getCompanyService();

    $newCompany = $companyService->create($user, $companyDTO);

    testCompanyCreation($newCompany, $companyDTO);

    $updateCompanyDto = (new UpdateCompanyForm())
        ->setName('New Company Name')
        ->setId($newCompany->id);

    $updatedCompany = $companyService->update($user, $updateCompanyDto);

    testCompanyUpdate($newCompany->id, $updatedCompany, $updateCompanyDto);
});

test('it throws unauthorized exception on update', function () {

    $company = Company::factory()->create();

    $user = User::factory()->create();

    $updateCompanyDto = (new UpdateCompanyForm())
        ->setName('New Company Name')
        ->setId($company->id);

    $companyService = getCompanyService();

    $companyService->update($user, $updateCompanyDto);
})->throws(UnauthorizedException::class);

test('it deletes a company', function () {

    $user = createUserAndAssignRole('Admin');

    $company = Company::factory()->create();

    $companyService = getCompanyService();
    $companyService->delete($user, $company->id);

    $this->assertDatabaseMissing($company->getTable(), ['id' => $company->id]);
});

test('it throws unauthorized exception on deletion', function () {

    $user = User::factory()->create();

    $company = Company::factory()->create();

    $companyService = getCompanyService();
    $companyService->delete($user, $company->id);
})->throws(UnauthorizedException::class);

test('it associates users without detaching', function () {
    $userOne = User::factory()->create();
    $userTwo = User::factory()->create();

    $company = Company::factory()->create();

    $companyService = getCompanyService();

    $companyService->associateUser($company, [$userOne->id, $userTwo->id]);

    $this->assertDatabaseHas('users_companies', [
        UsersCompaniesColumns::COMPANY_ID => $company->id,
        UsersCompaniesColumns::USER_ID    => $userOne->id
    ]);

    $this->assertDatabaseHas('users_companies', [
        UsersCompaniesColumns::COMPANY_ID => $company->id,
        UsersCompaniesColumns::USER_ID    => $userTwo->id
    ]);
});

test('it associates users with detaching', function () {
    $userOne = User::factory()->create();
    $userTwo = User::factory()->create();

    $company = Company::factory()->create();

    $companyService = getCompanyService();

    $companyService->associateUser($company, [$userOne->id]);

    $this->assertDatabaseHas('users_companies', [
        UsersCompaniesColumns::COMPANY_ID => $company->id,
        UsersCompaniesColumns::USER_ID    => $userOne->id
    ]);

    $companyService->associateUser($company, [$userTwo->id], false);

    $this->assertDatabaseMissing('users_companies', [
        UsersCompaniesColumns::COMPANY_ID => $company->id,
        UsersCompaniesColumns::USER_ID    => $userOne->id
    ]);

    $this->assertDatabaseHas('users_companies', [
        UsersCompaniesColumns::COMPANY_ID => $company->id,
        UsersCompaniesColumns::USER_ID    => $userTwo->id
    ]);
});

test('it returns all companies on admin', function () {

    $authorizationService = getAuthorizationService();

    $authorizationService->createRole((new CreateRoleForm())->setName('Admin'));

    $user = User::factory()->create();

    $authorizationService->assignRole($user, 'Admin');

    Company::factory()->count(3)->create();

    $service = getCompanyService();

    $companies = $service->getCompanies($user);

    expect($companies)
        ->toHaveCount(3);
});

test('it returns only moderator companies', function () {
    $authorizationService = getAuthorizationService();

    $authorizationService->createRole((new CreateRoleForm())->setName('Moderator'));

    $user = User::factory()->create();

    $authorizationService->assignRole($user, 'Moderator');

    $t = Company::factory()->count(4)->create();

    $firstUserCompany  = $t[2];
    $secondUserCompany = $t[3];

    $companyService = getCompanyService();

    $companyService->associateUser($firstUserCompany, [$user->id]);
    $companyService->associateUser($secondUserCompany, [$user->id]);

    $userCompanies = $companyService->getCompanies($user);

    expect($userCompanies)
        ->toHaveCount(2);
});

test('it returns no companies on random user', function () {

    $user = User::factory()->create();

    $t = Company::factory()->count(4)->create();

    $firstUserCompany  = $t[2];
    $secondUserCompany = $t[3];

    $companyService = getCompanyService();

    $companyService->associateUser($firstUserCompany, [$user->id]);
    $companyService->associateUser($secondUserCompany, [$user->id]);

    $userCompanies = $companyService->getCompanies($user);
})->throws(UnauthorizedException::class);

function testCompanyCreation(Company $company, CreateCompanyForm $companyForm): void
{
    expect($company)
        ->toBeInstanceOf(Company::class)
        ->and($company->id)->toBeString()
        ->and($company->name)->toEqual($companyForm->getName())
        ->and($company->address)->toEqual($companyForm->getAddress());
}

function testCompanyUpdate(string $oldCompanyId, Company $company, UpdateCompanyForm $companyForm): void
{
    expect($company)
        ->toBeInstanceOf(Company::class)
        ->and($company->id)->toBeString($oldCompanyId)
        ->and($company->name)->toEqual($companyForm->getName())
        ->and($company->address)->toEqual($companyForm->getAddress());
}