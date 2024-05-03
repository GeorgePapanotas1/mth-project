<?php

namespace App\Livewire\Tenant\components;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Mth\Common\Helpers\UuidHelper;
use Mth\Tenant\Core\Exceptions\Authorization\UnauthorizedException;
use Mth\Tenant\Core\Services\CompanyService;

class CompaniesList extends Component
{
    private readonly CompanyService $companyService;

    public function boot(
        CompanyService $companyService
    ) {
        $this->companyService = $companyService;
    }

    public function delete(string $encodedId)
    {
        try {
            $this->companyService->delete(Auth::user(), UuidHelper::base62ToUuid($encodedId));
        } catch (UnauthorizedException $e) {
            abort(401);
        }
    }

    public function render(
        CompanyService $companyService,
    ) {
        $user = Auth::user();

        try {

            return view('livewire.tenant.components.companies-list', [
                'companies' => $this->companyService->getCompanies($user)
            ]);
        } catch (UnauthorizedException $e) {
            abort(401);
        }
    }
}
