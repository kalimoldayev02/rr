<?php

declare(strict_types=1);

namespace App\Application\Services\Event\CollectEventsExtraData;

use App\Application\Mappers\Athlete\AthleteEntityToAthleteDTOMapper;
use App\Application\Mappers\Reference\DistanceReferenceEntityToDistanceReferenceDTOMapper;
use App\Domain\Aggregates\EventAggregate;
use App\Domain\Collections\EventCollection;
use App\Domain\Criteria\Athlete\AthleteQueryCriteria;
use App\Domain\Criteria\Reference\DistanceReference\DistanceReferenceQueryCriteria;
use App\Domain\Entities\AthleteEntity;
use App\Domain\Entities\DistanceReferenceEntity;
use App\Domain\Entities\EventResultEntity;
use App\Domain\Repositories\AthleteRepositoryInterface;
use App\Domain\Repositories\DistanceReferenceRepositoryInterface;

final readonly class CollectEventExtraDataService
{
    public function __construct(
        private AthleteRepositoryInterface $athleteRepository,
        private DistanceReferenceRepositoryInterface $distanceReferenceRepository,
        private AthleteEntityToAthleteDTOMapper $toAthleteDTOMapper,
        private DistanceReferenceEntityToDistanceReferenceDTOMapper $toDistanceReferenceDTOMapper,
    ) {}

    public function collect(EventCollection $eventCollection): EventsExtraDataDTO
    {
        $athleteIdsMap = [];
        $distanceReferenceIdsMap = [];

        /** @var EventAggregate $eventAggregate */
        foreach ($eventCollection->toArray() as $eventAggregate) {
            $athleteIdsMap[$eventAggregate->getAuthorId()->toString()] = $eventAggregate->getAuthorId();

            /** @var EventResultEntity $eventResultEntity */
            foreach ($eventAggregate->getResult() as $eventResultEntity) {
                $athleteIdsMap[$eventResultEntity->getAthleteId()->toString()] = $eventResultEntity->getAthleteId();
                $distanceReferenceIdsMap[$eventResultEntity->getDistanceReferenceId()->toString()] = $eventResultEntity->getDistanceReferenceId();
            }
        }

        $athleteCollection = $this->athleteRepository->getByCriteria(new AthleteQueryCriteria(ids: $athleteIdsMap));
        $distanceReferenceCollection = $this->distanceReferenceRepository->getByCriteria(new DistanceReferenceQueryCriteria(ids: $distanceReferenceIdsMap));

        $athletesDataMap = [];
        /** @var AthleteEntity $athleteEntity */
        foreach ($athleteCollection->toArray() as $athleteEntity) {
            $athletesDataMap[$athleteEntity->getId()->toString()] = $this->toAthleteDTOMapper->map($athleteEntity);
        }

        $distanceReferencesDataMap = [];
        /** @var DistanceReferenceEntity $distanceReferenceEntity */
        foreach ($distanceReferenceCollection->toArray() as $distanceReferenceEntity) {
            $distanceReferencesDataMap[$distanceReferenceEntity->getId()->toString()] = $this->toDistanceReferenceDTOMapper->map($distanceReferenceEntity);
        }

        return new EventsExtraDataDTO(
            athletesDataMap: $athletesDataMap,
            distanceReferencesDataMap: $distanceReferencesDataMap,
        );
    }
}
