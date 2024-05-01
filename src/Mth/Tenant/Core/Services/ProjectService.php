<?php

namespace Mth\Tenant\Core\Services;

use Illuminate\Database\Eloquent\Model;
use Mth\Tenant\Adapters\Models\User;
use Mth\Tenant\Core\Dto\Project\Forms\CreateProjectForm;
use Mth\Tenant\Core\Dto\Project\Forms\UpdateProjectForm;
use Mth\Tenant\Core\Services\Authorization\AuthorizationService;
use Mth\Tenant\Core\Services\Internal\ProjectCrudService;

readonly class ProjectService
{
    public function __construct(
        protected ProjectCrudService $projectCrudService,
        protected AuthorizationService $authorizationService
    ) {

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
            return $this->projectCrudService->getProjectsOfUserAndAssociatedCompanies($user);
        } else {
            return $this->projectCrudService->getUserProjects($user);
        }
    }
}
