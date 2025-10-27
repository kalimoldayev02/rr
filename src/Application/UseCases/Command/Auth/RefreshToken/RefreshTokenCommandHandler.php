<?php

declare(strict_types=1);

namespace App\Application\UseCases\Command\Auth\RefreshToken;

use App\Application\DTO\Token\TokenDTO;
use App\Application\Mappers\Token\DomainTokenDTOToApplicationTokenDTOMapper;
use App\Domain\Services\Token\RefreshToken\RefreshTokenService;

final readonly class RefreshTokenCommandHandler
{
    public function __construct(
        private RefreshTokenService $refreshTokenService,
        private DomainTokenDTOToApplicationTokenDTOMapper $toApplicationTokenDTOMapper,
    ) {}

    public function handle(RefreshTokenCommand $command): TokenDTO
    {
        $data = $this->refreshTokenService->refresh($command->refreshToken);

        return $this->toApplicationTokenDTOMapper->map($data);
    }
}
