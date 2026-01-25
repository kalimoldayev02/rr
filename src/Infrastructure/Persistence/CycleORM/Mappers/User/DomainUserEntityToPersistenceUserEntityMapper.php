<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Mappers\User;

use App\Domain\Entities\UserEntity;
use App\Infrastructure\Persistence\CycleORM\Entities\UserCycleORMEntity;

final readonly class DomainUserEntityToPersistenceUserEntityMapper
{
    public function map(UserCycleORMEntity $persistenceUserEntity, UserEntity $domainUserEntity): UserCycleORMEntity
    {
        $persistenceUserEntity->setId($domainUserEntity->getId());
        $persistenceUserEntity->setEmail($domainUserEntity->getEmail()->getValue());
        $persistenceUserEntity->setFirstName($domainUserEntity->getFirstName());
        $persistenceUserEntity->setLastName($domainUserEntity->getLastName());
        $persistenceUserEntity->setGender($domainUserEntity->getGender()->name);
        $persistenceUserEntity->setBirthday($domainUserEntity->getBirthday());
        $persistenceUserEntity->setPassword($domainUserEntity->getPassword());
        if ($persistenceUserEntity->getCreatedAt() === null) {
            $persistenceUserEntity->setCreatedAt(new \DateTimeImmutable());
        }
        $persistenceUserEntity->setUpdatedAt(new \DateTimeImmutable());

        return $persistenceUserEntity;
    }
}
