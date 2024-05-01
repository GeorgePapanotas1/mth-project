<?php

namespace Tests\Feature\src\Tenant\Core\Services;

use Mth\Tenant\Adapters\Models\Company;
use Mth\Tenant\Adapters\Models\Project;
use Mth\Tenant\Adapters\Models\Role;
use Mth\Tenant\Adapters\Models\User;
use Mth\Tenant\Adapters\Models\UsersCompanies;
use Mth\Tenant\Core\Dto\Project\Forms\CreateProjectForm;
use Mth\Tenant\Core\Dto\Project\Forms\UpdateProjectForm;
use Tests\Helpers\TestSuite;

beforeAll(function () {
    TestSuite::refreshDatabaseAsTenant();
});

test('it creates a project', function () {
    $user    = User::factory()->create();
    $company = Company::factory()->create();

    $newProjectDTO = (new CreateProjectForm())
        ->setName('new project')
        ->setDescription('new description')
        ->setCreatorId($user->id)
        ->setCompanyId($company->id);

    $projectService = getProjectService();

    $newProject = $projectService->create($newProjectDTO);

    expect($newProject)
        ->toBeInstanceOf(Project::class);
});

test('it updates a project title and description', function () {

    $user    = User::factory()->create();
    $company = Company::factory()->create();
    $project = Project::factory()->ofCreator($user->id)->ofCompany($company->id)->create();

    $newProjectDTO = (new UpdateProjectForm())
        ->setId($project->id)
        ->setName('new project')
        ->setDescription('new description');

    $projectService = getProjectService();

    $newProject = $projectService->update($newProjectDTO);

    expect($newProject)
        ->toBeInstanceOf(Project::class)
        ->and($newProject->name)->toEqual($newProjectDTO->getName())
        ->and($newProject->description)->toEqual($newProjectDTO->getDescription())
        ->and($newProject->creator_id)->toEqual($project->creator_id)
        ->and($newProject->company_id)->toEqual($project->company_id);
});

test('it deletes a project', function () {
    $project        = Project::factory()->create();
    $projectService = getProjectService();
    $projectService->delete($project->id);

    $this->assertDatabaseMissing($project->getTable(), ['id' => $project->id]);
});

test('It gets all projects for admin', function () {
    $admin = createUserAndAssignRole('Admin');

    $userOne   = User::factory()->create();
    $userTwo   = User::factory()->create();
    $userThree = User::factory()->create();

    $company1 = Company::factory()->create();
    $company2 = Company::factory()->create();
    $company3 = Company::factory()->create();

    $companyService = getCompanyService();

    $companyService->associateUser($company1, [
        $userOne->id,
        $userTwo->id
    ]);

    $companyService->associateUser($company2, [
        $userOne->id,
        $userThree->id,
    ]);

    $companyService->associateUser($company3, [
        $userTwo->id,
        $userThree->id
    ]);

    Project::factory()->ofCreator($userOne->id)->ofCompany($company1->id)->create();
    Project::factory()->ofCreator($userOne->id)->ofCompany($company2->id)->create();

    Project::factory()->ofCreator($userTwo->id)->ofCompany($company3->id)->create();
    Project::factory()->ofCreator($userTwo->id)->ofCompany($company1->id)->create();
    Project::factory()->ofCreator($userTwo->id)->ofCompany($company3->id)->create();

    Project::factory()->ofCreator($userThree->id)->ofCompany($company2->id)->create();
    Project::factory()->ofCreator($userThree->id)->ofCompany($company2->id)->create();
    Project::factory()->ofCreator($userThree->id)->ofCompany($company3->id)->create();

    $projectService = getProjectService();

    $adminProjects = $projectService->getProjects($admin);

    expect($adminProjects)->toHaveCount(8);
});

