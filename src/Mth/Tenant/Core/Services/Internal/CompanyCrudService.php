<?php

namespace Mth\Tenant\Core\Services\Internal;

use Mth\Common\Core\Contracts\ICrudRepository;
use Mth\Common\Core\Services\Internal\AbstractCrudService;
use Mth\Tenant\Adapters\Models\Company;
use Mth\Tenant\Adapters\Models\User;
use Mth\Tenant\Core\Repositories\Crud\CompanyCrudRepository;

class CompanyCrudService extends AbstractCrudService
{
    public function __construct(
        protected readonly CompanyCrudRepository $companyCrudRepository,
        protected readonly UserCrudService $userCrudService
    ) {

    }

    protected function repository(): ICrudRepository
    {
        return $this->companyCrudRepository;
    }

    public function associateUser(
        Company $company,
        ?array $userIds,
        bool $withoutDetach = true
    ): array {

        if ($withoutDetach) {
            return $company->users()->syncWithoutDetaching($userIds);
        }

        return $company->users()->sync($userIds);
    }

    public function associateCompanies(
        User $user,
        ?array $companyIds,
        bool $withoutDetach = true
    ): array {
        if ($withoutDetach) {
            return $user->companies()->syncWithoutDetaching($companyIds);
        }

        return $user->companies()->sync($companyIds);
    }

    public function getCompanies(
        int $perPage,
        int $page
    ): array {
        return $this->paginate($perPage, ['*'], $page)->items();
    }

    public function getCompaniesOfUserPaginated(
        User $user,
        int $perPage,
        int $page
    ): array {

        return $user->load('companies')
                    ->companies()
                    ->paginate($perPage, ['*'], $page)->items();
    }

    public function getCompaniesOfUser(
        User $user
    ): array {
        return $user->load('companies')
                    ->companies()
                    ->get()->toArray();
    }
}
