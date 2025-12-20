<?php

declare(strict_types=1);

namespace App\Application\Mappers\Athlete;

use App\Application\DTO\Athlete\AthleteDTO;
use App\Application\Mappers\User\DomainUserGenderToApplicationUserGenderMapper;
use App\Domain\Entities\AthleteEntity;

final readonly class AthleteEntityToAthleteDTOMapper
{
    public function __construct(
        private DomainUserGenderToApplicationUserGenderMapper $toApplicationUserGenderMapper,
    ) {}

    public function map(AthleteEntity $athleteEntity): AthleteDTO
    {
        return new AthleteDTO(
            id: $athleteEntity->getId(),
            firstName: $athleteEntity->getFirstName(),
            lastName: $athleteEntity->getLastName(),
            clubIds: $athleteEntity->getClubIds()->toArray(),
            email: $athleteEntity->getEmail()->getValue(),
            gender: $this->toApplicationUserGenderMapper->map($athleteEntity->getGender()),
            birthday: $athleteEntity->getBirthday(),
        );
    }
}
