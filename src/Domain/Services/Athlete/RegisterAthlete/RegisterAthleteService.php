<?php

declare(strict_types=1);

namespace App\Domain\Services\Athlete\RegisterAthlete;

use App\Domain\Criteria\Athlete\AthleteQueryCriteria;
use App\Domain\DTO\Athlete\AthleteExternalDataDTO;
use App\Domain\Entities\AthleteEntity;
use App\Domain\Exceptions\Athlete\AthleteExistsException;
use App\Domain\Exceptions\Auth\AuthStateNotValidException;
use App\Domain\Repositories\AthleteRepositoryInterface;
use App\Domain\Repositories\AuthStateRepositoryInterface;
use App\Domain\Services\Athlete\CreateAthlete\CreateAthleteDTO;
use App\Domain\Services\Athlete\CreateAthlete\CreateAthleteService;
use App\Domain\Services\ExternalServiceInterface;
use App\Domain\Specifications\Athlete\AthleteEmailIsUniqueSpecification;
use App\Domain\Specifications\Auth\AuthStateIsValidSpecification;
use App\Domain\ValueObjects\EmailVO;
use App\Domain\ValueObjects\IdVO;

final readonly class RegisterAthleteService
{
    public function __construct(
        private ExternalServiceInterface $externalService,
        private AuthStateIsValidSpecification $stateIsValidSpecification,
        private AthleteEmailIsUniqueSpecification $athleteEmailIsUniqueSpecification,
        private AuthStateRepositoryInterface  $authStateRepository,
        private AthleteRepositoryInterface $athleteRepository,
        private CreateAthleteService $createAthleteService,
    ) {}

    public function register(RegisterAthleteInputDTO $registerAthlete): RegisterAthleteOutputDTO
    {
        if (!$this->athleteEmailIsUniqueSpecification->isSatisfiedBy(new EmailVO($registerAthlete->email))) {
            throw new AthleteExistsException();
        }
        if (!$this->stateIsValidSpecification->isSatisfiedBy($registerAthlete->state)) {
            throw new AuthStateNotValidException();
        }
        $this->authStateRepository->delete($registerAthlete->state);
        $externalData = $this->externalService->exchangeCode($registerAthlete->code);

        dump($externalData);
        return new RegisterAthleteOutputDTO(
            athlete: $this->persistAthlete($externalData, $registerAthlete),
            accessToken: $externalData->accessToken,
            refreshToken: $externalData->refreshToken,
        );
    }

    private function persistAthlete(AthleteExternalDataDTO $athleteExternalData, RegisterAthleteInputDTO $registerAthlete): AthleteEntity
    {
        try {
            $athleteId = new IdVO();
            $this->createAthleteService->create(new CreateAthleteDTO(
                id: $athleteId->getValue(),
                email: $registerAthlete->email,
                externalId: $athleteExternalData->externalId,
                firstname: $athleteExternalData->firstname,
                lastname: $athleteExternalData->lastname,
                gender: $athleteExternalData->gender,
                password: $registerAthlete->password,
            ));
        } catch (AthleteExistsException) {
        }

        $athletes = $this->athleteRepository->getByCriteria(new AthleteQueryCriteria(
            externalIds: [$athleteExternalData->externalId],
        ));
        return $athletes->first();
    }
}
