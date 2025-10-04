<?php

declare(strict_types=1);

namespace App\Application\UseCases\Command\Athlete\RegisterAthlete;

use App\Application\Exceptions\ApplicationException;
use App\Domain\Collections\ClubCollection;
use App\Domain\Criteria\Club\ClubQueryCriteria;
use App\Domain\Entities\ClubEntity;
use App\Domain\Exceptions\Auth\AuthStateNotValidException;
use App\Domain\Exceptions\Club\ClubExistsException;
use App\Domain\Repositories\ClubRepositoryInterface;
use App\Domain\Services\Athlete\RegisterAthlete\RegisterAthleteDataDTO;
use App\Domain\Services\Athlete\RegisterAthlete\RegisterAthleteService;
use App\Domain\Services\Club\CreateClub\CreateClubDTO;
use App\Domain\Services\Club\CreateClub\CreateClubService;
use App\Domain\Services\ExternalServiceInterface;
use App\Domain\ValueObjects\IdVO;
use Psr\Log\LoggerInterface;

final readonly class RegisterAthleteCommandHandler
{
    public function __construct(
        private LoggerInterface $logger,
        private ClubRepositoryInterface $clubRepository,
        private RegisterAthleteService $registerAthleteService,
        private ExternalServiceInterface $externalService,
        private CreateClubService $createClubService,
    ) {}

    /**
     * @throws ApplicationException
     */
    public function handle(RegisterAthleteCommand $command): RegisterAthleteDTO
    {
        try {
            $registerAthleteData = $this->registerAthleteService->register(
                code: $command->code,
                state: $command->state,
            );

            /** @var ClubEntity $clubEntity */
            foreach ($this->getClubs($registerAthleteData) as $clubEntity) {
                $clubEntity->addAthlete($registerAthleteData->athlete);

                $this->clubRepository->update($clubEntity);
            }
        } catch (AuthStateNotValidException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $this->logger->error(__CLASS__, [
                'message' => $exception->getMessage(),
            ]);
            throw new ApplicationException($exception->getMessage());
        }

        return new RegisterAthleteDTO(
            accessToken: $registerAthleteData->accessToken,
            refreshToken: $registerAthleteData->refreshToken,
        );
    }

    private function getClubs(RegisterAthleteDataDTO $registerAthlete): ClubCollection
    {
        $clubsExternalData = $this->externalService->getClubsByToken($registerAthlete->accessToken);
        $clubsExternalIds = [];
        foreach ($clubsExternalData as $clubExternalData) {
            try {
                $clubsExternalIds[] = $clubExternalData->externalId;
                $this->createClubService->create(new CreateClubDTO(
                    id: new IdVO()->getValue(),
                    externalId: $clubExternalData->externalId,
                    name: $clubExternalData->name,
                    description: $clubExternalData->description,
                    sportTypes: $clubExternalData->sportTypes,
                ));
            } catch (ClubExistsException) {
            }
        }

        return $this->clubRepository->getByCriteria(new ClubQueryCriteria(externalIds: $clubsExternalIds));
    }
}
