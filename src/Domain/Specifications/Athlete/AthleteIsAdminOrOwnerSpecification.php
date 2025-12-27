<?php

declare(strict_types=1);

namespace App\Domain\Specifications\Athlete;

use App\Application\Enums\Access\RoleEnum;
use App\Domain\Entities\AthleteEntity;
use App\Domain\ValueObjects\AthleteRoleVO;
use Ramsey\Uuid\UuidInterface;

final readonly class AthleteIsAdminOrOwnerSpecification
{
    private const array ROLES = [RoleEnum::admin, RoleEnum::owner];

    // TODO
    public function isSatisfiedBy(AthleteEntity $athleteEntity, UuidInterface $clubId): bool
    {
        /** @var AthleteRoleVO $roleVO */
        foreach ($athleteEntity->getRoles()->toArray() as $roleVO) {
            if ($roleVO->getClubId()->equals($clubId) && \in_array($roleVO->getRoleId(), self::ROLES, true)) {
                return true;
            }
        }

        return false;
    }
}
