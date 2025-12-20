<?php

declare(strict_types=1);

namespace App\Application\UseCases\Command\Event\UpdateEvent;

use Ramsey\Uuid\UuidInterface;

final readonly class UpdateEventCommand
{
    public function __construct(
        public UuidInterface $userId,
        public UuidInterface $eventId,
        public UuidInterface $clubId,
        public string $title,
        public \DateTimeImmutable $date,
    ) {}
}
