<?php

namespace App\Livewire;

use Livewire\Component;
use Mth\Landlord\Adapters\Models\Tenant;
use Mth\Tenant\Core\Services\Authorization\AuthorizationService;

class Dashboard extends Component
{
    public function render()
    {
        $isTenant = Tenant::current();

        $view = $isTenant ? view('livewire.tenant.dashboard') : view('livewire.landlord.dashboard');

        return $view->layout('layouts.app');
    }
}
