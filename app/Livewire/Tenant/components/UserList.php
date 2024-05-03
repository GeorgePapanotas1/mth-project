<?php

namespace App\Livewire\Tenant\components;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Mth\Common\Helpers\UuidHelper;
use Mth\Tenant\Core\Exceptions\Authorization\UnauthorizedException;
use Mth\Tenant\Core\Services\Authorization\AuthorizationService;
use Mth\Tenant\Core\Services\UserService;

class UserList extends Component
{
    protected readonly UserService $userService;
    protected readonly AuthorizationService $authorizationService;

    public function boot(
        UserService $userService,
        AuthorizationService $authorizationService
    ) {
        $this->authorizationService = $authorizationService;
        $this->userService          = $userService;
    }

    public function delete(string $encodedId)
    {
        try {
            $this->userService->delete(Auth::user(), UuidHelper::base62ToUuid($encodedId));
        } catch (UnauthorizedException $e) {
            abort(401);
        }
    }

    public function render()
    {
        return view('livewire.tenant.components.user-list', [
            'users'         => $this->userService->getUsers(),
            'isAdmin'       => $this->authorizationService->isAdmin(Auth::user()),
            'currentUserId' => UuidHelper::uuidToBase62(Auth::user()->id)
        ]);
    }
}
