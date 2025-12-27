<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Entities;

use App\Infrastructure\Persistence\CycleORM\Repositories\EventCycleORMRepository;
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Relation\HasMany;
use Cycle\ORM\Entity\Behavior\Uuid\Uuid7;
use Ramsey\Uuid\UuidInterface;

#[Entity(repository: EventCycleORMRepository::class, table: 'events')]
#[Uuid7(field: 'id', nullable: false)]
#[Uuid7(field: 'clubId', nullable: false)]
class EventCycleORMEntity
{
    #[HasMany(
        target: EventResultCycleORMEntity::class,
        innerKey: 'id',
        outerKey: 'event_id',
        fkOnDelete: 'CASCADE',
        load: 'eager',
    )]
    private array $results = [];

    public function __construct(
        #[Column(type: 'uuid', primary: true)]
        private UuidInterface $id,
        #[Column(type: 'uuid', name: 'club_id')]
        private UuidInterface $clubId,
        #[Column(type: 'datetime')]
        private \DateTimeImmutable $date,
        #[Column(type: 'string')]
        private string $title,
    ) {}

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function setId(UuidInterface $id): void
    {
        $this->id = $id;
    }

    public function getClubId(): UuidInterface
    {
        return $this->clubId;
    }

    public function setClubId(UuidInterface $clubId): void
    {
        $this->clubId = $clubId;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): void
    {
        $this->date = $date;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return EventResultCycleORMEntity[]
     */
    public function getResults(): array
    {
        return $this->results;
    }

    public function setResults(array $results): void
    {
        $this->results = $results;
    }
}
