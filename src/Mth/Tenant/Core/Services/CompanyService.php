<?php

namespace Mth\Tenant\Core\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Mth\Common\Constants\NamedRoutes;
use Mth\Common\Helpers\UuidHelper;
use Mth\Tenant\Adapters\Models\Company;
use Mth\Tenant\Adapters\Models\User;
use Mth\Tenant\Core\Dto\Company\Forms\CreateCompanyForm;
use Mth\Tenant\Core\Dto\Company\Forms\UpdateCompanyForm;
use Mth\Tenant\Core\Dto\Company\Projections\CompanyProjection;
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

    /**
     * @throws UnauthorizedException
     */
    public function find(User $user, string $companyId): ?CompanyProjection
    {
        if (!$this->authorizationService->isAdmin($user)) {
            throw new UnauthorizedException('Only admins can read companies');
        }

        /* @var Company|null $company */
        $company = $this->crudService->find($companyId);

        return $company ? (new CompanyProjection())
            ->setId(UuidHelper::uuidToBase62($company->id))
            ->setAddress($company->address)
            ->setName($company->name) : null;
    }

    public function associateUser(
        Company $company,
        ?array $userIds,
        bool $withoutDetach = true
    ): array {
        return $this->crudService->associateUser($company, $userIds, $withoutDetach);
    }

    public function associateCompanies(
        string $userId,
        ?array $companyIds,
        bool $withoutDetach = true
    ): array {
        return $this->crudService->associateCompanies($userId, $companyIds, $withoutDetach);
    }

    public function getCompanies(
        User $user,
        int $perPage = 15,
        ?int $page = null
    ): LengthAwarePaginator {

        if ($this->authorizationService->isAdmin($user)) {
            $companies = $this->crudService->getCompanies($perPage, $page);
        } else {
            $companies = $this->crudService->getCompaniesOfUserPaginated($user, $perPage, $page);
        }

        $projections = array_map(function (Company $company) {
            return (new CompanyProjection())
                ->setId(UuidHelper::uuidToBase62($company->id))
                ->setName($company->name)
                ->setAddress($company->address);
        }, $companies->items());

        return new LengthAwarePaginator($projections, $companies->total(), $perPage, $page, ['path' => url(NamedRoutes::COMPANIES)]);
    }

    public function getCompaniesOfUser(
        string $userId
    ): Collection {
        return $this->crudService->getCompaniesOfUser($userId)->map(function (Company $company) {
            return (new CompanyProjection())
                ->setId(UuidHelper::uuidToBase62($company->id))
                ->setName($company->name)
                ->setAddress($company->address);
        });
    }
}
