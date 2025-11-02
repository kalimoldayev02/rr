<?php

declare(strict_types=1);

namespace App\Domain\Services\Athlete\RegisterAthlete;

use App\Domain\Collections\ClubIdCollection;
use App\Domain\Exceptions\Athlete\AthleteExistsException;
use App\Domain\Exceptions\Auth\AuthStateNotValidException;
use App\Domain\Repositories\AuthStateRepositoryInterface;
use App\Domain\Services\Auth\GenerateAccessToken\GenerateAccessTokenService;
use App\Domain\Services\Auth\GenerateRefreshToken\GenerateRefreshTokenService;
use App\Domain\Specifications\Athlete\AthleteEmailIsUniqueSpecification;
use App\Domain\Specifications\Auth\AuthStateIsValidSpecification;
use App\Domain\ValueObjects\EmailVO;
use App\Domain\ValueObjects\IdVO;
use Ramsey\Uuid\UuidInterface;
use App\Domain\Services\Athlete\CreateAthlete\CreateAthleteDTO;
use App\Domain\Services\Athlete\CreateAthlete\CreateAthleteService;
use App\Domain\Services\Athlete\ExchangeAthleteCode\ExchangeAthleteCodeInterface;
use App\Domain\Services\Athlete\ExchangeAthleteCode\ExchangeAthleteDataDTO;

final readonly class RegisterAthleteService
{
    public function __construct(
        private ExchangeAthleteCodeInterface $externalService,
        private AuthStateIsValidSpecification $stateIsValidSpecification,
        private AthleteEmailIsUniqueSpecification $athleteEmailIsUniqueSpecification,
        private AuthStateRepositoryInterface  $authStateRepository,
        private CreateAthleteService $createAthleteService,
        private GenerateAccessTokenService $generateAccessTokenService,
        private GenerateRefreshTokenService $generateRefreshTokenService,
    ) {}

    /**
     * @throws AuthStateNotValidException
     * @throws AthleteExistsException
     */
    public function register(RegisterAthleteInputDTO $registerAthleteData): RegisterAthleteOutputDTO
    {
        if (!$this->stateIsValidSpecification->isSatisfiedBy($registerAthleteData->state)) {
            throw new AuthStateNotValidException();
        }
        if (!$this->athleteEmailIsUniqueSpecification->isSatisfiedBy(new EmailVO($registerAthleteData->email))) {
            throw new AthleteExistsException();
        }

        $externalData = $this->externalService->exchange($registerAthleteData->code);
        $this->authStateRepository->delete($registerAthleteData->state);

        $athleteId = $this->createAthlete($externalData, $registerAthleteData);

        $accessTokenEntity = $this->generateAccessTokenService->generate($athleteId);
        $refreshTokenEntity = $this->generateRefreshTokenService->generate($athleteId);

        return new RegisterAthleteOutputDTO(
            athleteId: $athleteId,
            accessToken: $accessTokenEntity->getToken(),
            refreshToken: $refreshTokenEntity->getToken(),
        );
    }

    /**
     * @throws AthleteExistsException
     */
    private function createAthlete(ExchangeAthleteDataDTO $athleteData, RegisterAthleteInputDTO $registerAthlete): UuidInterface
    {
        $athleteId = new IdVO()->getValue();
        $this->createAthleteService->create(new CreateAthleteDTO(
            id: $athleteId,
            email: $registerAthlete->email,
            externalId: $athleteData->externalId,
            firstname: $athleteData->firstname,
            lastname: $athleteData->lastname,
            gender: $athleteData->gender,
            password: $registerAthlete->password,
            oAuthAccessToken: $athleteData->accessToken,
            oAuthRefreshToken: $athleteData->refreshToken,
            oAuthExpiresIn: $athleteData->expiresIn,
            clubIds: new ClubIdCollection(),
        ));

        return $athleteId;
    }
}
