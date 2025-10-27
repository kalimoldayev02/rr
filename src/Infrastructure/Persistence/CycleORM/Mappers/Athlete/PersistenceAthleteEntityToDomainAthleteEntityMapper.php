<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Mappers\Athlete;

use App\Domain\Entities\AthleteEntity;
use App\Domain\Enums\User\UserGenderEnum;
use App\Domain\ValueObjects\EmailVO;
use App\Infrastructure\Persistence\CycleORM\Entities\AthleteCycleORMEntity;

final readonly class PersistenceAthleteEntityToDomainAthleteEntityMapper
{
    public function map(AthleteCycleORMEntity $persistenceAthleteEntity): AthleteEntity
    {
        $domainAthleteEntity = new AthleteEntity(
            id: $persistenceAthleteEntity->getId(),
            email: new EmailVO($persistenceAthleteEntity->getEmail()),
            externalId: $persistenceAthleteEntity->getMetadata()->getExternalId(),
            firstname: $persistenceAthleteEntity->getFirstName(),
            lastname: $persistenceAthleteEntity->getLastName(),
            gender: match ($persistenceAthleteEntity->getGender()) {
                UserGenderEnum::male->name => UserGenderEnum::male,
                UserGenderEnum::female->name => UserGenderEnum::female,
            },
            password: $persistenceAthleteEntity->getPassword(),
            birthday: $persistenceAthleteEntity->getBirthday(),
        );

        foreach ($persistenceAthleteEntity->getClubAthletes() as $clubAthleteEntity) {
            $domainAthleteEntity->getClubIds()->add($clubAthleteEntity->getClubId());
        }

        return $domainAthleteEntity;
    }
}
