<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Entities;

use App\Infrastructure\Persistence\CycleORM\Repositories\AthleteCycleORMRepository;
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Relation\HasOne;
use Cycle\ORM\Entity\Behavior\Uuid\Uuid7;
use Ramsey\Uuid\UuidInterface;

#[Entity(repository: AthleteCycleORMRepository::class, table: 'users')]
#[Uuid7(field: 'id', nullable: false)]
class AthleteCycleORMEntity
{
    public function __construct(
        #[Column(type: 'uuid', name: 'id', primary: true)]
        private UuidInterface $id,
        #[HasOne(target: AthleteMetadataCycleORMEntity::class, cascade: true, outerKey: 'user_id')]
        private ?AthleteMetadataCycleORMEntity $metadata = null,
        #[Column(type: 'string')]
        private string $firstname,
        #[Column(type: 'string')]
        private string $lastname,
        #[Column(type: 'string')]
        private string $gender,
        #[Column(type: 'datetime', nullable: true)]
        private ?\DateTimeImmutable $birthday,
    ) {}

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function setId(UuidInterface $id): void
    {
        $this->id = $id;
    }

    public function getMetadata(): ?AthleteMetadataCycleORMEntity
    {
        return $this->metadata;
    }

    public function setMetadata(?AthleteMetadataCycleORMEntity $metadata): void
    {
        $this->metadata = $metadata;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function setGender(string $gender): void
    {
        $this->gender = $gender;
    }

    public function getBirthday(): ?\DateTimeImmutable
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTimeImmutable $birthday): void
    {
        $this->birthday = $birthday;
    }
}
