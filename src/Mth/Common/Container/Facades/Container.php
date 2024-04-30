<?php

namespace Mth\Common\Container\Facades;

class Container
{
    public static function get(
        ?string $abstract = null,
        array $parameters = []
    ): mixed {
        return app($abstract, $parameters);
    }
}
