<?php

namespace Mth\Landlord\Core\Services\Internal;

use Mth\Common\Core\Contracts\ICrudRepository;
use Mth\Common\Core\Services\Internal\AbstractCrudService;
use Mth\Landlord\Core\Repositories\CRUD\TenantCrudRepository;

class TenantCrudService extends AbstractCrudService
{

    public function __construct(
        private readonly TenantCrudRepository $tenantCrudRepository
    )
    {

    }
    protected function repository(): ICrudRepository
    {
        return $this->tenantCrudRepository;
    }
}
