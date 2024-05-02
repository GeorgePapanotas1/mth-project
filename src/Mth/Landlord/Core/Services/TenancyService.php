<?php

namespace Mth\Landlord\Core\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Mth\Landlord\Adapters\Models\Tenant;
use Mth\Landlord\Core\Constants\ColumnNames\TenantColumns;
use Mth\Landlord\Core\Dto\Forms\CreateTenantForm;
use Mth\Landlord\Core\Exceptions\Tenancy\GeneralTenantCreationException;
use Mth\Landlord\Core\Repositories\Crud\TenantCrudRepository;
use Mth\Landlord\Core\Repositories\Custom\TenancyRepository;

readonly class TenancyService
{
    public function __construct(
        protected TenantCrudRepository $tenantCrudRepository,
        protected TenancyRepository $tenancyRepository
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
}
