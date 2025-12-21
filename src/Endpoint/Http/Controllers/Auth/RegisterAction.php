<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Controllers\Auth;

use App\Application\UseCases\Command\Auth\Register\RegisterCommand;
use App\Application\UseCases\Command\Auth\Register\RegisterCommandHandler;
use App\Endpoint\Http\Mappers\Token\TokenDTOToTokenResponseMapper;
use App\Endpoint\Http\Requests\Auth\RegisterRequest;
use App\Endpoint\Http\Responses\Token\TokenResponse;
use OpenApi\Attributes as OA;
use RR\OpenApi as ROA;
use Spiral\Router\Annotation\Route;

#[OA\Post(path: '/api/auth/register', tags: ['Auth'])]
#[OA\RequestBody(content: new OA\JsonContent(ref: RegisterRequest::class))]
#[ROA\SuccessfulResponse(content: new OA\JsonContent(ref: TokenResponse::class))]
#[ROA\NotFoundResponse]
#[ROA\UnauthorizedResponse]
#[ROA\ValidationErrorResponse]
final readonly class RegisterAction
{
    #[Route(route: '/api/auth/register', name: 'auth.register', methods: ['POST'], group: 'api')]
    public function __invoke(
        RegisterRequest $request,
        RegisterCommandHandler $handler,
        TokenDTOToTokenResponseMapper $tokenResponseMapper,
    ): TokenResponse {
        $tokenData = $handler->handle(new RegisterCommand(
            code: $request->getCode(),
            state: $request->getState(),
            email: $request->getEmail(),
            password: $request->getPassword(),
        ));

        return $tokenResponseMapper->map($tokenData);
    }
}
