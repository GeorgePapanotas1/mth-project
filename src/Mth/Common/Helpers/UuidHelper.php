<?php

namespace Mth\Common\Helpers;

use Ramsey\Uuid\Uuid;
use Tuupola\Base62;

class UuidHelper
{
    public static function uuidToBase62($uuidString): string
    {
        $uuid   = Uuid::fromString($uuidString);
        $binary = $uuid->getBytes();
        $base62 = new Base62();

        return $base62->encode($binary);
    }

    public static function base62ToUuid($base62String): string
    {
        $base62 = new Base62();
        $binary = $base62->decode($base62String);
        $uuid   = Uuid::fromBytes($binary);

        return $uuid->toString();
    }
}
