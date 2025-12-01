<?php

declare(strict_types=1);

namespace App\Domain\Services\Activity\SyncActivityDetail;

final readonly class ActivityDetailDTO
{
    /**
     * @param LapDTO[] $laps
     * @param SplitDTO[] $splits
     */
    public function __construct(
        public array $laps,
        public array $splits,
    ) {}
}
