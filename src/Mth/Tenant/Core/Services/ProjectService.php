<?php

namespace Mth\Tenant\Core\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Mth\Common\Constants\NamedRoutes;
use Mth\Common\Helpers\UuidHelper;
use Mth\Tenant\Adapters\Models\Project;
use Mth\Tenant\Adapters\Models\User;
use Mth\Tenant\Core\Dto\Project\Forms\CreateProjectForm;
use Mth\Tenant\Core\Dto\Project\Forms\UpdateProjectForm;
use Mth\Tenant\Core\Dto\Project\Projections\ProjectProjection;
use Mth\Tenant\Core\Services\Authorization\AuthorizationService;
use Mth\Tenant\Core\Services\Internal\ProjectCrudService;

readonly class ProjectService
{
    public function __construct(
        protected ProjectCrudService $projectCrudService,
        protected AuthorizationService $authorizationService
    ) {

    }

    public function find(string $projectId): ?ProjectProjection
    {
        /* @var Project|null $project */
        $project = $this->projectCrudService->find($projectId);

        return $project ? (new ProjectProjection())
            ->setName($project->name)
            ->setId(UuidHelper::uuidToBase62($project->id))
            ->setDescription($project->description)
            ->setCompany(UuidHelper::uuidToBase62($project->company_id))
            ->setCreator(UuidHelper::uuidToBase62($project->creator_id)) : null;
    }

    public function create(CreateProjectForm $createProjectForm): Model
    {
        return $this->projectCrudService->create($createProjectForm->serialize());
    }

    public function update(UpdateProjectForm $updateProjectForm): Model
    {
        return $this->projectCrudService->update($updateProjectForm->getId(), $updateProjectForm->serialize());
    }

    public function delete(string $projectId): bool
    {
        return $this->projectCrudService->delete($projectId);
    }

    public function getProjects(
        User $user
    ): array {
        if ($this->authorizationService->isAdmin($user)) {
            return $this->projectCrudService->all()->toArray();
        } elseif ($this->authorizationService->isModerator($user)) {
            return $this->projectCrudService->getProjectsOfUserAndAssociatedCompanies($user)->toArray();
        } else {
            return $this->projectCrudService->getUserProjects($user)->toArray();
        }
    }

    public function getProjectsPaginated(
        User $user,
        int $perPage = 15,
        ?int $page = null
    ): LengthAwarePaginator {
        if ($this->authorizationService->isAdmin($user)) {
            $projects = $this->projectCrudService->paginated($this->projectCrudService->allWithRelations(), $perPage, $page);
        } elseif ($this->authorizationService->isModerator($user)) {
            $projects = $this->projectCrudService->paginated($this->projectCrudService->getProjectsOfUserAndAssociatedCompanies($user), $perPage, $page);
        } else {
            $projects = $this->projectCrudService->paginated($this->projectCrudService->getUserProjects($user), $perPage, $page);
        }

        $projections = array_map(function (Project $project) {

            return (new ProjectProjection())
                ->setId(UuidHelper::uuidToBase62($project->id))
                ->setName($project->name)
                ->setDescription($project->description)
                ->setCreator($project->creator->name)
                ->setCompany($project->company->name);
        }, $projects->items());

        return new LengthAwarePaginator($projections, count($projects), $perPage, $page, ['path' => url(NamedRoutes::PROJECTS)]);
    }
}
