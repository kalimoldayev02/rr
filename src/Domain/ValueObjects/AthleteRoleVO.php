<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

use Ramsey\Uuid\UuidInterface;

final readonly class AthleteRoleVO
{
    public function __construct(
        private UuidInterface $clubId,
        private UuidInterface $roleId,
    ) {}

    public function getClubId(): UuidInterface
    {
        return $this->clubId;
    }

    public function getRoleId(): UuidInterface
    {
        return $this->roleId;
    }
}
