<?php

declare(strict_types=1);

namespace App\Common\Domain\Exception;

class InvalidIdentifierException extends AbstractDomainException
{
    public function __construct()
    {
        $this->message = sprintf('Invalid UUID for %s', static::class);
    }

    public static function getDomainErrorCode(): string
    {
        return ErrorCode::INCORRECT_UUID->value;
    }

    final public static function getStatusCode(): int
    {
        return 400;
    }
}
