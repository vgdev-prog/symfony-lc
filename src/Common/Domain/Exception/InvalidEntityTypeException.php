<?php

declare(strict_types=1);

namespace App\Common\Domain\Exception;

class InvalidEntityTypeException extends AbstractDomainException
{

    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function entityTypeNotFound(string $type): static
    {
        return new static(
            sprintf('Type "%s" is not registered in entity type mapping', $type)
        );
    }

    public static function entityClassNotFound(string $class): static
    {
        return new static(
            sprintf('Class "%s" is not registered in entity type mapping', $class)
        );
    }

    public static function getDomainErrorCode(): string
    {
        return ErrorCode::INCORRECT_ENTITY_TYPE->value;
    }

}
