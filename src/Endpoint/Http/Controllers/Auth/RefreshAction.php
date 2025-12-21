<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Controllers\Auth;

use App\Application\UseCases\Command\Auth\Refresh\RefreshCommand;
use App\Application\UseCases\Command\Auth\Refresh\RefreshCommandHandler;
use App\Endpoint\Http\Mappers\Token\TokenDTOToTokenResponseMapper;
use App\Endpoint\Http\Requests\Auth\RefreshRequest;
use App\Endpoint\Http\Responses\Token\TokenResponse;
use OpenApi\Attributes as OA;
use RR\OpenApi as ROA;
use Spiral\Router\Annotation\Route;

#[OA\Post(path: '/api/auth/refresh', tags: ['Auth'])]
#[OA\RequestBody(content: new OA\JsonContent(ref: RefreshRequest::class))]
#[ROA\SuccessfulResponse]
#[ROA\NotFoundResponse]
#[ROA\UnauthorizedResponse]
#[ROA\ValidationErrorResponse]
final readonly class RefreshAction
{
    #[Route(route: '/api/auth/refresh', name: 'auth.refresh', methods: ['POST'], group: 'api')]
    public function __invoke(
        RefreshRequest $request,
        RefreshCommandHandler $handler,
        TokenDTOToTokenResponseMapper $responseMapper,
    ): TokenResponse {
        $tokenData = $handler->handle(new RefreshCommand(
            refreshToken: $request->getRefreshToken(),
        ));

        return $responseMapper->map($tokenData);
    }
}
