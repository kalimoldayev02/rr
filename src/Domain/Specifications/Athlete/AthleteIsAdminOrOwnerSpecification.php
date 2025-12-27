<?php

declare(strict_types=1);

namespace App\Domain\Specifications\Athlete;

use App\Domain\Entities\AthleteEntity;
use App\Domain\ValueObjects\AthleteRoleVO;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class AthleteIsAdminOrOwnerSpecification
{
    public function isSatisfiedBy(AthleteEntity $athleteEntity, UuidInterface $clubId): bool
    {
        $roles = [Uuid::fromString('019a5d19-c8fc-70e3-94b2-ebe38c951fcf'), Uuid::fromString('019a5798-3dce-72f8-9c27-f4f864489c02')];

        /** @var AthleteRoleVO $roleVO */
        foreach ($athleteEntity->getRoles()->toArray() as $roleVO) {
            if ($roleVO->getClubId()->equals($clubId) && \in_array($roleVO->getRoleId(), $roles, true)) {
                return true;
            }
        }

        return false;
    }
}
