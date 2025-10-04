<?php

declare(strict_types=1);

namespace App\Application\Mappers\Athlete;

use App\Application\Enums\User\UserGenderEnum;
use App\Domain\Enums\User\UserGenderEnum as DomainAthleteGenderEnum;

final readonly class ApplicationAthleteGenderToDomainAthleteGenderMapper
{
    public function map(UserGenderEnum $gender): DomainAthleteGenderEnum
    {
        return match ($gender) {
            UserGenderEnum::male => DomainAthleteGenderEnum::male,
            UserGenderEnum::female => DomainAthleteGenderEnum::female,
        };
    }
}
