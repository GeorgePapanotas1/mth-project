<?php

namespace App\Livewire\Tenant\components;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Mth\Tenant\Core\Services\Authorization\AuthorizationService;

class TenantMenuActions extends Component
{
    public bool $isAdmin = false;

    public function mount(
        AuthorizationService $authorizationService
    ) {
        $this->isAdmin = $authorizationService->isAdmin(Auth::user());
    }

    public function render()
    {
        return view('livewire.tenant.menu.tenant-menu-actions');
    }
}
