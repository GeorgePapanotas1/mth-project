<?php

namespace Mth\Landlord\Core\Repositories\Custom;

use Illuminate\Support\Facades\DB;

class TenancyRepository
{
    public function createTenantDatabase(
        string $databaseName
    ): void {
        DB::statement("CREATE DATABASE $databaseName");
    }

    public function deleteTenantDatabase(
        string $databaseName
    ): void {
        DB::statement("DROP DATABASE $databaseName");
    }
}
