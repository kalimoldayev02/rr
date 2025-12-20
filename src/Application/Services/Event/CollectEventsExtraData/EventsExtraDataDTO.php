<?php

declare(strict_types=1);

namespace App\Application\Services\Event\CollectEventsExtraData;

use App\Application\DTO\Athlete\AthleteDTO;
use App\Application\DTO\Reference\DistanceReferenceDTO;

final readonly class EventsExtraDataDTO
{
    /**
     * @param array<string, AthleteDTO> $athletesDataMap
     * @param array<string, DistanceReferenceDTO> $distanceReferencesDataMap
     */
    public function __construct(
        public array $athletesDataMap,
        public array $distanceReferencesDataMap,
    ) {}
}
