<?php

declare(strict_types=1);

namespace App\Common\Domain\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final readonly class EntityType
{
    public function __construct(public string $type)
    {
    }

}
