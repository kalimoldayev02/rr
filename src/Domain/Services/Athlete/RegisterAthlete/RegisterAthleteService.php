<?php

declare(strict_types=1);

namespace App\Domain\Services\Athlete\RegisterAthlete;

use App\Domain\Criteria\Athlete\AthleteQueryCriteria;
use App\Domain\DTO\Athlete\AthleteExternalDataDTO;
use App\Domain\Entities\AthleteEntity;
use App\Domain\Entities\OAuthTokenEntity;
use App\Domain\Entities\TokenEntity;
use App\Domain\Enums\Token\OAuthTokenProviderEnum;
use App\Domain\Enums\Token\TokenTypeEnum;
use App\Domain\Exceptions\Athlete\AthleteExistsException;
use App\Domain\Exceptions\Auth\AuthStateNotValidException;
use App\Domain\Repositories\AthleteRepositoryInterface;
use App\Domain\Repositories\AuthStateRepositoryInterface;
use App\Domain\Repositories\OAuthTokenRepositoryInterface;
use App\Domain\Repositories\TokenRepositoryInterface;
use App\Domain\Services\Athlete\CreateAthlete\CreateAthleteDTO;
use App\Domain\Services\Athlete\CreateAthlete\CreateAthleteService;
use App\Domain\Services\ExternalServiceInterface;
use App\Domain\Services\Token\GenerateAccessToken\GenerateAccessTokenService;
use App\Domain\Services\Token\GenerateRefreshToken\GenerateRefreshTokenService;
use App\Domain\Specifications\Athlete\AthleteEmailIsUniqueSpecification;
use App\Domain\Specifications\Auth\AuthStateIsValidSpecification;
use App\Domain\ValueObjects\EmailVO;
use App\Domain\ValueObjects\IdVO;
use App\Domain\ValueObjects\TokenVO;
use Ramsey\Uuid\UuidInterface;

final readonly class RegisterAthleteService
{
    public function __construct(
        private ExternalServiceInterface $externalService,
        private AuthStateIsValidSpecification $stateIsValidSpecification,
        private AthleteEmailIsUniqueSpecification $athleteEmailIsUniqueSpecification,
        private AuthStateRepositoryInterface  $authStateRepository,
        private AthleteRepositoryInterface $athleteRepository,
        private CreateAthleteService $createAthleteService,
        private GenerateAccessTokenService $generateAccessTokenService,
        private GenerateRefreshTokenService $generateRefreshTokenService,
        private TokenRepositoryInterface $tokenRepository,
        private OauthTokenRepositoryInterface $oAuthTokenRepository,
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

        $athleteEntity = $this->persistAthlete($externalData, $registerAthlete);

        $accessTokenVO = $this->generateAccessTokenService->generate($athleteEntity->getId());
        $refreshTokenVO = $this->generateRefreshTokenService->generate();

        $this->createToken($athleteEntity, $accessTokenVO, TokenTypeEnum::access);
        $this->createToken($athleteEntity, $refreshTokenVO, TokenTypeEnum::refresh);
        $this->createOAuthToken($externalData, $athleteEntity->getId());

        return new RegisterAthleteOutputDTO(
            athleteEntity: $athleteEntity,
            accessToken: $accessTokenVO->getToken(),
            refreshToken: $refreshTokenVO->getToken(),
            oAuthToken: $externalData->accessToken,
        );
    }

    private function persistAthlete(AthleteExternalDataDTO $athleteExternalData, RegisterAthleteInputDTO $registerAthlete): AthleteEntity
    {
        $athleteCollection = $this->athleteRepository->getByCriteria(new AthleteQueryCriteria(
            externalIds: [$athleteExternalData->externalId],
        ));
        if (!$athleteCollection->isEmpty()) {
            return $athleteCollection->first();
        }

        $athleteId = new IdVO()->getValue();
        $this->createAthleteService->create(new CreateAthleteDTO(
            id: $athleteId,
            email: $registerAthlete->email,
            externalId: $athleteExternalData->externalId,
            firstname: $athleteExternalData->firstname,
            lastname: $athleteExternalData->lastname,
            gender: $athleteExternalData->gender,
            password: $registerAthlete->password,
        ));

        return $this->athleteRepository->getById($athleteId);
    }

    private function createToken(AthleteEntity $athleteEntity, TokenVO $tokenVO, TokenTypeEnum $type): void
    {
        $this->tokenRepository->create(new TokenEntity(
            id: new IdVO()->getValue(),
            userId: $athleteEntity->getId(),
            token: $tokenVO->getToken(),
            type: $type,
            expiresAt: $tokenVO->getExpiresAt(),
        ));
    }

    private function createOAuthToken(
        AthleteExternalDataDTO $athleteExternalData,
        UuidInterface $userId,
    ): void {
        $this->oAuthTokenRepository->create(new OAuthTokenEntity(
            id: new IdVO()->getValue(),
            userId: $userId,
            provider: OAuthTokenProviderEnum::strava,
            accessToken: $athleteExternalData->accessToken,
            refreshToken: $athleteExternalData->refreshToken,
            expiresAt: new \DateTimeImmutable("@$athleteExternalData->expiresAt"),
        ));
    }
}
