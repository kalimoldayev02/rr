<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Mappers\Athlete;

use App\Domain\Entities\AthleteEntity;
use App\Domain\Enums\User\UserGenderEnum;
use App\Domain\ValueObjects\IdVO;
use App\Infrastructure\Persistence\CycleORM\Entities\AthleteCycleORMEntity;

final readonly class PersistenceAthleteEntityToDomainAthleteEntityMapper
{
    public function map(AthleteCycleORMEntity $persistenceAthleteEntity): AthleteEntity
    {
        return new AthleteEntity(
            id: new IdVO($persistenceAthleteEntity->getId()),
            externalId: $persistenceAthleteEntity->getMetadata()->getExternalId(),
            firstname: $persistenceAthleteEntity->getFirstName(),
            lastname: $persistenceAthleteEntity->getLastName(),
            gender: match ($persistenceAthleteEntity->getGender()) {
                'male' => UserGenderEnum::male,
                'female' => UserGenderEnum::female,
            },
            birthday: $persistenceAthleteEntity->getBirthday(),
        );
    }
}
