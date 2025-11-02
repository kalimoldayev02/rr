<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Entities;

use App\Infrastructure\Persistence\CycleORM\Repositories\UserCycleORMRepository;
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\ORM\Entity\Behavior\Uuid\Uuid7;
use Ramsey\Uuid\UuidInterface;

#[Entity(repository: UserCycleORMRepository::class, table: 'users')]
#[Uuid7(field: 'id', nullable: false)]
class UserCycleORMEntity
{
    public function __construct(
        #[Column(type: 'uuid', name: 'id', primary: true)]
        private UuidInterface $id,
        #[Column(type: 'string')]
        private string $email,
        #[Column(type: 'string')]
        private string $firstname,
        #[Column(type: 'string')]
        private string $lastname,
        #[Column(type: 'string')]
        private string $gender,
        #[Column(type: 'date', nullable: true, typecast: 'datetime')]
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

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
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
}
