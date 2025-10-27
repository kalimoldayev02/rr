<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Mappers\Token;

use App\Application\DTO\Token\TokenDTO;
use App\Endpoint\Http\Responses\Token\TokenResponse;

final readonly class TokenDTOToTokenResponseMapper
{
    public function map(TokenDTO $token): TokenResponse
    {
        return new TokenResponse(
            accessToken: $token->accessToken,
            refreshToken: $token->refreshToken,
        );
    }
}
