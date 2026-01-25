<?php

declare(strict_types=1);

namespace App\Application\UseCases\Command\Auth\Register;

use App\Application\DTO\Token\TokenDTO;
use App\Application\Exceptions\ApplicationException;
use App\Domain\Events\Athlete\AthleteRegisteredEvent;
use App\Domain\Services\Athlete\RegisterAthlete\RegisterAthleteInputDTO;
use App\Domain\Services\Athlete\RegisterAthlete\RegisterAthleteService;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;

final readonly class RegisterCommandHandler
{
    public function __construct(
        private LoggerInterface $logger,
        private EventDispatcherInterface $eventDispatcher,
        private RegisterAthleteService $registerAthleteService,
    ) {}

    /**
     * @throws ApplicationException
     */
    public function handle(RegisterCommand $command): TokenDTO
    {
        try {
            $athlete = $this->registerAthleteService->register(new RegisterAthleteInputDTO(
                state: $command->state,
                code: $command->code,
                email: $command->email,
                password: $command->password,
            ));

            $this->eventDispatcher->dispatch(new AthleteRegisteredEvent(athleteId: $athlete->athleteId));

            return new TokenDTO(
                accessToken: $athlete->accessToken,
                refreshToken: $athlete->refreshToken,
            );
        } catch (\Exception $exception) {
            $this->logger->error('Register', [
                'message' => $exception->getMessage(),
                'email' => $command->email,
            ]);

            throw new ApplicationException($exception->getMessage());
        }
    }
}
