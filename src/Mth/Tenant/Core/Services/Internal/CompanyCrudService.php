<?php

namespace Mth\Tenant\Core\Services\Internal;

use Mth\Common\Core\Contracts\ICrudRepository;
use Mth\Common\Core\Services\Internal\AbstractCrudService;
use Mth\Tenant\Core\Repositories\Crud\CompanyCrudRepository;

class CompanyCrudService extends AbstractCrudService
{
    public function __construct(
        protected readonly CompanyCrudRepository $companyCrudRepository
    ) {

    }

    protected function repository(): ICrudRepository
    {
        return $this->companyCrudRepository;
    }
}
