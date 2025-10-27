<?php

declare(strict_types=1);

namespace App\Blog\Domain\Event;

use App\Blog\Domain\ValueObject\Post\PostId;
use App\Common\Domain\Event\DomainEvent;

readonly final class PostPublished extends DomainEvent
{
    public function __construct(public PostId $id)
    {
    }


}
