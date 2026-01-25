<?php

declare(strict_types=1);

namespace App\Application\Services\Access;

use App\Domain\Entities\AthleteEntity;
use App\Domain\Specifications\Athlete\AthleteIsAdminOrOwnerSpecification;
use Ramsey\Uuid\UuidInterface;

final readonly class AccessService
{
    public function __construct(
        private AthleteIsAdminOrOwnerSpecification $adminOrOwnerSpecification,
    ) {}

    public function can(AthleteEntity $athleteEntity, UuidInterface $clubId): bool
    {
        return $this->adminOrOwnerSpecification->isSatisfiedBy($athleteEntity, $clubId);
    }
}
