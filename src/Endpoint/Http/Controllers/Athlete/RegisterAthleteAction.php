<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Controllers\Athlete;

use App\Application\Exceptions\ApplicationException;
use App\Application\UseCases\Command\Athlete\RegisterAthlete\RegisterAthleteCommand;
use App\Application\UseCases\Command\Athlete\RegisterAthlete\RegisterAthleteCommandHandler;
use App\Domain\Exceptions\Auth\AuthStateNotValidException;
use App\Endpoint\Http\Exceptions\Athlete\AuthStateNotValidHttpException;
use App\Endpoint\Http\Requests\Athlete\RegisterAthleteRequest;
use App\Endpoint\Http\Responses\Athlete\RegisterAthleteResponse;
use OpenApi\Attributes as OA;
use RR\OpenApi as ROA;
use Spiral\Router\Annotation\Route;

#[OA\Get(path: '/api/athlete/auth/register', tags: ['auth'])]
#[OA\RequestBody(content: new OA\JsonContent(ref: RegisterAthleteRequest::class))]
#[ROA\SuccessfulResponse(content: new OA\JsonContent(ref: RegisterAthleteResponse::class))]
#[ROA\NotFoundResponse]
#[ROA\UnauthorizedResponse]
#[ROA\ValidationErrorResponse]
final readonly class RegisterAthleteAction
{
    /**
     * @throws ApplicationException
     * @throws AuthStateNotValidHttpException
     */
    #[Route(route: '/api/athlete/auth/register', name: 'athlete.auth.register', methods: ['POST'], group: 'api')]
    public function __invoke(
        RegisterAthleteRequest $request,
        RegisterAthleteCommandHandler $handler,
    ): RegisterAthleteResponse {
        try {
            $registerData = $handler->handle(new RegisterAthleteCommand(
                code: $request->getCode(),
                state: $request->getState(),
                email: $request->getEmail(),
                password: $request->getPassword(),
            ));
        } catch (AuthStateNotValidException) {
            throw new AuthStateNotValidHttpException();
        }

        return new RegisterAthleteResponse(
            accessToken: $registerData->accessToken,
            refreshToken: $registerData->refreshToken,
        );
    }
}
