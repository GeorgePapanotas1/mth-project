<?php

namespace App\Livewire\Tenant\pages;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Mth\Common\Constants\NamedRoutes;
use Mth\Tenant\Core\Dto\Company\Forms\CreateCompanyForm;
use Mth\Tenant\Core\Exceptions\Authorization\UnauthorizedException;
use Mth\Tenant\Core\Services\CompanyService;

class CreateCompany extends Component
{
    public $name = '';
    public $address = '';
    public $header = 'Create new company';
    protected $rules = [
        'name'    => 'required|min:3|max:255',
        'address' => 'required|min:3|max:255',
    ];

    public function submit(
        CompanyService $companyService
    ) {
        $this->validate();

        $companyForm = (new CreateCompanyForm())
            ->setName($this->name)
            ->setAddress($this->address);

        try {
            $companyService->create(Auth::user(), $companyForm);

            return redirect()->route(NamedRoutes::COMPANIES);
        } catch (UnauthorizedException $e) {
            abort(401);
        }
    }

    public function render()
    {
        return view('livewire.tenant.create-company')->layout('layouts.app');
    }
}
