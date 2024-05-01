<?php

namespace Mth\Tenant\Core\Services\Internal;

use Mth\Common\Core\Contracts\ICrudRepository;
use Mth\Common\Core\Services\Internal\AbstractCrudService;
use Mth\Tenant\Adapters\Models\User;
use Mth\Tenant\Core\Repositories\Crud\ProjectCrudRepository;

class ProjectCrudService extends AbstractCrudService
{
    public function __construct(
        protected readonly ProjectCrudRepository $projectCrudRepository
    ) {

    }

    protected function repository(): ICrudRepository
    {
        return $this->projectCrudRepository;
    }

    public function getProjectsOfUserAndCompanies(
        User $user
    ): array {
        $user->load('projects', 'companies.projects');
        $userProjects = $user->projects;

        $companyProjects = $user->companies->flatMap(function ($company) {
            return $company->projects;
        });

        return $userProjects->merge($companyProjects)->unique('id')->toArray();
    }

    public function getUserProjects(
        User $user
    ): array {
        return $user->load('projects')->projects->toArray();
    }
}
