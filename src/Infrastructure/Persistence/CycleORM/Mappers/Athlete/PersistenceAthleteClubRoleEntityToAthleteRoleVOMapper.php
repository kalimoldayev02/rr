<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Mappers\Athlete;

use App\Domain\ValueObjects\AthleteRoleVO;
use App\Infrastructure\Persistence\CycleORM\Entities\AthleteClubRolesCycleORMEntity;

final readonly class PersistenceAthleteClubRoleEntityToAthleteRoleVOMapper
{
    public function map(AthleteClubRolesCycleORMEntity $persistenceAthleteClubRoleEntity): AthleteRoleVO
    {
        return new AthleteRoleVO(
            clubId: $persistenceAthleteClubRoleEntity->getClubId(),
            roleId: $persistenceAthleteClubRoleEntity->getRoleId(),
        );
    }
}
