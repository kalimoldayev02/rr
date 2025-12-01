<?php

declare(strict_types=1);

namespace App\Application\Mappers\SportType;

use App\Application\Enums\SportTypeEnum as ApplicationSportTypeEnum;
use App\Domain\Enums\SportTypeEnum;

final readonly class DomainSportTypeToApplicationSportTypeMapper
{
    public function map(SportTypeEnum $sportType): ApplicationSportTypeEnum
    {
        return match ($sportType) {
            SportTypeEnum::alpineSki => ApplicationSportTypeEnum::alpineSki,
            SportTypeEnum::backcountrySki => ApplicationSportTypeEnum::backcountrySki,
            SportTypeEnum::badminton => ApplicationSportTypeEnum::badminton,
            SportTypeEnum::canoeing => ApplicationSportTypeEnum::canoeing,
            SportTypeEnum::crossfit => ApplicationSportTypeEnum::crossfit,
            SportTypeEnum::eBikeRide => ApplicationSportTypeEnum::eBikeRide,
            SportTypeEnum::elliptical => ApplicationSportTypeEnum::elliptical,
            SportTypeEnum::eMountainBikeRide => ApplicationSportTypeEnum::eMountainBikeRide,
            SportTypeEnum::golf => ApplicationSportTypeEnum::golf,
            SportTypeEnum::gravelRide => ApplicationSportTypeEnum::gravelRide,
            SportTypeEnum::handcycle => ApplicationSportTypeEnum::handcycle,
            SportTypeEnum::highIntensityIntervalTraining => ApplicationSportTypeEnum::highIntensityIntervalTraining,
            SportTypeEnum::hike => ApplicationSportTypeEnum::hike,
            SportTypeEnum::iceSkate => ApplicationSportTypeEnum::iceSkate,
            SportTypeEnum::inlineSkate => ApplicationSportTypeEnum::inlineSkate,
            SportTypeEnum::kayaking => ApplicationSportTypeEnum::kayaking,
            SportTypeEnum::kitesurf => ApplicationSportTypeEnum::kitesurf,
            SportTypeEnum::mountainBikeRide => ApplicationSportTypeEnum::mountainBikeRide,
            SportTypeEnum::nordicSki => ApplicationSportTypeEnum::nordicSki,
            SportTypeEnum::pickleball => ApplicationSportTypeEnum::pickleball,
            SportTypeEnum::pilates => ApplicationSportTypeEnum::pilates,
            SportTypeEnum::racquetball => ApplicationSportTypeEnum::racquetball,
            SportTypeEnum::ride => ApplicationSportTypeEnum::ride,
            SportTypeEnum::rockClimbing => ApplicationSportTypeEnum::rockClimbing,
            SportTypeEnum::rollerSki => ApplicationSportTypeEnum::rollerSki,
            SportTypeEnum::rowing => ApplicationSportTypeEnum::rowing,
            SportTypeEnum::run => ApplicationSportTypeEnum::run,
            SportTypeEnum::sail => ApplicationSportTypeEnum::sail,
            SportTypeEnum::skateboard => ApplicationSportTypeEnum::skateboard,
            SportTypeEnum::snowboard => ApplicationSportTypeEnum::snowboard,
            SportTypeEnum::snowshoe => ApplicationSportTypeEnum::snowshoe,
            SportTypeEnum::soccer => ApplicationSportTypeEnum::soccer,
            SportTypeEnum::squash => ApplicationSportTypeEnum::squash,
            SportTypeEnum::stairStepper => ApplicationSportTypeEnum::stairStepper,
            SportTypeEnum::standUpPaddling => ApplicationSportTypeEnum::standUpPaddling,
            SportTypeEnum::surfing => ApplicationSportTypeEnum::surfing,
            SportTypeEnum::swim => ApplicationSportTypeEnum::swim,
            SportTypeEnum::tableTennis => ApplicationSportTypeEnum::tableTennis,
            SportTypeEnum::tennis => ApplicationSportTypeEnum::tennis,
            SportTypeEnum::trailRun => ApplicationSportTypeEnum::trailRun,
            SportTypeEnum::velomobile => ApplicationSportTypeEnum::velomobile,
            SportTypeEnum::virtualRide => ApplicationSportTypeEnum::virtualRide,
            SportTypeEnum::virtualRow => ApplicationSportTypeEnum::virtualRow,
            SportTypeEnum::virtualRun => ApplicationSportTypeEnum::virtualRun,
            SportTypeEnum::walk => ApplicationSportTypeEnum::walk,
            SportTypeEnum::weightTraining => ApplicationSportTypeEnum::weightTraining,
            SportTypeEnum::wheelchair => ApplicationSportTypeEnum::wheelchair,
            SportTypeEnum::windsurf => ApplicationSportTypeEnum::windsurf,
            SportTypeEnum::workout => ApplicationSportTypeEnum::workout,
            SportTypeEnum::yoga => ApplicationSportTypeEnum::yoga,
        };
    }
}
