<?php

namespace Mth\Common\Core\Utils;

use Mth\Common\Core\Facades\Arrayable;

abstract class ArraySerializable implements IArraySerializable
{
    abstract public function serialize(): array;

    public function toCleanArray(string $dateFormat = 'm/d/Y H:i:s', array $except = []): array
    {
        return Arrayable::toArrayClean($this, $dateFormat, $except);
    }

    public function toFullArray(string $dateFormat = 'm/d/Y H:i:s', array $except = []): array
    {
        return Arrayable::toArrayFull($this, $dateFormat, $except);
    }

    public function toDatabaseArray(string $dateFormat = 'Y-m-d H:i:s', array $except = []): array
    {
        return Arrayable::toDatabaseArray($this, $dateFormat, $except);
    }
}
