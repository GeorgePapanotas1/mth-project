<?php

namespace App\Livewire\Tenant\pages;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Mth\Common\Helpers\UuidHelper;
use Mth\Tenant\Core\Dto\Company\Projections\CompanyProjection;
use Mth\Tenant\Core\Dto\Project\Forms\UpdateProjectForm;
use Mth\Tenant\Core\Dto\User\Projections\UserProjection;
use Mth\Tenant\Core\Services\Authorization\AuthorizationService;
use Mth\Tenant\Core\Services\CompanyService;
use Mth\Tenant\Core\Services\ProjectService;
use Mth\Tenant\Core\Services\UserService;

class UpdateProject extends Component
{
    private readonly ProjectService $projectService;
    public string $id = '';
    public string $name = '';
    public string $description = '';
    public string $selectedCompany = '';
    public string $selectedUser = '';
    public array $availableCompanies = [];
    public array $availableUsers = [];
    public bool $isAdmin = false;

    public function boot(
        ProjectService $projectService,
        CompanyService $companyService,
        UserService $userService,
        AuthorizationService $authorizationService
    ) {
        $this->projectService = $projectService;

        $this->isAdmin = $authorizationService->isAdmin(Auth::user());

        collect($companyService->getCompanies(Auth::user(), -1, 1)->items())
            ->each(function (CompanyProjection $company) {
                $this->availableCompanies[$company->getId()] = $company->getName();
            });

        if ($this->isAdmin) {
            collect($userService->getUsers(-1, 1)->items())
                ->each(function (UserProjection $userProjection) {
                    $this->availableUsers[$userProjection->getId()] = $userProjection->getName();
                });
        }
    }

    public function mount(
        string $uuid
    ) {

        try {
            $project = $this->projectService->find(UuidHelper::base62ToUuid($uuid));

            if (!$project) {
                abort(404);
            }

            $this->name            = $project->getName();
            $this->description     = $project->getDescription();
            $this->selectedCompany = $project->getCompany();
            $this->selectedUser    = $project->getCreator();
            $this->id              = $project->getId();
        } catch (\Throwable) {
            abort(404);
        }
    }

    public function submit()
    {
        $updateProjectForm = (new UpdateProjectForm())
            ->setId(UuidHelper::base62ToUuid($this->id))
            ->setName($this->name)
            ->setDescription($this->description)
            ->setCreatorId(UuidHelper::base62ToUuid($this->selectedUser))
            ->setCompanyId(UuidHelper::base62ToUuid($this->selectedCompany));

        $this->projectService->update($updateProjectForm);
    }

    public function render()
    {
        return view('livewire.tenant.update-project')->layout('layouts.app');
    }
}
