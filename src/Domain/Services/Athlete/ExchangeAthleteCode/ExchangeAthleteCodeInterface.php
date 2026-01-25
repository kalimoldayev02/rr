<?php

declare(strict_types=1);

namespace App\Domain\Services\Athlete\ExchangeAthleteCode;

use App\Domain\Exceptions\Auth\InvalidTokenException;
use App\Domain\Exceptions\InfrastructureException;
use App\Domain\Exceptions\TooManyRequestsException;

interface ExchangeAthleteCodeInterface
{
    /**
     * @throws InvalidTokenException
     * @throws TooManyRequestsException
     * @throws InfrastructureException
     */
    public function exchange(string $code): ExchangeAthleteDataDTO;
}
