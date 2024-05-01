<?php

namespace Mth\Tenant\Core\Services;

use Illuminate\Database\Eloquent\Model;
use Mth\Tenant\Adapters\Models\Company;
use Mth\Tenant\Adapters\Models\User;
use Mth\Tenant\Core\Constants\Enums\Role;
use Mth\Tenant\Core\Dto\Company\Forms\CreateCompanyForm;
use Mth\Tenant\Core\Dto\Company\Forms\UpdateCompanyForm;
use Mth\Tenant\Core\Exceptions\Authorization\UnauthorizedException;
use Mth\Tenant\Core\Services\Authorization\AuthorizationService;
use Mth\Tenant\Core\Services\Internal\CompanyCrudService;

readonly class CompanyService
{
    public function __construct(
        protected CompanyCrudService $crudService,
        protected AuthorizationService $authorizationService
    ) {

    }

    /**
     * @throws UnauthorizedException
     */
    public function create(User $user, CreateCompanyForm $companyForm): Model
    {
        if (!$this->authorizationService->isAdmin($user)) {
            throw new UnauthorizedException('Only admins can create a company');
        }

        return $this->crudService->create($companyForm->serialize());
    }

    /**
     * @throws UnauthorizedException
     */
    public function update(User $user, UpdateCompanyForm $companyForm): Model
    {
        if (!$this->authorizationService->isAdmin($user)) {
            throw new UnauthorizedException('Only admins can edit a company');
        }

        return $this->crudService->update($companyForm->getId(), $companyForm->serialize());
    }

    /**
     * @throws UnauthorizedException
     */
    public function delete(User $user, string $companyId): bool
    {
        if (!$this->authorizationService->isAdmin($user)) {
            throw new UnauthorizedException('Only admins can delete a company');
        }

        return $this->crudService->delete($companyId);
    }

    public function associateUser(
        Company $company,
        ?array $userIds,
        bool $withoutDetach = true
    ): array {
        return $this->crudService->associateUser($company, $userIds, $withoutDetach);
    }

    /**
     * @throws UnauthorizedException
     */
    public function getCompanies(
        User $user,
        int $perPage = 15,
        int $page = 1
    ): array {

        if ($this->authorizationService->isAdmin($user)) {
            return $this->crudService->getCompanies($perPage, $page);
        } elseif ($this->authorizationService->isModerator($user)) {
            return $this->crudService->getCompaniesOfUser($user, $perPage, $page);
        }

        throw new UnauthorizedException('Unauthorized User');
    }
}
