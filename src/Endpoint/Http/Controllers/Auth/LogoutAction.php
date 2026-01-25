<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Controllers\Auth;

use App\Application\UseCases\Command\Auth\Logout\LogoutCommand;
use App\Application\UseCases\Command\Auth\Logout\LogoutCommandHandler;
use App\Endpoint\Http\Requests\Auth\LogoutRequest;
use OpenApi\Attributes as OA;
use RR\OpenApi as ROA;
use Spiral\Router\Annotation\Route;

#[OA\Post(path: '/auth/logout', tags: ['Auth'])]
#[OA\RequestBody(content: new OA\JsonContent(ref: LogoutRequest::class))]
#[ROA\SuccessfulResponse]
#[ROA\NotFoundResponse]
#[ROA\UnauthorizedResponse]
#[ROA\ValidationErrorResponse]
final readonly class LogoutAction
{
    #[Route(route: '/auth/logout', name: 'auth.logout', methods: ['POST'], group: 'auth_api')]
    public function __invoke(
        LogoutRequest $request,
        LogoutCommandHandler $handler,
    ): void {
        $handler->handle(new LogoutCommand(
            accessToken: $request->getAccessToken(),
            refreshToken: $request->getRefreshToken(),
        ));
    }
}
