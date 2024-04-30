<?php

namespace Mth\Tenant\Core\Services\Authorization;

use Mth\Tenant\Adapters\Models\User;
use Mth\Tenant\Core\Dto\Forms\CreateRoleForm;
use Mth\Tenant\Core\Exceptions\Authorization\RoleCreationException;
use Mth\Tenant\Core\Services\Internal\RoleCrudService;

class AuthorizationService
{
    public function __construct(
        protected readonly RoleCrudService $roleCrudService
    ) {

    }

    /**
     * @param CreateRoleForm $createRoleForm
     * @return bool
     * @throws RoleCreationException
     */
    public function createRole(CreateRoleForm $createRoleForm): bool
    {
        return $this->roleCrudService->createRole($createRoleForm);
    }

    /**
     * @param User   $user
     * @param string $roleName
     * @return bool
     */
    public function userHasRole(
        User $user,
        string $roleName
    ): bool {
        return $user->hasRole($roleName);
    }

    /**
     * @param User     $user
     * @param string[] $roleNames
     * @return bool
     */
    public function userHasRoles(
        User $user,
        array $roleNames
    ): bool {
        return $user->hasRole($roleNames);
    }

    /**
     * @param User     $user
     * @param string[] $roleNames
     * @return bool
     */
    public function userHasAnyRole(
        User $user,
        array $roleNames
    ): bool {
        return $user->hasAnyRole($roleNames);
    }

    /**
     * @param User   $user
     * @param string $roleName
     * @return User
     */
    public function assignRole(
        User $user,
        string $roleName
    ): User {
        return $user->assignRole($roleName);
    }
}
