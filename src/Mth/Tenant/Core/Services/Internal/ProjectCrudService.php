<?php

namespace Mth\Tenant\Core\Services\Internal;

use Mth\Common\Core\Contracts\ICrudRepository;
use Mth\Common\Core\Services\Internal\AbstractCrudService;
use Mth\Tenant\Core\Repositories\Crud\ProjectCrudRepository;

class ProjectCrudService extends AbstractCrudService
{

    public function __construct(
        protected readonly ProjectCrudRepository $projectCrudRepository
    )
    {

    }
    protected function repository(): ICrudRepository
    {
        return $this->projectCrudRepository;
    }

}
