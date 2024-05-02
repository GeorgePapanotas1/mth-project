<?php

namespace Mth\Landlord\Adapters\Tenancy;

use Illuminate\Http\Request;
use Spatie\Multitenancy\Models\Concerns\UsesTenantModel;
use Spatie\Multitenancy\Models\Tenant;
use Spatie\Multitenancy\TenantFinder\TenantFinder;

class MyDomainTenantFinder extends TenantFinder
{
    use UsesTenantModel;

    public function findForRequest(Request $request): ?Tenant
    {

        $host = $request->getHost();

        $domain = explode('.', $host)[0];

        $tenant = $this->getTenantModel()::whereDomain($domain)->first();

        if ($tenant) {
            return $tenant;
        }

        return null;
    }
}
