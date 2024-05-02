<?php

namespace App\Livewire\Tenant\components;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Mth\Tenant\Core\Exceptions\Authorization\UnauthorizedException;
use Mth\Tenant\Core\Services\CompanyService;

class CompaniesList extends Component
{
    public function render(
        CompanyService $companyService,
    ) {
        $user = Auth::user();

        try {

            return view('livewire.tenant.components.companies-list', [
                'companies' => $companyService->getCompanies($user)
            ]);
        } catch (UnauthorizedException $e) {
            abort(401);
        }
    }
}
