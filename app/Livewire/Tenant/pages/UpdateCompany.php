<?php

namespace App\Livewire\Tenant\pages;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Mth\Common\Helpers\UuidHelper;
use Mth\Tenant\Core\Dto\Company\Forms\UpdateCompanyForm;
use Mth\Tenant\Core\Dto\Company\Projections\CompanyProjection;
use Mth\Tenant\Core\Exceptions\Authorization\UnauthorizedException;
use Mth\Tenant\Core\Services\CompanyService;
use Mth\Tenant\Core\Services\Internal\CompanyCrudService;

class UpdateCompany extends Component
{
    private readonly CompanyService $companyService;
    public string $name = '';
    public string $address = '';
    public string $id = '';
    protected $rules = [
        'name'    => 'required|min:3|max:255',
        'address' => 'required|min:3|max:255',
    ];

    public function boot(
        CompanyService $companyService
    ) {
        $this->companyService = $companyService;
    }

    public function mount(
        string $uuid
    ) {
        try {
            $company = $this->companyService->find(Auth::user(), UuidHelper::base62ToUuid($uuid));

            if (!$company) {
                abort(404);
            }

            $this->name    = $company->getName();
            $this->address = $company->getAddress();
            $this->id      = $company->getId();
        } catch (UnauthorizedException $e) {
            abort(401);
        } catch (\Throwable $t) {
            abort(404);
        }
    }

    public function save()
    {

        $this->validate();
        
        $updateForm = (new UpdateCompanyForm())
            ->setName($this->name)
            ->setAddress($this->address)
            ->setId(UuidHelper::base62ToUuid($this->id));

        try {
            $this->companyService->update(Auth::user(), $updateForm);

            return redirect()->back();
        } catch (UnauthorizedException $e) {
            abort(401, $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.tenant.update-company')->layout('layouts.app');
    }
}
