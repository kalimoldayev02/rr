<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\DTO\Athlete\AthleteExternalDataDTO;
use App\Domain\DTO\Club\ClubExternalDataDTO;

interface ExternalServiceInterface
{
    public function getAuthURL(): string;

    public function exchangeCode(string $code): AthleteExternalDataDTO;

    /**
     * @return ClubExternalDataDTO[]
     */
    public function getClubsByToken(string $accessToken): array;
}
