<?php

declare(strict_types=1);

namespace App\Domain\Criteria\Athlete;

use App\Domain\Enums\User\UserGenderEnum;
use App\Domain\ValueObjects\EmailVO;
use Ramsey\Uuid\UuidInterface;

final readonly class AthleteQueryCriteria implements AthleteCriteriaInterface
{
    /**
     * @param UuidInterface[]|null $ids
     * @param EmailVO[]|null $emails
     * @param UserGenderEnum[]|null $genders
     * @param int[]|null $externalIds
     */
    public function __construct(
        public ?array $ids = null,
        public ?array $emails = null,
        public ?array $clubIds = null,
        public ?array $genders = null,
        public ?array $externalIds = null,
    ) {}
}
