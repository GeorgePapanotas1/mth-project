<?php

namespace App\Livewire\Landlord;

use Livewire\Component;
use Mth\Landlord\Core\Services\TenancyService;

class TenantsList extends Component
{
    protected $paginationTheme = 'bootstrap';

    public function mount(): void
    {
    }

    public function render(TenancyService $tenancyService)
    {
        return view('livewire.landlord.tenants-list', [
            'tenants' => $tenancyService->getTenantsPaginated(10)
        ]);
    }
}
