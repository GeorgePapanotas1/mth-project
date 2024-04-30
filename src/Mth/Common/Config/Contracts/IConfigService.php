<?php

namespace Mth\Common\Config\Contracts;

use Mth\Common\Config\Dto\Config;

interface IConfigService
{
    public function config(string $config): Config;
}
