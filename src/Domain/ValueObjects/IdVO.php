<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class IdVO
{
    public function __construct(
        private ?UuidInterface $id = null,
    ) {
        if (\is_null($this->id)) {
            $this->id = Uuid::uuid7();
        }
    }

    public function getValue(): UuidInterface
    {
        return $this->id;
    }
}
