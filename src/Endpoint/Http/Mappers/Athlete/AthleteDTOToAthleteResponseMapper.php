<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Mappers\Athlete;

use App\Application\DTO\Athlete\AthleteDTO;
use App\Endpoint\Http\Responses\Athlete\AthleteResponse;

final readonly class AthleteDTOToAthleteResponseMapper
{
    public function map(AthleteDTO $athlete): AthleteResponse
    {
        return new AthleteResponse(
            id: $athlete->id,
            firstName: $athlete->firstName,
            lastName: $athlete->lastName,
            clubIds: $athlete->clubIds,
        );
    }
}
