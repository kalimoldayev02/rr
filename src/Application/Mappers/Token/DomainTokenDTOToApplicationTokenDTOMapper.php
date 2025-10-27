<?php

declare(strict_types=1);

namespace App\Application\Mappers\Token;

use App\Domain\DTO\Token\TokenDTO;
use App\Application\DTO\Token\TokenDTO as ApplicationTokenDTO;

final readonly class DomainTokenDTOToApplicationTokenDTOMapper
{
    public function map(TokenDTO $token): ApplicationTokenDTO
    {
        return new ApplicationTokenDTO(
            accessToken: $token->accessToken,
            refreshToken: $token->refreshToken,
        );
    }
}
