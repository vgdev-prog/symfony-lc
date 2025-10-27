<?php

declare(strict_types=1);

namespace App\Common\Domain\Event;

interface DomainEventDispatcherInterface
{
    public function dispatch(object $event): void;

    public function dispatchAll(array $events): void;
}
