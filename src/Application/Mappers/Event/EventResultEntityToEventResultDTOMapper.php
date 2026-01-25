<?php

declare(strict_types=1);

namespace App\Application\Mappers\Event;

use App\Application\DTO\Event\EventResultDTO;
use App\Application\Services\Event\CollectEventsExtraData\EventsExtraDataDTO;
use App\Domain\Entities\EventResultEntity;

final readonly class EventResultEntityToEventResultDTOMapper
{
    public function map(EventResultEntity $eventResultEntity, EventsExtraDataDTO $extraData): EventResultDTO
    {
        return new EventResultDTO(
            id: $eventResultEntity->getId(),
            athlete: $extraData->athletesDataMap[$eventResultEntity->getAthleteId()->toString()],
            activityId: $eventResultEntity->getActivityId(),
            distance: $extraData->distanceReferencesDataMap[$eventResultEntity->getDistanceReferenceId()->toString()],
            duration: $eventResultEntity->getDuration(),
        );
    }
}
