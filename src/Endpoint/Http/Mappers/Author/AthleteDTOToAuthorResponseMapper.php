<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Mappers\Author;

use App\Application\DTO\Athlete\AthleteDTO;
use App\Endpoint\Http\Responses\Author\AuthorResponse;

final readonly class AthleteDTOToAuthorResponseMapper
{
    public function map(AthleteDTO $athlete): AuthorResponse
    {
        return new AuthorResponse(
            id: $athlete->id,
            firstName: $athlete->firstName,
            lastName: $athlete->lastName,
            clubIds: $athlete->clubIds,
        );
    }
}
