<?php

declare(strict_types=1);

namespace App\Infrastructure\Mappers\Activity;

use App\Domain\Enums\SportTypeEnum;

final readonly class SportTypeToActivitySportTypeMapper
{
    public function map(string $sportType): SportTypeEnum
    {
        return match (\lcfirst($sportType)) {
            SportTypeEnum::alpineSki->name => SportTypeEnum::alpineSki,
            SportTypeEnum::backcountrySki->name => SportTypeEnum::backcountrySki,
            SportTypeEnum::badminton->name => SportTypeEnum::badminton,
            SportTypeEnum::canoeing->name => SportTypeEnum::canoeing,
            SportTypeEnum::crossfit->name => SportTypeEnum::crossfit,
            SportTypeEnum::eBikeRide->name => SportTypeEnum::eBikeRide,
            SportTypeEnum::elliptical->name => SportTypeEnum::elliptical,
            SportTypeEnum::eMountainBikeRide->name => SportTypeEnum::eMountainBikeRide,
            SportTypeEnum::golf->name => SportTypeEnum::golf,
            SportTypeEnum::gravelRide->name => SportTypeEnum::gravelRide,
            SportTypeEnum::handcycle->name => SportTypeEnum::handcycle,
            SportTypeEnum::highIntensityIntervalTraining->name => SportTypeEnum::highIntensityIntervalTraining,
            SportTypeEnum::hike->name => SportTypeEnum::hike,
            SportTypeEnum::iceSkate->name => SportTypeEnum::iceSkate,
            SportTypeEnum::inlineSkate->name => SportTypeEnum::inlineSkate,
            SportTypeEnum::kayaking->name => SportTypeEnum::kayaking,
            SportTypeEnum::kitesurf->name => SportTypeEnum::kitesurf,
            SportTypeEnum::mountainBikeRide->name => SportTypeEnum::mountainBikeRide,
            SportTypeEnum::nordicSki->name => SportTypeEnum::nordicSki,
            SportTypeEnum::pickleball->name => SportTypeEnum::pickleball,
            SportTypeEnum::pilates->name => SportTypeEnum::pilates,
            SportTypeEnum::racquetball->name => SportTypeEnum::racquetball,
            SportTypeEnum::ride->name => SportTypeEnum::ride,
            SportTypeEnum::rockClimbing->name => SportTypeEnum::rockClimbing,
            SportTypeEnum::rollerSki->name => SportTypeEnum::rollerSki,
            SportTypeEnum::rowing->name => SportTypeEnum::rowing,
            SportTypeEnum::run->name => SportTypeEnum::run,
            SportTypeEnum::sail->name => SportTypeEnum::sail,
            SportTypeEnum::skateboard->name => SportTypeEnum::skateboard,
            SportTypeEnum::snowboard->name => SportTypeEnum::snowboard,
            SportTypeEnum::snowshoe->name => SportTypeEnum::snowshoe,
            SportTypeEnum::soccer->name => SportTypeEnum::soccer,
            SportTypeEnum::squash->name => SportTypeEnum::squash,
            SportTypeEnum::stairStepper->name => SportTypeEnum::stairStepper,
            SportTypeEnum::standUpPaddling->name => SportTypeEnum::standUpPaddling,
            SportTypeEnum::surfing->name => SportTypeEnum::surfing,
            SportTypeEnum::swim->name => SportTypeEnum::swim,
            SportTypeEnum::tableTennis->name => SportTypeEnum::tableTennis,
            SportTypeEnum::tennis->name => SportTypeEnum::tennis,
            SportTypeEnum::trailRun->name => SportTypeEnum::trailRun,
            SportTypeEnum::velomobile->name => SportTypeEnum::velomobile,
            SportTypeEnum::virtualRide->name => SportTypeEnum::virtualRide,
            SportTypeEnum::virtualRow->name => SportTypeEnum::virtualRow,
            SportTypeEnum::virtualRun->name => SportTypeEnum::virtualRun,
            SportTypeEnum::walk->name => SportTypeEnum::walk,
            SportTypeEnum::weightTraining->name => SportTypeEnum::weightTraining,
            SportTypeEnum::wheelchair->name => SportTypeEnum::wheelchair,
            SportTypeEnum::windsurf->name => SportTypeEnum::windsurf,
            SportTypeEnum::workout->name => SportTypeEnum::workout,
            SportTypeEnum::yoga->name => SportTypeEnum::yoga,
            default => throw new \InvalidArgumentException("Unknown sport type: {$sportType}"),
        };
    }
}
