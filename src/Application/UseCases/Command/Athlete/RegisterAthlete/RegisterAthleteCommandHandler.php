<?php

declare(strict_types=1);

namespace App\Application\UseCases\Command\Athlete\RegisterAthlete;

use App\Application\DTO\Token\TokenDTO;
use App\Application\Exceptions\ApplicationException;
use App\Domain\Events\Athlete\AthleteRegisteredEvent;
use App\Domain\Exceptions\Athlete\AthleteExistsException;
use App\Domain\Exceptions\Auth\AuthStateNotValidException;
use App\Domain\Services\Athlete\RegisterAthlete\RegisterAthleteInputDTO;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;
use App\Domain\Services\Athlete\RegisterAthlete\RegisterAthleteService;

final readonly class RegisterAthleteCommandHandler
{
    public function __construct(
        private LoggerInterface $logger,
        private EventDispatcherInterface $eventDispatcher,
        private RegisterAthleteService $registerAthleteService,
    ) {}

    /**
     * @throws ApplicationException
     */
    public function handle(RegisterAthleteCommand $command): TokenDTO
    {
        try {
            $athlete = $this->registerAthleteService->register(new RegisterAthleteInputDTO(
                state: $command->state,
                code: $command->code,
                email: $command->email,
                password: $command->password,
            ));

            $this->eventDispatcher->dispatch(new AthleteRegisteredEvent(athleteId: $athlete->athleteId));
        } catch (AthleteExistsException|AuthStateNotValidException $exception) {
            throw new ApplicationException($exception->getMessage());
        } catch (\Exception $exception) {
            $this->logger->error(__CLASS__, [
                'message' => $exception->getMessage(),
            ]);

            throw new ApplicationException($exception->getMessage());
        }

        return new TokenDTO(
            accessToken: $athlete->accessToken,
            refreshToken: $athlete->refreshToken,
        );
    }
}
