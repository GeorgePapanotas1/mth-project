<?php

namespace Mth\Tenant\Core\Services\Internal;

use Mth\Common\Core\Contracts\ICrudRepository;
use Mth\Common\Core\Services\Internal\AbstractCrudService;
use Mth\Tenant\Adapters\Models\Role;
use Mth\Tenant\Core\Dto\Forms\CreateRoleForm;
use Mth\Tenant\Core\Exceptions\Authorization\RoleCreationException;
use Mth\Tenant\Core\Repositories\Crud\RoleCrudRepository;

class RoleCrudService extends AbstractCrudService
{
    public function __construct(
        protected readonly RoleCrudRepository $crudRepository
    ) {

    }

    protected function repository(): ICrudRepository
    {
        return $this->crudRepository;
    }

    public function instance(): Role
    {
        return $this->crudRepository->instance();
    }

    /**
     * @throws RoleCreationException
     */
    public function createRole(
        CreateRoleForm $createRoleForm
    ): bool {
        try {
            $role = $this->instance()::make($createRoleForm->toDatabaseArray());

            return $role->saveOrFail();
        } catch (\Throwable $e) {
            throw new RoleCreationException($e->getMessage());
        }
    }
}
