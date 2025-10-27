<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Controllers\Athlete;

use App\Application\UseCases\Command\Auth\RefreshToken\RefreshTokenCommand;
use App\Application\UseCases\Command\Auth\RefreshToken\RefreshTokenCommandHandler;
use App\Endpoint\Http\Mappers\Token\TokenDTOToTokenResponseMapper;
use App\Endpoint\Http\Requests\Auth\RefreshTokenRequest;
use App\Endpoint\Http\Responses\Token\TokenResponse;
use OpenApi\Attributes as OA;
use RR\OpenApi as ROA;
use Spiral\Router\Annotation\Route;

#[OA\Post(path: '/api/athlete/auth/refresh', tags: ['auth'])]
#[OA\RequestBody(content: new OA\JsonContent(ref: RefreshTokenRequest::class))]
#[ROA\SuccessfulResponse(content: new OA\JsonContent(ref: TokenResponse::class))]
#[ROA\NotFoundResponse]
#[ROA\UnauthorizedResponse]
#[ROA\ValidationErrorResponse]
final class RefreshTokenAction
{
    #[Route(route: '/api/athlete/auth/refresh', name: 'athlete.auth.refresh', methods: ['POST'], group: 'api')]
    public function __invoke(
        RefreshTokenRequest $request,
        RefreshTokenCommandHandler $handler,
        TokenDTOToTokenResponseMapper $responseMapper,
    ): TokenResponse {
        $refreshData = $handler->handle(new RefreshTokenCommand(
            refreshToken: $request->getRefreshToken(),
        ));

        return $responseMapper->map($refreshData);
    }
}
