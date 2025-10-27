<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Events;

use App\Common\Domain\Event\DomainEventDispatcherInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

final readonly class DomainEventDispatcher implements DomainEventDispatcherInterface
{
    public function __construct(
        private EventDispatcherInterface $eventDispatcher,
    )
    {
    }

    public function dispatch(object $event): void
    {
        $this->eventDispatcher->dispatch($event);
    }

    public function dispatchAll(array $events): void
    {
        if (empty($events)) {
            return;
        }

        foreach ($events as $event) {
            $this->dispatch($event);
        }
    }
}
