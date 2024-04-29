<?php

namespace Mth\Landlord\Adapters\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;
use Spatie\Multitenancy\Models\Tenant as SpatieTenant;

class Tenant extends SpatieTenant
{
    use UsesLandlordConnection;
    use HasFactory;
    use HasUuids;
    protected $keyType = 'string';

    protected $guarded = ['id'];
}
