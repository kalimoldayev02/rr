<?php

declare(strict_types=1);

namespace App\Application\UseCases\Query\Athlete\GetAuthURL;

use App\Domain\Services\ExternalServiceInterface;

final readonly class GetAuthURLQueryHandler
{
    public function __construct(
        private ExternalServiceInterface $getAuthURLService,
    ) {}

    public function handle(): string
    {
        return $this->getAuthURLService->getAuthURL();
    }
}
