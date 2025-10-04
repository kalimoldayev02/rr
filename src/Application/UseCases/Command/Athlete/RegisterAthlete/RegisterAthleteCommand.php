<?php

declare(strict_types=1);

namespace App\Application\UseCases\Command\Athlete\RegisterAthlete;

final readonly class RegisterAthleteCommand
{
    public function __construct(
        public string $code,
        public string $state,
    ) {}
}
