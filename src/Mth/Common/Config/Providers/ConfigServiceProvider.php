<?php

namespace Mth\Common\Config\Providers;

use Carbon\Laravel\ServiceProvider;
use Mth\Common\Config\Contracts\IConfigService;
use Mth\Common\Config\Services\ConfigService;

class ConfigServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(IConfigService::class, ConfigService::class);
    }
}
