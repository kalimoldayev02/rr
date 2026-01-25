<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

use App\Domain\Enums\Activity\DistanceTypeEnum;

final readonly class DistanceVO
{
    public function __construct(
        private float $value,
        private DistanceTypeEnum $type,
    ) {}

    public function getValue(): float
    {
        return $this->value;
    }

    public function getType(): DistanceTypeEnum
    {
        return $this->type;
    }

    public function getValueAs(DistanceTypeEnum $type): float
    {
        return match ($type) {
            DistanceTypeEnum::meters => $this->toMeters(),
            DistanceTypeEnum::kilometers => $this->toKilometers(),
            DistanceTypeEnum::miles => $this->toMiles(),
        };
    }

    private function toMeters(): float
    {
        return match ($this->type) {
            DistanceTypeEnum::meters => $this->value,
            DistanceTypeEnum::kilometers => $this->value * 1000,
            DistanceTypeEnum::miles => $this->value * 1609.34,
        };
    }

    private function toKilometers(): float
    {
        return match ($this->type) {
            DistanceTypeEnum::kilometers => $this->value,
            DistanceTypeEnum::meters => $this->value / 1000,
            DistanceTypeEnum::miles => $this->value * 1.60934,
        };
    }

    private function toMiles(): float
    {
        return match ($this->type) {
            DistanceTypeEnum::miles => $this->value,
            DistanceTypeEnum::meters => $this->value / 1609.34,
            DistanceTypeEnum::kilometers => $this->value / 1.60934,
        };
    }
}
