<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Requests\Event;

use App\Endpoint\Http\Requests\Pagination\PaginationRequestTrait;
use App\Endpoint\Http\Requests\Sort\SortRequestTrait;
use Carbon\Carbon;
use OpenApi\Attributes as OA;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Spiral\Filters\Attribute\Input\Query;
use Spiral\Filters\Model\Filter;
use Spiral\Filters\Model\FilterDefinitionInterface;
use Spiral\Filters\Model\HasFilterDefinition;
use Spiral\Validation\Laravel\FilterDefinition;

#[OA\Schema]
final class GetEventsRequest extends Filter implements HasFilterDefinition
{
    use PaginationRequestTrait;
    use SortRequestTrait;

    #[Query]
    #[OA\Property(type: 'array', items: new OA\Items(type: 'string', format: 'uuid'), nullable: true)]
    private ?array $ids = null;

    #[Query]
    #[OA\Property(type: 'array', items: new OA\Items(type: 'string', format: 'uuid'), nullable: true)]
    private ?array $clubIds = null;

    #[Query]
    #[OA\Property(type: 'array', items: new OA\Items(type: 'string', format: 'uuid'), nullable: true)]
    private ?array $athleteIds = null;

    #[Query]
    #[OA\Property(type: 'string', format: 'date-time', nullable: true)]
    private ?string $fromDate = null;

    #[Query]
    #[OA\Property(type: 'string', format: 'date-time', nullable: true)]
    private ?string $toDate = null;

    #[Query]
    #[OA\Property(nullable: true)]
    private ?string $title = null;

    #[Query]
    #[OA\Property(nullable: true)]
    private bool $own = false;

    public function filterDefinition(): FilterDefinitionInterface
    {
        return new FilterDefinition([
            'ids' => ['nullable', 'array'],
            'ids.*' => ['uuid'],
            'clubIds' => ['nullable', 'array'],
            'clubIds.*' => ['uuid'],
            'userIds' => ['nullable', 'array'],
            'userIds.*' => ['uuid'],
            'fromDate' => ['nullable', 'date_format:Y-m-d\TH:i:s.vP,Y-m-d\TH:i:s.v\Z'],
            'toDate' => ['nullable', 'date_format:Y-m-d\TH:i:s.vP,Y-m-d\TH:i:s.v\Z'],
            'title' => ['nullable', 'string'],
            'own' => ['bool', 'defauxlt:false'],
            'page' => ['nullable', 'integer'],
            'limit' => ['nullable', 'integer'],
        ]);
    }

    /**
     * @return UuidInterface[]|null
     */
    public function getIds(): ?array
    {
        return $this->ids ? \array_map(static fn(string $id) => Uuid::fromString($id), $this->ids) : null;
    }

    /**
     * @return UuidInterface[]|null
     */
    public function getClubIds(): ?array
    {
        return $this->clubIds ? \array_map(static fn(string $id) => Uuid::fromString($id), $this->clubIds) : null;
    }

    /**
     * @return UuidInterface[]|null
     */
    public function getAthleteIds(): ?array
    {
        return $this->athleteIds ? \array_map(static fn(string $id) => Uuid::fromString($id), $this->athleteIds) : null;
    }

    public function getFromDate(): ?\DateTimeImmutable
    {
        return $this->fromDate ? Carbon::parse($this->fromDate)->toDateTimeImmutable() : null;
    }

    public function getToDate(): ?\DateTimeImmutable
    {
        return $this->toDate ? Carbon::parse($this->toDate)->toDateTimeImmutable() : null;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function isOwn(): bool
    {
        return $this->own === true;
    }
}
