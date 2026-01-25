<?php

declare(strict_types=1);

namespace App\Domain\Services\Athlete\CreateAthlete;

use App\Domain\Collections\OAuthTokenCollection;
use App\Domain\Entities\AthleteEntity;
use App\Domain\Entities\OAuthTokenEntity;
use App\Domain\Enums\Token\OAuthTokenProviderEnum;
use App\Domain\Exceptions\Athlete\AthleteExistsException;
use App\Domain\Repositories\AthleteRepositoryInterface;
use App\Domain\Specifications\Athlete\AthleteExternalIdIsUniqueSpecification;
use App\Domain\ValueObjects\EmailVO;
use App\Domain\ValueObjects\IdVO;

final readonly class CreateAthleteService
{
    public function __construct(
        private AthleteRepositoryInterface $athleteRepository,
        private AthleteExternalIdIsUniqueSpecification $athleteExternalIdIsUniqueSpecification,
    ) {}

    /**
     * @throws AthleteExistsException
     */
    public function create(CreateAthleteDTO $createAthleteData): void
    {
        if (!$this->athleteExternalIdIsUniqueSpecification->isSatisfiedBy($createAthleteData->externalId)) {
            throw new AthleteExistsException();
        }

        $athleteEntity = new AthleteEntity(
            id: $createAthleteData->id,
            email: new EmailVO($createAthleteData->email),
            externalId: $createAthleteData->externalId,
            firstname: $createAthleteData->firstname,
            lastname: $createAthleteData->lastname,
            gender: $createAthleteData->gender,
            password: $createAthleteData->password,
        );

        $athleteEntity->setOAuthTokens(new OAuthTokenCollection([new OAuthTokenEntity(
            id: new IdVO()->getValue(),
            provider: OAuthTokenProviderEnum::strava,
            accessToken: $createAthleteData->oAuthAccessToken,
            refreshToken: $createAthleteData->oAuthRefreshToken,
            expiresAt: new \DateTimeImmutable()
                ->setTimezone(new \DateTimeZone('Asia/Almaty'))
                ->modify("+$createAthleteData->oAuthExpiresIn seconds"),
        )]));

        $this->athleteRepository->create($athleteEntity);
    }
}
