<?php

namespace Mth\Tenant\Core\Services\Internal;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
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

    public function getProjectsOfUserAndAssociatedCompanies(
        User $user
    ): Collection {
        $user->load('projects', 'companies.projects');
        $userProjects = $user->projects;

        $companyProjects = $user->companies->flatMap(function ($company) {
            return $company->projects;
        });

        return $userProjects->merge($companyProjects)->unique('id');
    }

    public function paginated(Collection $collection, int $perPage, int $page = null): LengthAwarePaginator
    {
        return new LengthAwarePaginator($collection, count($collection), $perPage, $page);
    }

    public function getUserProjects(
        User $user
    ): Collection {
        return $user->load('projects')->projects;
    }
}
