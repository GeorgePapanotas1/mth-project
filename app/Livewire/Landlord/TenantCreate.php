<?php

namespace App\Livewire\Landlord;

use Illuminate\Support\Str;
use Livewire\Component;
use Mth\Common\Constants\NamedRoutes;
use Mth\Landlord\Core\Dto\Forms\CreateTenantForm;
use Mth\Landlord\Core\Exceptions\Tenancy\GeneralTenantCreationException;
use Mth\Landlord\Core\Services\TenancyService;

class TenantCreate extends Component
{
    public $name = '';
    public $domain = '';
    public $header = 'Tenant Creation';
    protected $rules = [
        'name'   => 'required|min:3|max:255',
        'domain' => 'required|min:3|max:255|unique:tenants,domain',
    ];

    public function submit(
        TenancyService $tenancyService
    ) {

        $this->domain = strtolower(trim(preg_replace('/\s+/', '', $this->domain)));

        $this->validate();

        $tenantForm = (new CreateTenantForm())
            ->setName($this->name)
            ->setDomain(Str::lower($this->domain));
        try {
            $tenancyService->createTenant($tenantForm);

            return redirect()->route(NamedRoutes::DASHBOARD);
        } catch (GeneralTenantCreationException $e) {
            return redirect()->back()->withErrors('Tenant could not be created. Try again later');
        }
    }

    public function render()
    {
        return view('livewire.landlord.tenant-create')->layout('layouts.app');
    }
}
