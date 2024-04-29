<?php

namespace Mth\Landlord\Core\Repositories\CRUD;

use Illuminate\Database\Eloquent\Model;
use Mth\Common\Core\Contracts\ICrudRepository;
use Mth\Common\Core\Repositories\BaseCrudRepository;
use Mth\Landlord\Adapters\Models\Tenant;

class TenantCrudRepository extends BaseCrudRepository implements ICrudRepository
{
    protected function getModel(): Model
    {
        return new Tenant;
    }
}
