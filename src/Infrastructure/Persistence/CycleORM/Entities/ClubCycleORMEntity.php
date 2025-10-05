<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Entities;

use App\Infrastructure\Persistence\CycleORM\Repositories\ClubCycleORMRepository;
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Relation\HasMany;
use Cycle\Annotated\Annotation\Relation\ManyToMany;
use Cycle\ORM\Entity\Behavior\Uuid\Uuid7;
use Ramsey\Uuid\UuidInterface;

#[Entity(repository: ClubCycleORMRepository::class, table: 'clubs')]
#[Uuid7(field: 'id', nullable: false)]
class ClubCycleORMEntity
{
    public function __construct(
        #[Column(type: 'uuid', name: 'id', primary: true)]
        private UuidInterface $id,
        #[Column(type: 'string', name: 'external_id')]
        private string $externalId,
        #[Column(type: 'string')]
        private string $name,
        #[Column(type: 'string', nullable: true)]
        private ?string $description,
        #[HasMany(
            target: ClubSportTypeCycleORMEntity::class,
            innerKey: 'id',
            outerKey: 'club_id',
            fkOnDelete: 'CASCADE',
            load: 'eager',
        )]
        private array $sportTypes = [],
        #[ManyToMany(
            target: AthleteCycleORMEntity::class,
            through: ClubAthleteCycleORMEntity::class,
            innerKey: 'id',
            outerKey: 'id',
            throughInnerKey: 'club_id',
            throughOuterKey: 'user_id',
            fkOnDelete: 'CASCADE',
            load: 'eager',
        )]
        private array $athletes = [],
    ) {}

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function setId(UuidInterface $id): void
    {
        $this->id = $id;
    }

    public function getExternalId(): string
    {
        return $this->externalId;
    }

    public function setExternalId(string $externalId): void
    {
        $this->externalId = $externalId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getSportTypes(): array
    {
        return $this->sportTypes;
    }

    public function setSportTypes(array $sportTypes): void
    {
        $this->sportTypes = $sportTypes;
    }

    /**
     * @return AthleteCycleORMEntity[]
     */
    public function getAthletes(): array
    {
        return $this->athletes;
    }

    public function setAthletes(array $athletes): void
    {
        $this->athletes = $athletes;
    }
}
