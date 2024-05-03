<?php

namespace Mth\Tenant\Core\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Mth\Common\Constants\NamedRoutes;
use Mth\Common\Helpers\UuidHelper;
use Mth\Tenant\Adapters\Models\User;
use Mth\Tenant\Core\Dto\User\Forms\CreateUserForm;
use Mth\Tenant\Core\Dto\User\Forms\UpdateUserForm;
use Mth\Tenant\Core\Dto\User\Projections\UserProjection;
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

    public function find(string $userId): ?UserProjection
    {
        /* @var User|null $user */
        $user = $this->userCrudService->find($userId);

        return $user ? (new UserProjection())
            ->setName($user->name)
            ->setEmail($user->email)
            ->setId(UuidHelper::uuidToBase62($user->id))
            ->setRole($this->authorizationService->getUserRole($user)) : null;
    }

    public function getUsers(
        int $perPage = 15,
        ?int $page = null
    ): LengthAwarePaginator {
        $users = $this->userCrudService->paginate($perPage, ['*'], 'page', $page);

        $projections = array_map(function (User $user) {
            return (new UserProjection())
                ->setId(UuidHelper::uuidToBase62($user->id))
                ->setName($user->name)
                ->setEmail($user->email)
                ->setRole($this->authorizationService->getUserRole($user))
                ->setIsAdmin($this->authorizationService->isAdmin($user));
        }, $users->items());

        return new LengthAwarePaginator($projections, $users->total(), $perPage, $page, ['path' => url(NamedRoutes::USERS)]);
    }
}
