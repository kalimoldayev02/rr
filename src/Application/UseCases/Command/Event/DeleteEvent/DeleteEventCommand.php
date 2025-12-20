<?php

declare(strict_types=1);

namespace App\Application\UseCases\Command\Event\DeleteEvent;

use Ramsey\Uuid\UuidInterface;

final readonly class DeleteEventCommand
{
    public function __construct(
        public UuidInterface $userId,
        public UuidInterface $eventId,
    ) {}
}
