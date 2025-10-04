<?php

declare(strict_types=1);

namespace App\Domain\Criteria\Athlete;

use App\Domain\Enums\User\UserGenderEnum;
use Ramsey\Uuid\UuidInterface;

final readonly class AthleteQueryCriteria implements AthleteCriteriaInterface
{
    /**
     * @param UuidInterface[]|null $ids
     * @param UuidInterface[]|null $clubIds
     * @param UserGenderEnum[]|null $gender
     * @param int[]|null $externalIds
     */
    public function __construct(
        public ?array $ids = null,
        public ?array $clubIds = null,
        public ?array $gender = null,
        public ?array $externalIds = null,
    ) {}
}
