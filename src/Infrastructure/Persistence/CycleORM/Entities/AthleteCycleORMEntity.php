<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Entities;

use App\Infrastructure\Persistence\CycleORM\Repositories\AthleteCycleORMRepository;
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Relation\HasMany;
use Cycle\Annotated\Annotation\Relation\HasOne;
use Cycle\ORM\Entity\Behavior\Uuid\Uuid7;
use Ramsey\Uuid\UuidInterface;

#[Entity(repository: AthleteCycleORMRepository::class, table: 'users')]
#[Uuid7(field: 'id', nullable: false)]
class AthleteCycleORMEntity
{
    #[HasMany(
        target: ClubAthleteCycleORMEntity::class,
        innerKey: 'id',
        outerKey: 'user_id',
        fkOnDelete: 'CASCADE',
        load: 'eager',
    )]
    private array $clubAthletes = [];

    #[HasMany(
        target: OAuthTokenCycleORMEntity::class,
        innerKey: 'id',
        outerKey: 'user_id',
        fkOnDelete: 'CASCADE',
        load: 'eager',
    )]
    private array $oAuthTokens = [];

    #[HasMany(
        target: AthleteClubRolesCycleORMEntity::class,
        innerKey: 'id',
        outerKey: 'user_id',
        fkOnDelete: 'CASCADE',
        load: 'eager',
    )]
    private array $roles = [];

    public function __construct(
        #[Column(type: 'uuid', name: 'id', primary: true)]
        private UuidInterface $id,
        #[Column(type: 'string')]
        private string $email,
        #[HasOne(target: AthleteMetadataCycleORMEntity::class, outerKey: 'user_id', cascade: true)]
        private ?AthleteMetadataCycleORMEntity $metadata = null,
        #[Column(type: 'string')]
        private string $firstname,
        #[Column(type: 'string')]
        private string $lastname,
        #[Column(type: 'string', nullable: true)]
        private ?string $gender,
        #[Column(type: 'datetime', nullable: true)]
        private ?\DateTimeImmutable $birthday,
        #[Column(type: 'string')]
        private string $password,
        #[Column(type: 'timestamptz', name: 'created_at', typecast: 'datetime')]
        private ?\DateTimeImmutable $createdAt = null,
        #[Column(type: 'timestamptz', name: 'updated_at', typecast: 'datetime')]
        private ?\DateTimeImmutable $updatedAt = null,
    ) {}

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function setId(UuidInterface $id): void
    {
        $this->id = $id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
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

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): void
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

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return ClubAthleteCycleORMEntity[]
     */
    public function getClubAthletes(): array
    {
        return $this->clubAthletes;
    }

    public function setClubAthletes(array $clubAthletes): void
    {
        $this->clubAthletes = $clubAthletes;
    }

    /**
     * @return OAuthTokenCycleORMEntity[]
     */
    public function getOAuthTokens(): array
    {
        return $this->oAuthTokens;
    }

    public function setOAuthTokens(array $oAuthTokens): void
    {
        $this->oAuthTokens = $oAuthTokens;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return AthleteClubRolesCycleORMEntity[]
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }
}
