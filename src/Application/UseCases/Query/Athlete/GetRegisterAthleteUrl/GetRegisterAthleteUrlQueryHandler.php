<?php

declare(strict_types=1);

namespace App\Application\UseCases\Query\Athlete\GetRegisterAthleteUrl;

use App\Domain\Services\Athlete\GetRegisterAthleteUrl\GetRegisterAthleteUrlServiceInterface;

final readonly class GetRegisterAthleteUrlQueryHandler
{
    public function __construct(
        private GetRegisterAthleteUrlServiceInterface $getRegisterUrlService,
    ) {}

    public function handle(): string
    {
        return $this->getRegisterUrlService->get();
    }
}
