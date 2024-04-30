<?php

namespace Mth\Common\Config\Facades;

use Mth\Common\Config\Dto\Config as ConfigDTO;
use Mth\Common\Config\Services\ConfigService;
use Mth\Common\Container\Facades\Container;

class Config
{
    private const APP_ENV = 'app.env';

    private static function configService(): ConfigService
    {
        return Container::get(ConfigService::class);
    }

    public static function isProduction(): bool
    {
        return self::configService()->config(self::APP_ENV)->getValue() === 'production';
    }

    public static function isLocal(): bool
    {
        return self::configService()->config(self::APP_ENV)->getValue() === 'local';
    }

    public static function isStaging(): bool
    {
        return self::configService()->config(self::APP_ENV)->getValue() === 'staging';
    }

    public static function isCI(): bool
    {
        return self::configService()->config(self::APP_ENV)->getValue() === 'ci';
    }

    public static function config(string $key): ConfigDTO
    {
        return self::configService()->config($key);
    }
}
