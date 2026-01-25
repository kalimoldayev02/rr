<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

use App\Domain\Enums\Activity\DurationTypeEnum;

final readonly class DurationVO
{
    public function __construct(
        private float $value,
        private DurationTypeEnum $type,
    ) {}

    public function getValue(): float
    {
        return $this->value;
    }

    public function getType(): DurationTypeEnum
    {
        return $this->type;
    }

    public function getValueAs(DurationTypeEnum $targetType): float
    {
        if ($this->type === $targetType) {
            return $this->value;
        }

        return match ([$this->type, $targetType]) {
            [DurationTypeEnum::minutes, DurationTypeEnum::seconds] => $this->value * 60,
            [DurationTypeEnum::seconds, DurationTypeEnum::minutes] => $this->value / 60,
            default => throw new \InvalidArgumentException('Unsupported conversion'),
        };
    }
}
