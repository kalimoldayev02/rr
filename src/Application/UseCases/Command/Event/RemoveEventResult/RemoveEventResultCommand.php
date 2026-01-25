<?php

declare(strict_types=1);

namespace App\Application\UseCases\Command\Event\RemoveEventResult;

use Ramsey\Uuid\UuidInterface;

final readonly class RemoveEventResultCommand
{
    public function __construct(
        public UuidInterface $eventId,
        public UuidInterface $eventResultId,
        public UuidInterface $athleteId,
    ) {}
}
