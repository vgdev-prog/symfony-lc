<?php

declare(strict_types=1);

namespace App\Common\Domain\ValueObject;




use App\Common\Domain\Exception\InvalidIdentifierException;
use Symfony\Component\Uid\Uuid;

abstract readonly class Id
{
    protected function __construct(
        private string $value,
    )
    {
        if (!Uuid::isValid($value)) {
            throw new InvalidIdentifierException();
        }

    }

    public static function generate(): static
    {
        return new static(Uuid::v7()->toRfc4122());
    }

    public static function fromString(string $id): static
    {
        return new static($id);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

}
