<?php

declare(strict_types=1);

namespace App\Application\Mappers\User;

use App\Application\Enums\User\UserGenderEnum as ApplicationUserGenderEnum;
use App\Domain\Enums\User\UserGenderEnum;

final readonly class DomainUserGenderToApplicationUserGenderMapper
{
    public function map(UserGenderEnum $gender): ApplicationUserGenderEnum
    {
        return match ($gender) {
            UserGenderEnum::male => ApplicationUserGenderEnum::male,
            UserGenderEnum::female => ApplicationUserGenderEnum::female,
        };
    }
}
