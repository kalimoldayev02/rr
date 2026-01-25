<?php

declare(strict_types=1);

namespace App\Application\Mappers\User;

use App\Application\Enums\User\UserGenderEnum;
use App\Domain\Enums\User\UserGenderEnum as DomainAthleteGenderEnum;

final readonly class ApplicationUserGenderToDomainUserGenderMapper
{
    public function map(UserGenderEnum $gender): DomainAthleteGenderEnum
    {
        return match ($gender) {
            UserGenderEnum::male => DomainAthleteGenderEnum::male,
            UserGenderEnum::female => DomainAthleteGenderEnum::female,
        };
    }
}
