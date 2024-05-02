<?php

namespace Mth\Landlord\Core\Services;

use Illuminate\Auth\Events\Registered;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Mth\Landlord\Adapters\Models\Tenant;
use Mth\Landlord\Core\Constants\ColumnNames\TenantColumns;
use Mth\Landlord\Core\Dto\Forms\CreateTenantForm;
use Mth\Landlord\Core\Exceptions\Tenancy\GeneralTenantCreationException;
use Mth\Landlord\Core\Repositories\Crud\TenantCrudRepository;
use Mth\Landlord\Core\Repositories\Custom\TenancyRepository;
use Mth\Tenant\Core\Constants\Enums\Role;
use Mth\Tenant\Core\Dto\Authorization\Forms\CreateRoleForm;
use Mth\Tenant\Core\Dto\User\Forms\CreateUserForm;
use Mth\Tenant\Core\Services\Authorization\AuthorizationService;
use Mth\Tenant\Core\Services\Internal\UserCrudService;

readonly class TenancyService
{
    public function __construct(
        protected TenantCrudRepository $tenantCrudRepository,
        protected TenancyRepository $tenancyRepository,
        protected UserCrudService $userCrudService,
        protected AuthorizationService $authorizationService
    ) {

    }

    /**
     * @param CreateTenantForm $createTenantForm
     * @return bool
     * @throws GeneralTenantCreationException
     */
    public function createTenant(CreateTenantForm $createTenantForm): bool
    {

        try {
            $this->tenancyRepository->createTenantDatabase($createTenantForm->getDatabase());

            DB::beginTransaction();

            /* @var Tenant $tenant */
            $tenant = $this->tenantCrudRepository->create($createTenantForm->toDatabaseArray());

            $tenant->makeCurrent();

            Artisan::call('tenants:artisan', [
                'artisanCommand' => 'migrate --force --path=database/migrations/tenant --database=tenant',
            ]);

            $roleForm = (new CreateRoleForm())
                ->setName(Role::ADMIN);
            $this->authorizationService->createRole($roleForm);

            $roleForm = (new CreateRoleForm())
                ->setName(Role::MODERATOR);
            $this->authorizationService->createRole($roleForm);

            $tenant->forgetCurrent();

            DB::commit();

            return true;
        } catch (\Throwable $t) {
            if (isset($tenant)) {
                $tenant->forgetCurrent();
            }

            DB::rollBack();

            $tenant = $this->tenantCrudRepository->findBy([TenantColumns::DOMAIN => $createTenantForm->getDomain()]);

            if (!$tenant) {
                $this->tenancyRepository->deleteTenantDatabase($createTenantForm->getDatabase());
            }

            throw new GeneralTenantCreationException("Failed to create tenant: " . $t->getMessage());
        }
    }

    public function getTenantsPaginated(
        int $perPage = 15,
        ?int $page = null
    ): LengthAwarePaginator {
        return $this->tenantCrudRepository->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * @throws GeneralTenantCreationException
     */
    public function registerUserWithTenant(
        CreateTenantForm $tenantForm,
        CreateUserForm $userForm,
    ): ?Tenant {
        $tenantCreated = $this->createTenant($tenantForm);

        if ($tenantCreated) {

            $newTenant = $this->tenantCrudRepository->getTenantWithDomain($tenantForm->getDomain());
            $newTenant->makeCurrent();

            $user = $this->userCrudService->create($userForm->serialize());

            $this->authorizationService->assignRole($user, Role::ADMIN);

            event(new Registered($user));
            
            $newTenant->forgetCurrent();

            return $newTenant;
        }

        return null;
    }
}
