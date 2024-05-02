<?php

namespace App\Livewire\Tenant\components;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Mth\Tenant\Core\Services\Authorization\AuthorizationService;
use Mth\Tenant\Core\Services\UserService;

class UserList extends Component
{
    public function render(
        UserService $userService,
        AuthorizationService $authorizationService
    ) {
        return view('livewire.tenant.components.user-list', [
            'users'   => $userService->getUsers(),
            'isAdmin' => $authorizationService->isAdmin(Auth::user())
        ]);
    }
}
