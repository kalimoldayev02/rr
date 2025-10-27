<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Controllers\Athlete;

use App\Application\UseCases\Command\Auth\Login\LoginCommand;
use App\Application\UseCases\Command\Auth\Login\LoginCommandHandler;
use App\Endpoint\Http\Mappers\Token\TokenDTOToTokenResponseMapper;
use App\Endpoint\Http\Requests\Auth\LoginRequest;
use OpenApi\Attributes as OA;
use RR\OpenApi as ROA;
use Spiral\Router\Annotation\Route;
use App\Endpoint\Http\Responses\Token\TokenResponse;

#[OA\Post(path: '/api/athlete/auth/login', tags: ['auth'])]
#[OA\RequestBody(content: new OA\JsonContent(ref: LoginRequest::class))]
#[ROA\SuccessfulResponse(content: new OA\JsonContent(ref: TokenResponse::class))]
#[ROA\NotFoundResponse]
#[ROA\UnauthorizedResponse]
#[ROA\ValidationErrorResponse]
final readonly class LoginAthleteAction
{
    #[Route(route: '/api/athlete/auth/login', name: 'athlete.auth.login', methods: ['POST'], group: 'api')]
    public function __invoke(
        LoginRequest $request,
        LoginCommandHandler $handler,
        TokenDTOToTokenResponseMapper $responseMapper,
    ): TokenResponse {
        $loginData = $handler->handle(new LoginCommand(
            email: $request->getEmail(),
            password: $request->getPassword(),
        ));

        return $responseMapper->map($loginData);
    }
}
