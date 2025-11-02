<?php

declare(strict_types=1);

namespace App\Domain\Services\Athlete\ExchangeAthleteCode;

interface ExchangeAthleteCodeInterface
{
    public function exchange(string $code): ExchangeAthleteDataDTO;
}
