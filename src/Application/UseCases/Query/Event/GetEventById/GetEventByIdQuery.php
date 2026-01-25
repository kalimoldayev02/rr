<?php

declare(strict_types=1);

namespace App\Application\UseCases\Query\Event\GetEventById;

use Ramsey\Uuid\UuidInterface;

final readonly class GetEventByIdQuery
{
    public function __construct(
        public UuidInterface $userId,
        public UuidInterface $id,
    ) {}
}
