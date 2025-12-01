<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Mappers\Sort;

use App\Domain\Enums\SportTypeEnum;

final readonly class SportTypeValueToDomainSportTypeMapper
{
    public function map(string $sportType): SportTypeEnum
    {
        return match ($sportType) {
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
        };
    }
}
