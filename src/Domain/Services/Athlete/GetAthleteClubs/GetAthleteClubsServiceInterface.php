<?php

declare(strict_types=1);

namespace App\Domain\Services\Athlete\GetAthleteClubs;

interface GetAthleteClubsServiceInterface
{
    /**
     * @return ClubDTO[]
     */
    public function get(string $athleteAccessToken): array;
}
