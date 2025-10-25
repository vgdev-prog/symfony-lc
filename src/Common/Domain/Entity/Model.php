<?php

declare(strict_types=1);

namespace App\Common\Domain\Entity;


/**
 * Base class for all domain entities.
 *
 * Provides domain event management functionality following DDD principles.
 * Domain events represent important business occurrences that have happened in the domain.
 */
abstract class Model
{

    /**
     * Collection of domain events that occurred in entities.
     *
     * @var array<int, object>
     */
    protected array $domainEvents = [];

    /**
     * Records a single domain event.
     *
     * Domain events should be recorded when important business actions occur
     * (e.g., PostPublished, UserRegistered, OrderPlaced).
     *
     * @param object $event The domain event to record
     * @return void
     */
    protected function recordEvent(object $event): void
    {
        $this->domainEvents[] = $event;
    }

    /**
     * Records multiple domain events at once.
     *
     * @param array<int, object> $events Array of domain events to record
     * @return void
     */
    protected function recordEvents(array $events): void
    {
        foreach ($events as $event) {
            $this->recordEvent($event);
        }
    }

    /**
     * Retrieves all recorded domain events and clears the collection.
     *
     * This method is typically called by an event dispatcher after persisting
     * the entity to ensure events are published exactly once.
     *
     * @return array<int, object> All recorded domain events
     */
    public function pullDomainEvents(): array
    {
        $events = $this->domainEvents;
        $this->domainEvents = [];
        return $events;
    }

    /**
     * Returns all recorded domain events without clearing them.
     *
     * @return array<int, object> Current domain events
     */
    public function domainEvents(): array
    {
        return $this->domainEvents;
    }

    /**
     * Returns the number of recorded domain events.
     *
     * @return int Count of domain events
     */
    public function domainEventsCount(): int
    {
        return count($this->domainEvents);
    }

    /**
     * Clears all recorded domain events without returning them.
     *
     * @return void
     */
    public function clearDomainEvents(): void
    {
        $this->domainEvents = [];
    }
}
