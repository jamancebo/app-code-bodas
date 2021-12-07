<?php

declare(strict_types=1);

namespace DevBodas\Shared\Infrastructure\Repository\Doctrine\CustomType;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

abstract class StringCustomType extends StringType
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return self::customTypeName();
    }

    /**
     * @param  string           $value
     * @param  AbstractPlatform $platform
     * @return mixed
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $this->typeClassName()::fromString($value);
    }

    /**
     * @return string
     */
    public static function customTypeName(): string
    {
        return (new \ReflectionClass(static::class))->getShortName();
    }

    /**
     * @return string
     */
    abstract protected function typeClassName(): string;
}
