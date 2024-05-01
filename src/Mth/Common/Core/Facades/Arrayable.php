<?php

namespace Mth\Common\Core\Facades;

use Carbon\Carbon;
use ReflectionClass;
use Illuminate\Support\Str;
use Traversable;
use UnitEnum;

class Arrayable
{
    /**
     * Converts an object's properties to an array, excluding any properties that are null.
     *
     * @param object $object The object to convert to an array.
     * @return array An associative array of the object's properties, excluding nulls.
     */
    public static function toArrayClean(object $object, string $dateFormat = 'Y-m-d H:i:s', array $except = []): array
    {
        return self::toArray($object, false, $dateFormat);
    }

    /**
     * Converts an object's properties to an array, including all properties even if they are null.
     *
     * @param object $object The object to convert to an array.
     * @return array An associative array of the object's properties, including nulls.
     */
    public static function toArrayFull(object $object, string $dateFormat = 'Y-m-d H:i:s', array $except = []): array
    {
        return self::toArray($object, true, $dateFormat, false, $except);
    }

    public static function toDatabaseArray(object $object, $dateFormat = 'Y-m-d H:i:s', array $except = []): array
    {
        return self::toArray($object, false, $dateFormat, true, $except);
    }

    /**
     * Internal method to handle the conversion of an object's properties to an array.
     *
     * @param object $object       The object to convert to an array.
     * @param bool   $includeNulls Whether to include null values in the resulting array.
     * @return array An associative array of the object's properties.
     */
    public static function toArray(
        object $object,
        bool $includeNulls,
        string $dateFormat,
        bool $useSnakeCase = false,
        array $except = []
    ): array {
        $reflect = new ReflectionClass($object);
        $props   = $reflect->getProperties();

        $result = [];
        foreach ($props as $prop) {

            if (in_array($prop->getName(), $except)) {
                continue;
            }

            $prop->setAccessible(true);

            if (!$prop->isInitialized($object)) {
                if ($includeNulls) {
                    $result[self::getPropName($prop->getName(), $useSnakeCase)] = null;
                }
                continue;
            }

            $value = $prop->getValue($object);

            if ($value instanceof UnitEnum) {
                $value = $value->value;
            }

            if ($value instanceof Carbon) {
                $value = $value->format($dateFormat);
            }

            if (is_array($value) || $value instanceof Traversable) {
                foreach ($value as &$item) {
                    if (is_object($item)) {
                        $item = self::toArray($item, $includeNulls, $dateFormat);
                    }
                }
                unset($item);
            }

            if ($includeNulls || $value !== null) {
                $result[self::getPropName($prop->getName(), $useSnakeCase)] = $value;
            }
        }

        return $result;
    }

    private static function getPropName(string $input, bool $forceSnakeCase): string
    {
        if (!$forceSnakeCase) {
            return $input;
        }

        return Str::snake($input);
    }
}
