<?php

namespace Mth\Tenant\Core\Services;

use Illuminate\Database\Eloquent\Model;
use Mth\Tenant\Adapters\Models\User;
use Mth\Tenant\Core\Dto\User\Forms\CreateUserForm;
use Mth\Tenant\Core\Dto\User\Forms\UpdateUserForm;
use Mth\Tenant\Core\Exceptions\Authorization\UnauthorizedException;
use Mth\Tenant\Core\Services\Authorization\AuthorizationService;
use Mth\Tenant\Core\Services\Internal\UserCrudService;

readonly class UserService
{
    public function __construct(
        protected UserCrudService $userCrudService,
        protected AuthorizationService $authorizationService
    ) {

    }

    /**
     * @throws UnauthorizedException
     */
    public function create(User $user, CreateUserForm $createUserForm): Model
    {
        if (!$this->authorizationService->isAdmin($user)) {
            throw new UnauthorizedException('Only admins can add users');
        }

        return $this->userCrudService->create($createUserForm->serialize());
    }

    /**
     * @throws UnauthorizedException
     */
    public function update(User $user, UpdateUserForm $updateUserForm): Model
    {
        if (!$this->authorizationService->isAdmin($user)) {
            throw new UnauthorizedException('Only admins can edit users');
        }

        return $this->userCrudService->update($updateUserForm->getId(), $updateUserForm->serialize());
    }

    /**
     * @throws UnauthorizedException
     */
    public function delete(User $user, string $userId): bool
    {
        if (!$this->authorizationService->isAdmin($user)) {
            throw new UnauthorizedException('Only admins can delete a user');
        }

        return $this->userCrudService->delete($userId);
    }

    public function getUsers(
        int $perPage = 15,
        int $page = 1
    ): array {
        return $this->userCrudService->paginate($perPage, ['*'], $page)->items();
    }
}
