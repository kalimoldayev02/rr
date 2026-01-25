<?php

declare(strict_types=1);

namespace App\Domain\Services\Activity\SyncActivities;

use App\Domain\Exceptions\Auth\InvalidTokenException;
use App\Domain\Exceptions\InfrastructureException;
use App\Domain\Exceptions\TooManyRequestsException;

interface GetActivitiesExternalServiceInterface
{
    /**
     * @return ActivityDTO[]
     * @throws TooManyRequestsException
     * @throws InfrastructureException
     * @throws InvalidTokenException
     * */
    public function get(string $accessToken, \DateTimeImmutable $fromDate): array;
}
