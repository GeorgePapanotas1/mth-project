<?php

namespace Mth\Common\Config\Services;

use Mth\Common\Config\Contracts\IConfigService;
use Mth\Common\Config\Dto\Config;

class ConfigService implements IConfigService
{
    public function config(string $config): Config
    {
        return (new Config())
            ->setValue(config($config));
    }
}