test('it gets projects of moderator along with his companies', function () {
    $mod = createUserAndAssignRole('Moderator');

    $userOne = User::factory()->create();
    $userTwo = User::factory()->create();

    $company1 = Company::factory()->create();
    $company2 = Company::factory()->create();
    $company3 = Company::factory()->create();

    $companyService = getCompanyService();

    $companyService->associateUser($company1, [
        $userOne->id,
        $mod->id
    ]);

    $companyService->associateUser($company2, [
        $userTwo->id,
        $mod->id
    ]);

    $companyService->associateUser($company3, [
        $userTwo->id,
        $userOne->id
    ]);

    // These should be retrieved for moderator
    Project::factory()->ofCreator($userOne->id)->ofCompany($company1->id)->create();
    Project::factory()->ofCreator($userOne->id)->ofCompany($company1->id)->create();
    Project::factory()->ofCreator($userTwo->id)->ofCompany($company2->id)->create();
    Project::factory()->ofCreator($userTwo->id)->ofCompany($company2->id)->create();
    Project::factory()->ofCreator($mod->id)->ofCompany($company1->id)->create();
    Project::factory()->ofCreator($mod->id)->ofCompany($company1->id)->create();
    Project::factory()->ofCreator($mod->id)->ofCompany($company2->id)->create();

    // Special case. The user is associated with a project from a company that he doesn't belong
    Project::factory()->ofCreator($mod->id)->ofCompany($company3->id)->create();

    // These should NOT be retrieved for moderator
    Project::factory()->ofCreator($userOne->id)->ofCompany($company3->id)->create();
    Project::factory()->ofCreator($userOne->id)->ofCompany($company3->id)->create();
    Project::factory()->ofCreator($userTwo->id)->ofCompany($company3->id)->create();
    Project::factory()->ofCreator($userTwo->id)->ofCompany($company3->id)->create();
    Project::factory()->ofCreator($userTwo->id)->ofCompany($company3->id)->create();

    $projectService = getProjectService();

    $modProjects = $projectService->getProjects($mod);

    expect($modProjects)->toHaveCount(8);
});

test('it returns only user projects for normal user', function () {

    $userOne = User::factory()->create();
    $userTwo = User::factory()->create();

    $company1 = Company::factory()->create();
    $company2 = Company::factory()->create();
    $company3 = Company::factory()->create();

    $companyService = getCompanyService();

    $companyService->associateUser($company1, [
        $userOne->id,
    ]);

    $companyService->associateUser($company2, [
        $userTwo->id,
    ]);

    $companyService->associateUser($company3, [
        $userTwo->id,
        $userOne->id
    ]);

    // these should be retrieved
    Project::factory()->ofCreator($userOne->id)->ofCompany($company1->id)->create();
    Project::factory()->ofCreator($userOne->id)->ofCompany($company1->id)->create();
    Project::factory()->ofCreator($userOne->id)->ofCompany($company3->id)->create();
    Project::factory()->ofCreator($userOne->id)->ofCompany($company3->id)->create();

    Project::factory()->ofCreator($userTwo->id)->ofCompany($company2->id)->create();
    Project::factory()->ofCreator($userTwo->id)->ofCompany($company2->id)->create();
    Project::factory()->ofCreator($userTwo->id)->ofCompany($company3->id)->create();
    Project::factory()->ofCreator($userTwo->id)->ofCompany($company3->id)->create();
    Project::factory()->ofCreator($userTwo->id)->ofCompany($company3->id)->create();

    $projectService = getProjectService();

    $modProjects = $projectService->getProjects($userOne);

    expect($modProjects)->toHaveCount(4);
});

test('it returns proper projects', function () {

    $admin = createUserAndAssignRole('Admin');
    $mod   = createUserAndAssignRole('Moderator');

    $userOne = User::factory()->create();
    $userTwo = User::factory()->create();

    $company1 = Company::factory()->create();
    $company2 = Company::factory()->create();
    $company3 = Company::factory()->create();

    $companyService = getCompanyService();

    $companyService->associateUser($company1, [
        $userOne->id,
    ]);

    $companyService->associateUser($company2, [
        $userTwo->id,
        $mod->id
    ]);

    $companyService->associateUser($company3, [
        $userTwo->id,
        $userOne->id
    ]);

    Project::factory()->ofCreator($userOne->id)->ofCompany($company1->id)->create();
    Project::factory()->ofCreator($userOne->id)->ofCompany($company1->id)->create();
    Project::factory()->ofCreator($userOne->id)->ofCompany($company3->id)->create();
    Project::factory()->ofCreator($userOne->id)->ofCompany($company3->id)->create();

    Project::factory()->ofCreator($userTwo->id)->ofCompany($company2->id)->create();
    Project::factory()->ofCreator($userTwo->id)->ofCompany($company2->id)->create();
    Project::factory()->ofCreator($userTwo->id)->ofCompany($company3->id)->create();
    Project::factory()->ofCreator($userTwo->id)->ofCompany($company3->id)->create();
    Project::factory()->ofCreator($userTwo->id)->ofCompany($company3->id)->create();

    Project::factory()->ofCreator($mod->id)->ofCompany($company2->id)->create();

    $projectService = getProjectService();

    $projects = $projectService->getProjects($userOne);

    expect($projects)->toHaveCount(4);

    $adminProjects = $projectService->getProjects($admin);
    expect($adminProjects)->toHaveCount(10);

    $modProjects = $projectService->getProjects($mod);
    expect($modProjects)->toHaveCount(3);
});

beforeEach(function () {
    Company::truncate();
    User::truncate();
    Role::truncate();
    Project::truncate();
    UsersCompanies::truncate();
});
