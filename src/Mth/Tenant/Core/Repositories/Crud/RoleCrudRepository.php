<?php

namespace Mth\Tenant\Core\Repositories\Crud;

use Illuminate\Database\Eloquent\Model;
use Mth\Common\Core\Contracts\ICrudRepository;
use Mth\Common\Core\Repositories\BaseCrudRepository;
use Mth\Tenant\Adapters\Models\Role;

class RoleCrudRepository extends BaseCrudRepository implements ICrudRepository
{
    protected function getModel(): Model
    {
        return new Role();
    }

    public function instance(): Role
    {
        return (new Role);
    }
}
