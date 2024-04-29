<?php

namespace Tests\Helpers;

use Illuminate\Database\Eloquent\Model;

class TestSuite
{

    public static function refreshDatabaseAsTenant(): void
    {
        shell_exec('php artisan migrate:fresh --env=testing --path=database/migrations/tenant');

    }

    public static function refreshDatabaseAsLandlord(): void
    {
        shell_exec('php artisan migrate:fresh --env=testing --path=database/migrations/landlord');
    }

    public static function cleanDatabase(): void
    {
        shell_exec('php artisan migrate:fresh --env=testing');
    }

    public static function cleanupTable(Model $model): void
    {
        $model->truncate();
    }
}
