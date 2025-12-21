<?php

declare(strict_types=1);

namespace App\Application\UseCases\Query\Auth\GetRegisterUrl;

use App\Domain\Services\Athlete\GetRegisterAthleteUrl\GetRegisterAthleteUrlServiceInterface;

final readonly class GetRegisterUrlQueryHandler
{
    public function __construct(
        private GetRegisterAthleteUrlServiceInterface $getRegisterUrlService,
    ) {}

    public function handle(): string
    {
        return $this->getRegisterUrlService->get();
    }
}
