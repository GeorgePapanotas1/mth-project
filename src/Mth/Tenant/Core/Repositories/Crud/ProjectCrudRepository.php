<?php

namespace Mth\Tenant\Core\Repositories\Crud;

use Illuminate\Database\Eloquent\Model;
use Mth\Common\Core\Contracts\ICrudRepository;
use Mth\Common\Core\Repositories\BaseCrudRepository;
use Mth\Tenant\Adapters\Models\Project;

class ProjectCrudRepository extends BaseCrudRepository implements ICrudRepository
{
    protected function getModel(): Model
    {
        return new Project();
    }
}
