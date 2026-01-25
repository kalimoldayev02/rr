<?php

declare(strict_types=1);

namespace App\Application\DTO\Event;

use Ramsey\Uuid\UuidInterface;

final readonly class EventDTO
{
    public function __construct(
        public UuidInterface $id,
        public UuidInterface $clubId,
        public \DateTimeImmutable $date,
        public string $title,
        public array $results,
    ) {}
}
