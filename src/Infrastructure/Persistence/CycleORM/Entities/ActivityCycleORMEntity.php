<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Entities;

use App\Infrastructure\Persistence\CycleORM\Repositories\ActivityCycleORMRepository;
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Relation\HasOne;
use Cycle\ORM\Entity\Behavior\Uuid\Uuid7;
use Ramsey\Uuid\UuidInterface;

#[Entity(repository: ActivityCycleORMRepository::class, table: 'activities')]
#[Uuid7(field: 'id', nullable: false)]
#[Uuid7(field: 'athleteId', nullable: false)]
class ActivityCycleORMEntity
{
    #[HasOne(
        target: ActivityDetailCycleORMEntity::class,
        innerKey: 'id',
        outerKey: 'activity_id',
        nullable: true,
        fkOnDelete: 'CASCADE',
        load: 'eager',
    )]
    private ?ActivityDetailCycleORMEntity $detail = null;

    public function __construct(
        #[Column(type: 'uuid', name: 'id', primary: true)]
        private UuidInterface $id,
        #[Column(type: 'bigInteger', name: 'external_id')]
        private int $externalId,
        #[Column(type: 'uuid', name: 'athlete_id')]
        private UuidInterface $athleteId,
        #[Column(type: 'string')]
        private string $name,
        #[Column(type: 'float')]
        private float $distance,
        #[Column(type: 'float')]
        private float $movingTime,
        #[Column(type: 'float')]
        private float $elapsedTime,
        #[Column(type: 'string', name: 'sport_type')]
        private string $sportType,
        #[Column(type: 'datetime', name: 'start_date', typecast: 'datetime')]
        private \DateTimeImmutable $startDate,
        #[Column(type: 'text', name: 'summary_polyline', nullable: true)]
        private ?string $summaryPolyline,
    ) {}

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function setId(UuidInterface $id): void
    {
        $this->id = $id;
    }

    public function getExternalId(): int
    {
        return $this->externalId;
    }

    public function setExternalId(int $externalId): void
    {
        $this->externalId = $externalId;
    }
    public function getAthleteId(): UuidInterface
    {
        return $this->athleteId;
    }

    public function setAthleteId(UuidInterface $athleteId): void
    {
        $this->athleteId = $athleteId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDistance(): float
    {
        return $this->distance;
    }

    public function setDistance(float $distance): void
    {
        $this->distance = $distance;
    }

    public function getMovingTime(): float
    {
        return $this->movingTime;
    }

    public function setMovingTime(float $movingTime): void
    {
        $this->movingTime = $movingTime;
    }

    public function getElapsedTime(): float
    {
        return $this->elapsedTime;
    }

    public function setElapsedTime(float $elapsedTime): void
    {
        $this->elapsedTime = $elapsedTime;
    }

    public function getSportType(): string
    {
        return $this->sportType;
    }

    public function setSportType(string $sportType): void
    {
        $this->sportType = $sportType;
    }

    public function getStartDate(): \DateTimeImmutable
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeImmutable $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function getSummaryPolyline(): ?string
    {
        return $this->summaryPolyline;
    }

    public function setSummaryPolyline(?string $summaryPolyline): void
    {
        $this->summaryPolyline = $summaryPolyline;
    }

    public function getDetail(): ?ActivityDetailCycleORMEntity
    {
        return $this->detail;
    }

    public function setDetail(?ActivityDetailCycleORMEntity $detail): void
    {
        $this->detail = $detail;
    }
}
