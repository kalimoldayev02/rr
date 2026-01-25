<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Requests\Event;

use OpenApi\Attributes as OA;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Spiral\Filters\Attribute\Input\Post;
use Spiral\Filters\Model\FilterDefinitionInterface;
use Spiral\Validation\Laravel\FilterDefinition;

trait StoreEventRequestTrait
{
    #[Post]
    #[OA\Property]
    private string $title;

    #[Post]
    #[OA\Property]
    private string $clubId;

    #[Post]
    #[OA\Property(type: 'string', format: 'date-time', example: '2025-10-06T06:00:00.000Z')]
    private string $date;

    public function filterDefinition(): FilterDefinitionInterface
    {
        return new FilterDefinition([
            'title' => ['required', 'string'],
            'date' => ['date_format:Y-m-d\TH:i:s.vP,Y-m-d\TH:i:s.v\Z', 'required'],
            'clubId' => ['required', 'string', 'uuid'],
        ]);
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDate(): \DateTimeImmutable
    {
        return Carbon::parse($this->date)->toDateTimeImmutable();
    }

    public function getClubId(): UuidInterface
    {
        return Uuid::fromString($this->clubId);
    }
}
