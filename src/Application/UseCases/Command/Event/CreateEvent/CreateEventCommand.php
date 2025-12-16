<?php

declare(strict_types=1);

namespace App\Application\UseCases\Command\Event\CreateEvent;

use Ramsey\Uuid\UuidInterface;

final readonly class CreateEventCommand
{
    public function __construct(
        public UuidInterface $userId,
        public UuidInterface $clubId,
        public string $title,
        public \DateTimeImmutable $date,
    ) {}
}
