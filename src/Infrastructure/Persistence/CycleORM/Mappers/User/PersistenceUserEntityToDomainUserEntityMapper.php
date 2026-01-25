<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Mappers\User;

use App\Domain\Entities\UserEntity;
use App\Domain\Enums\User\UserGenderEnum;
use App\Domain\ValueObjects\EmailVO;
use App\Infrastructure\Persistence\CycleORM\Entities\UserCycleORMEntity;

final readonly class PersistenceUserEntityToDomainUserEntityMapper
{
    public function map(UserCycleORMEntity $persistenceUserEntity): UserEntity
    {
        return new UserEntity(
            id: $persistenceUserEntity->getId(),
            email: new EmailVO($persistenceUserEntity->getEmail()),
            firstname: $persistenceUserEntity->getFirstName(),
            lastname: $persistenceUserEntity->getLastName(),
            gender: match ($persistenceUserEntity->getGender()) {
                UserGenderEnum::male->name => UserGenderEnum::male,
                UserGenderEnum::female->name => UserGenderEnum::female,
            },
            password: $persistenceUserEntity->getPassword(),
            birthday: $persistenceUserEntity->getBirthday(),
        );
    }
}
