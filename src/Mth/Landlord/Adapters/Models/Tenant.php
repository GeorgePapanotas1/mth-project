<?php

namespace Mth\Landlord\Adapters\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;
use Spatie\Multitenancy\Models\Tenant as SpatieTenant;

class Tenant extends SpatieTenant
{
    use UsesLandlordConnection;
    use HasFactory;
    use HasUuids;

    public function makeCurrent(): static
    {
        $makeCurrent = parent::makeCurrent();

        DB::setDefaultConnection('tenant');

        return $makeCurrent;
    }

    public static function forgetCurrent(): ?Tenant
    {
        $tenant = static::current();
        parent::forgetCurrent();
        DB::setDefaultConnection('landlord');

        return $tenant;
    }

    protected $keyType = 'string';
    protected $guarded = ['id'];
}
