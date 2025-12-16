<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Requests\Event;

use App\Domain\Enums\Activity\DurationTypeEnum as DomainDurationTypeEnum;
use App\Domain\ValueObjects\DurationVO;
use App\Endpoint\Http\Enums\Activity\DurationTypeEnum;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OA;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Spiral\Filters\Attribute\Input\Post;
use Spiral\Filters\Model\FilterDefinitionInterface;
use Spiral\Validation\Laravel\FilterDefinition;

trait StoreEventResultRequestTrait
{
    #[Post]
    #[OA\Property(nullable: true)]
    private ?string $activityId = null;

    #[Post]
    #[OA\Property]
    private string $distanceId;

    #[Post]
    #[OA\Property]
    private float $duration;

    #[Post]
    #[OA\Property(enum: DurationTypeEnum::class)]
    private string $durationType;

    public function filterDefinition(): FilterDefinitionInterface
    {
        return new FilterDefinition([
            'activityId' => ['nullable', 'string', 'uuid'],
            'distanceId' => ['required', 'string', 'uuid'],
            'duration' => ['required', 'numeric'],
            'durationType' => ['required', 'string', Rule::enum(DurationTypeEnum::class)],
        ]);
    }

    public function getActivityId(): ?UuidInterface
    {
        return $this->activityId ? Uuid::fromString($this->activityId) : null;
    }

    public function getDistanceId(): UuidInterface
    {
        return Uuid::fromString($this->distanceId);
    }

    public function getDuration(): DurationVO
    {
        return new DurationVO(
            value: $this->duration,
            type: match (DurationTypeEnum::from($this->durationType)) {
                DurationTypeEnum::seconds => DomainDurationTypeEnum::seconds,
                DurationTypeEnum::minutes => DomainDurationTypeEnum::minutes,
            },
        );
    }
}
