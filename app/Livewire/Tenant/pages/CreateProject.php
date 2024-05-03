<?php

namespace App\Livewire\Tenant\pages;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Mth\Common\Constants\NamedRoutes;
use Mth\Common\Helpers\UuidHelper;
use Mth\Tenant\Core\Dto\Company\Projections\CompanyProjection;
use Mth\Tenant\Core\Dto\Project\Forms\CreateProjectForm;
use Mth\Tenant\Core\Dto\User\Projections\UserProjection;
use Mth\Tenant\Core\Services\Authorization\AuthorizationService;
use Mth\Tenant\Core\Services\CompanyService;
use Mth\Tenant\Core\Services\ProjectService;
use Mth\Tenant\Core\Services\UserService;

class CreateProject extends Component
{
    private readonly ProjectService $projectService;
    private readonly CompanyService $companyService;
    private readonly AuthorizationService $authorizationService;
    private readonly UserService $userService;
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
        $this->projectService       = $projectService;
        $this->companyService       = $companyService;
        $this->authorizationService = $authorizationService;
        $this->userService          = $userService;
        $this->isAdmin              = $this->authorizationService->isAdmin(Auth::user());

        collect($this->companyService->getCompanies(Auth::user(), -1, 1)->items())
            ->each(function (CompanyProjection $company) {
                $this->availableCompanies[$company->getId()] = $company->getName();
            });

        if ($this->isAdmin) {
            collect($this->userService->getUsers(-1, 1)->items())
                ->each(function (UserProjection $userProjection) {
                    $this->availableUsers[$userProjection->getId()] = $userProjection->getName();
                });
        } else {
            $this->selectedUser = UuidHelper::uuidToBase62(Auth::user()->id);
        }
    }

    public function submit()
    {
        $newProjectForm = (new CreateProjectForm())
            ->setName($this->name)
            ->setDescription($this->description)
            ->setCreatorId(UuidHelper::base62ToUuid($this->selectedUser))
            ->setCompanyId(UuidHelper::base62ToUuid($this->selectedCompany));

        $this->projectService->create($newProjectForm);

        return redirect()->route(NamedRoutes::PROJECTS);
    }

    public function render()
    {
        return view('livewire.tenant.create-project')->layout('layouts.app');
    }
}
