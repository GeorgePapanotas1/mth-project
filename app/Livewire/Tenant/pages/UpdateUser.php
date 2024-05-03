<?php

namespace App\Livewire\Tenant\pages;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Mth\Common\Helpers\UuidHelper;
use Mth\Tenant\Adapters\Models\User;
use Mth\Tenant\Core\Dto\Company\Projections\CompanyProjection;
use Mth\Tenant\Core\Dto\User\Forms\UpdateUserForm;
use Mth\Tenant\Core\Exceptions\Authorization\UnauthorizedException;
use Mth\Tenant\Core\Services\Authorization\AuthorizationService;
use Mth\Tenant\Core\Services\CompanyService;
use Mth\Tenant\Core\Services\UserService;
use Illuminate\Validation\Rules;

class UpdateUser extends Component
{
    private readonly AuthorizationService $authorizationService;
    private readonly UserService $userService;
    private readonly CompanyService $companyService;
    public array $availableRoles = [];
    public string $id;
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $role = '';
    public array $availableCompanies = [];
    public array $selectedCompanies = [];

    public function boot(
        AuthorizationService $authorizationService,
        UserService $userService,
        CompanyService $companyService
    ) {
        $this->authorizationService = $authorizationService;
        $this->userService          = $userService;
        $this->companyService       = $companyService;

        $this->availableRoles = $authorizationService->listRoles();

        try {
            collect($this->companyService->getCompanies(Auth::user(), 999)->items())
                ->each(function (CompanyProjection $company) {
                    $this->availableCompanies[$company->getId()] = $company->getName();
                });
        } catch (UnauthorizedException $e) {
            abort(401, $e->getMessage());
        }
    }

    public function mount(
        string $uuid
    ) {
        try {
            $user = $this->userService->find(UuidHelper::base62ToUuid($uuid));

            $this->name  = $user->getName();
            $this->email = $user->getEmail();
            $this->role  = $user->getRole();
            $this->id    = $user->getId();

            collect($this->companyService->getCompaniesOfUser(UuidHelper::base62ToUuid($user->getId())))
                ->each(function ($company) {
                    $this->selectedCompanies[] = $company->getId();
                });
        } catch (\Throwable) {
            abort(404);
        }
    }

    public function submit()
    {
        $validated = $this->validate([
            'name'     => 'sometimes|string|max:255',
            'password' => ['nullable', 'string', 'confirmed', Rules\Password::defaults()],
            'role'     => ['in:Admin,Moderator']
        ]);

        $updateForm = (new UpdateUserForm())
            ->setName($this->name)
            ->setId(UuidHelper::base62ToUuid($this->id))
            ->setPassword($this->password ? Hash::make($this->password) : null);

        try {
            /* @var User $user */
            $user = $this->userService->update(Auth::user(), $updateForm);
            $this->companyService->associateCompanies($updateForm->getId(), array_map(function (string $id) {
                return UuidHelper::base62ToUuid($id);
            }, $this->selectedCompanies), false);

            $this->authorizationService->assignRole($user, $this->role);
        } catch (UnauthorizedException $e) {
            abort(401, $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.tenant.update-user')->layout('layouts.app');
    }
}
