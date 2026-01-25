<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Enums;

enum SportTypeEnum: string
{
    case alpineSki = 'alpineSki';
    case backcountrySki = 'backcountrySki';
    case badminton = 'badminton';
    case canoeing = 'canoeing';
    case crossfit = 'crossfit';
    case eBikeRide = 'eBikeRide';
    case elliptical = 'elliptical';
    case eMountainBikeRide = 'eMountainBikeRide';
    case golf = 'golf';
    case gravelRide = 'gravelRide';
    case handcycle = 'handcycle';
    case highIntensityIntervalTraining = 'highIntensityIntervalTraining';
    case hike = 'hike';
    case iceSkate = 'iceSkate';
    case inlineSkate = 'inlineSkate';
    case kayaking = 'kayaking';
    case kitesurf = 'kitesurf';
    case mountainBikeRide = 'mountainBikeRide';
    case nordicSki = 'nordicSki';
    case pickleball = 'pickleball';
    case pilates = 'pilates';
    case racquetball = 'racquetball';
    case ride = 'ride';
    case rockClimbing = 'rockClimbing';
    case rollerSki = 'rollerSki';
    case rowing = 'rowing';
    case run = 'run';
    case sail = 'sail';
    case skateboard = 'skateboard';
    case snowboard = 'snowboard';
    case snowshoe = 'snowshoe';
    case soccer = 'soccer';
    case squash = 'squash';
    case stairStepper = 'stairStepper';
    case standUpPaddling = 'standUpPaddling';
    case surfing = 'surfing';
    case swim = 'swim';
    case tableTennis = 'tableTennis';
    case tennis = 'tennis';
    case trailRun = 'trailRun';
    case velomobile = 'velomobile';
    case virtualRide = 'virtualRide';
    case virtualRow = 'virtualRow';
    case virtualRun = 'virtualRun';
    case walk = 'walk';
    case weightTraining = 'weightTraining';
    case wheelchair = 'wheelchair';
    case windsurf = 'windsurf';
    case workout = 'workout';
    case yoga = 'yoga';
}
