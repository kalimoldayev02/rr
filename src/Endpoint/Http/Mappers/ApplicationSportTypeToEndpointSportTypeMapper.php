<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Mappers;

use App\Application\Enums\SportTypeEnum;
use App\Endpoint\Http\Enums\SportTypeEnum as EndpointSportTypeEnum;

final readonly class ApplicationSportTypeToEndpointSportTypeMapper
{
    public function map(SportTypeEnum $sportType): EndpointSportTypeEnum
    {
        return match ($sportType) {
            SportTypeEnum::alpineSki => EndpointSportTypeEnum::alpineSki,
            SportTypeEnum::backcountrySki => EndpointSportTypeEnum::backcountrySki,
            SportTypeEnum::badminton => EndpointSportTypeEnum::badminton,
            SportTypeEnum::canoeing => EndpointSportTypeEnum::canoeing,
            SportTypeEnum::crossfit => EndpointSportTypeEnum::crossfit,
            SportTypeEnum::eBikeRide => EndpointSportTypeEnum::eBikeRide,
            SportTypeEnum::elliptical => EndpointSportTypeEnum::elliptical,
            SportTypeEnum::eMountainBikeRide => EndpointSportTypeEnum::eMountainBikeRide,
            SportTypeEnum::golf => EndpointSportTypeEnum::golf,
            SportTypeEnum::gravelRide => EndpointSportTypeEnum::gravelRide,
            SportTypeEnum::handcycle => EndpointSportTypeEnum::handcycle,
            SportTypeEnum::highIntensityIntervalTraining => EndpointSportTypeEnum::highIntensityIntervalTraining,
            SportTypeEnum::hike => EndpointSportTypeEnum::hike,
            SportTypeEnum::iceSkate => EndpointSportTypeEnum::iceSkate,
            SportTypeEnum::inlineSkate => EndpointSportTypeEnum::inlineSkate,
            SportTypeEnum::kayaking => EndpointSportTypeEnum::kayaking,
            SportTypeEnum::kitesurf => EndpointSportTypeEnum::kitesurf,
            SportTypeEnum::mountainBikeRide => EndpointSportTypeEnum::mountainBikeRide,
            SportTypeEnum::nordicSki => EndpointSportTypeEnum::nordicSki,
            SportTypeEnum::pickleball => EndpointSportTypeEnum::pickleball,
            SportTypeEnum::pilates => EndpointSportTypeEnum::pilates,
            SportTypeEnum::racquetball => EndpointSportTypeEnum::racquetball,
            SportTypeEnum::ride => EndpointSportTypeEnum::ride,
            SportTypeEnum::rockClimbing => EndpointSportTypeEnum::rockClimbing,
            SportTypeEnum::rollerSki => EndpointSportTypeEnum::rollerSki,
            SportTypeEnum::rowing => EndpointSportTypeEnum::rowing,
            SportTypeEnum::run => EndpointSportTypeEnum::run,
            SportTypeEnum::sail => EndpointSportTypeEnum::sail,
            SportTypeEnum::skateboard => EndpointSportTypeEnum::skateboard,
            SportTypeEnum::snowboard => EndpointSportTypeEnum::snowboard,
            SportTypeEnum::snowshoe => EndpointSportTypeEnum::snowshoe,
            SportTypeEnum::soccer => EndpointSportTypeEnum::soccer,
            SportTypeEnum::squash => EndpointSportTypeEnum::squash,
            SportTypeEnum::stairStepper => EndpointSportTypeEnum::stairStepper,
            SportTypeEnum::standUpPaddling => EndpointSportTypeEnum::standUpPaddling,
            SportTypeEnum::surfing => EndpointSportTypeEnum::surfing,
            SportTypeEnum::swim => EndpointSportTypeEnum::swim,
            SportTypeEnum::tableTennis => EndpointSportTypeEnum::tableTennis,
            SportTypeEnum::tennis => EndpointSportTypeEnum::tennis,
            SportTypeEnum::trailRun => EndpointSportTypeEnum::trailRun,
            SportTypeEnum::velomobile => EndpointSportTypeEnum::velomobile,
            SportTypeEnum::virtualRide => EndpointSportTypeEnum::virtualRide,
            SportTypeEnum::virtualRow => EndpointSportTypeEnum::virtualRow,
            SportTypeEnum::virtualRun => EndpointSportTypeEnum::virtualRun,
            SportTypeEnum::walk => EndpointSportTypeEnum::walk,
            SportTypeEnum::weightTraining => EndpointSportTypeEnum::weightTraining,
            SportTypeEnum::wheelchair => EndpointSportTypeEnum::wheelchair,
            SportTypeEnum::windsurf => EndpointSportTypeEnum::windsurf,
            SportTypeEnum::workout => EndpointSportTypeEnum::workout,
            SportTypeEnum::yoga => EndpointSportTypeEnum::yoga,
        };
    }
}
