<?php

declare(strict_types=1);

namespace App\Application\UseCases\Query\Activity\GetActivityById;

use Ramsey\Uuid\UuidInterface;

final readonly class GetActivityByIdQuery
{
    public function __construct(
        public UuidInterface $id,
    ) {}
}
