<?php

namespace Mth\Tenant\Core\Services\Internal;

use Mth\Common\Core\Contracts\ICrudRepository;
use Mth\Common\Core\Services\Internal\AbstractCrudService;
use Mth\Tenant\Core\Repositories\Crud\UserCrudRepository;

class UserCrudService extends AbstractCrudService
{
    public function __construct(
        protected readonly UserCrudRepository $userCrudRepository
    )
    {

    }

    protected function repository(): ICrudRepository
    {
        return $this->userCrudRepository;
    }
}
