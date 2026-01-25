<?php

declare(strict_types=1);

namespace App\Domain\Services\Athlete\GetRegisterAthleteUrl;

interface GetRegisterAthleteUrlServiceInterface
{
    public function get(): string;
}
