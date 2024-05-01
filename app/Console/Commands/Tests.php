<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mth\Landlord\Adapters\Models\Tenant;
use Mth\Landlord\Core\Services\Internal\TenantCrudService;
use Mth\Tenant\Adapters\Models\User;
use Mth\Tenant\Core\Dto\Company\Forms\CreateCompanyForm;
use Mth\Tenant\Core\Dto\User\Forms\CreateUserForm;
use Mth\Tenant\Core\Services\CompanyService;
use Mth\Tenant\Core\Services\UserService;

class Tests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:tests';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(
        TenantCrudService $tenantCrudService,
        CompanyService $companyService,
        UserService $userService
    ) {
        /* @var Tenant $tenant */
        $tenant = $tenantCrudService->find('9bef3964-48bf-4f37-99cd-6c668dccb783');

        $tenant->makeCurrent();

// CRUD for companies, only users with role admin have access

        // A request comes through to show companies

//        $createDto = (new CreateCompanyForm())
//            ->setName('Facebook')
//            ->setAddress('Random address');
//
//        $createUserDTO = (new CreateUserForm())
//            ->setName('EGO')
//            ->setEmail('ego@ego.gr')
//            ->setPassword('heheheheheh');
//
//        $company = $companyService->create($createDto);
//
//        $user = $userService->create($createUserDTO);

//        $companyService->associateUser($company, [$user->id]);

        dd($companyService->getCompaniesOfUser(User::first(), 15, 1));

        $tenant->forgetCurrent();
    }
}
