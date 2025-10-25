<?php

declare(strict_types=1);

namespace App\Common\Domain\ValueObject;

class Undefined
{
    public static function equalsTo(mixed $value): bool
    {
        return $value instanceof self;
    }

}
