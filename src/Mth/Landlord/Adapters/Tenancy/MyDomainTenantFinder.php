<?php

namespace Mth\Landlord\Adapters\Tenancy;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Mth\Common\Config\Facades\Config;
use Mth\Landlord\Core\Services\Internal\TenantCrudService;
use Spatie\Multitenancy\Models\Concerns\UsesTenantModel;
use Spatie\Multitenancy\Models\Tenant;
use Spatie\Multitenancy\TenantFinder\TenantFinder;

class MyDomainTenantFinder extends TenantFinder
{
    use UsesTenantModel;

    public function __construct(
        protected readonly TenantCrudService $tenantCrudService
    ) {

    }

    public function findForRequest(
        Request $request,
    ): ?Tenant {


        $host   = $request->getHost();
        $appUrl = Str::after(Config::config('app.url')->getValue(), '//');

        if ($host === $appUrl) {
            return null;
        }

        $hostParts = explode('.', $host);

        $domain = $hostParts[0];

        $tenant = $this->tenantCrudService->getTenantWithDomain($domain);

        if ($tenant) {
            return $tenant;
        }

        abort(404);
    }
}
