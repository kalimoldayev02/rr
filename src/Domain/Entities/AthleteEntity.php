<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use App\Domain\Enums\User\UserGenderEnum;
use App\Domain\ValueObjects\IdVO;

final class AthleteEntity
{
    public function __construct(
        private readonly IdVO $id,
        private readonly string $externalId,
        private string $firstname,
        private string $lastname,
        private UserGenderEnum $gender,
        private ?\DateTimeImmutable $birthday = null,
    ) {}

    public function getId(): IdVO
    {
        return $this->id;
    }

    public function getExternalId(): string
    {
        return $this->externalId;
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

    public function getGender(): UserGenderEnum
    {
        return $this->gender;
    }

    public function setGender(UserGenderEnum $gender): void
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
