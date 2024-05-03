<?php

namespace App\Livewire\Tenant\components;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Mth\Common\Helpers\UuidHelper;
use Mth\Tenant\Core\Services\Authorization\AuthorizationService;
use Mth\Tenant\Core\Services\ProjectService;

class ProjectList extends Component
{
    private readonly ProjectService $projectService;
    private readonly AuthorizationService $authorizationService;
    public bool $canPerformAction = false;

    public function delete(string $uuid)
    {
        $this->projectService->delete(UuidHelper::base62ToUuid($uuid));
    }

    public function boot(
        ProjectService $projectService,
        AuthorizationService $authorizationService
    ) {
        $this->projectService       = $projectService;
        $this->authorizationService = $authorizationService;

        $actor                  = Auth::user();
        $this->canPerformAction = $this->authorizationService->isAdmin($actor) || $this->authorizationService->isModerator($actor);
    }

    public function render()
    {
        return view('livewire.tenant.components.project-list', [
            'projects' => $this->projectService->getProjectsPaginated(Auth::user()),
        ]);
    }
}
