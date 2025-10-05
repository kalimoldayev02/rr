<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Mappers\Club;

use App\Domain\Collections\AthleteCollection;
use App\Domain\Entities\ClubEntity;
use App\Domain\Enums\Club\SportTypeEnum;
use App\Domain\ValueObjects\IdVO;
use App\Infrastructure\Persistence\CycleORM\Entities\AthleteCycleORMEntity;
use App\Infrastructure\Persistence\CycleORM\Entities\ClubCycleORMEntity;
use App\Infrastructure\Persistence\CycleORM\Entities\ClubSportTypeCycleORMEntity;
use App\Infrastructure\Persistence\CycleORM\Mappers\Athlete\PersistenceAthleteEntityToDomainAthleteEntityMapper;

final readonly class PersistenceClubEntityToDomainClubEntityMapper
{
    public function __construct(
        private PersistenceAthleteEntityToDomainAthleteEntityMapper $toDomainAthleteEntityMapper,
    ) {}

    public function map(ClubCycleORMEntity $persistenceClubEntity): ClubEntity
    {
        return new ClubEntity(
            id: new IdVO($persistenceClubEntity->getId()),
            externalId: $persistenceClubEntity->getExternalId(),
            name: $persistenceClubEntity->getName(),
            description: $persistenceClubEntity->getDescription(),
            sportTypes: $this->mapSportTypes($persistenceClubEntity->getSportTypes()),
            athletes: $this->mapPersistenceAthletesToDomainAthletes($persistenceClubEntity->getAthletes()),
        );
    }

    /**
     * @param ClubSportTypeCycleORMEntity[] $sportTypes
     */
    private function mapSportTypes(array $sportTypes): array
    {
        return \array_map(static fn(ClubSportTypeCycleORMEntity $sportType) => match ($sportType->getType()) {
            'alpineSki' => SportTypeEnum::alpineSki,
            'backcountrySki' => SportTypeEnum::backcountrySki,
            'badminton' => SportTypeEnum::badminton,
            'canoeing' => SportTypeEnum::canoeing,
            'crossfit' => SportTypeEnum::crossfit,
            'eBikeRide' => SportTypeEnum::eBikeRide,
            'elliptical' => SportTypeEnum::elliptical,
            'eMountainBikeRide' => SportTypeEnum::eMountainBikeRide,
            'golf' => SportTypeEnum::golf,
            'gravelRide' => SportTypeEnum::gravelRide,
            'handcycle' => SportTypeEnum::handcycle,
            'highIntensityIntervalTraining' => SportTypeEnum::highIntensityIntervalTraining,
            'hike' => SportTypeEnum::hike,
            'iceSkate' => SportTypeEnum::iceSkate,
            'inlineSkate' => SportTypeEnum::inlineSkate,
            'kayaking' => SportTypeEnum::kayaking,
            'kitesurf' => SportTypeEnum::kitesurf,
            'mountainBikeRide' => SportTypeEnum::mountainBikeRide,
            'nordicSki' => SportTypeEnum::nordicSki,
            'pickleball' => SportTypeEnum::pickleball,
            'pilates' => SportTypeEnum::pilates,
            'racquetball' => SportTypeEnum::racquetball,
            'ride' => SportTypeEnum::ride,
            'rockClimbing' => SportTypeEnum::rockClimbing,
            'rollerSki' => SportTypeEnum::rollerSki,
            'rowing' => SportTypeEnum::rowing,
            'run' => SportTypeEnum::run,
            'sail' => SportTypeEnum::sail,
            'skateboard' => SportTypeEnum::skateboard,
            'snowboard' => SportTypeEnum::snowboard,
            'snowshoe' => SportTypeEnum::snowshoe,
            'soccer' => SportTypeEnum::soccer,
            'squash' => SportTypeEnum::squash,
            'stairStepper' => SportTypeEnum::stairStepper,
            'standUpPaddling' => SportTypeEnum::standUpPaddling,
            'surfing' => SportTypeEnum::surfing,
            'swim' => SportTypeEnum::swim,
            'tableTennis' => SportTypeEnum::tableTennis,
            'tennis' => SportTypeEnum::tennis,
            'trailRun' => SportTypeEnum::trailRun,
            'velomobile' => SportTypeEnum::velomobile,
            'virtualRide' => SportTypeEnum::virtualRide,
            'virtualRow' => SportTypeEnum::virtualRow,
            'virtualRun' => SportTypeEnum::virtualRun,
            'walk' => SportTypeEnum::walk,
            'weightTraining' => SportTypeEnum::weightTraining,
            'wheelchair' => SportTypeEnum::wheelchair,
            'windsurf' => SportTypeEnum::windsurf,
            'workout' => SportTypeEnum::workout,
            'yoga' => SportTypeEnum::yoga,
            default => throw new \InvalidArgumentException("Unknown sport type: {$sportType}"),
        }, $sportTypes);
    }

    private function mapPersistenceAthletesToDomainAthletes(array $persistenceAthleteEntities): AthleteCollection
    {
        return new AthleteCollection(\array_map(
            fn(AthleteCycleORMEntity $athleteEntity) => $this->toDomainAthleteEntityMapper->map($athleteEntity),
            $persistenceAthleteEntities,
        ));
    }
}
