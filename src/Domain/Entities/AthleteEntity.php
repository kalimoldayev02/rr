<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use App\Domain\Collections\AthleteRoleCollection;
use App\Domain\Collections\ClubIdCollection;
use App\Domain\Collections\OAuthTokenCollection;
use App\Domain\Enums\User\UserGenderEnum;
use App\Domain\ValueObjects\AthleteRoleVO;
use App\Domain\ValueObjects\EmailVO;
use Ramsey\Uuid\UuidInterface;

final class AthleteEntity
{
    private ClubIdCollection $clubIds;
    private OAuthTokenCollection $oAuthTokens;
    private AthleteRoleCollection $roles;

    public function __construct(
        private readonly UuidInterface $id,
        private EmailVO $email,
        private readonly int $externalId,
        private string $firstname,
        private string $lastname,
        private ?UserGenderEnum $gender,
        private string $password,
        private ?\DateTimeImmutable $birthday = null,
        private ?\DateTimeImmutable $createdAt = null,
        private ?\DateTimeImmutable $updatedAt = null,
    ) {
        $this->clubIds = new ClubIdCollection();
        $this->oAuthTokens = new OAuthTokenCollection();
        $this->roles = new AthleteRoleCollection();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getEmail(): EmailVO
    {
        return $this->email;
    }

    public function setEmail(EmailVO $email): void
    {
        $this->email = $email;
    }

    public function getExternalId(): int
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

    public function getGender(): ?UserGenderEnum
    {
        return $this->gender;
    }

    public function setGender(?UserGenderEnum $gender): void
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

    public function getClubIds(): ClubIdCollection
    {
        return $this->clubIds;
    }

    public function setClubIds(ClubIdCollection $clubIds): void
    {
        $this->clubIds = $clubIds;
    }

    public function getOAuthTokens(): OAuthTokenCollection
    {
        return $this->oAuthTokens;
    }

    public function setOAuthTokens(OAuthTokenCollection $oAuthTokens): void
    {
        $this->oAuthTokens = $oAuthTokens;
    }

    public function getRoles(): AthleteRoleCollection
    {
        return $this->roles;
    }

    public function setRoles(AthleteRoleCollection $athleteRoles): void
    {
        $this->roles = $athleteRoles;
    }

    public function addRole(AthleteRoleVO $role): void
    {
        $this->roles->add($role);
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
