<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Collections\UserCollection;
use App\Domain\Criteria\User\UserQueryCriteria;
use App\Domain\Entities\UserEntity;
use App\Domain\Exceptions\User\UserNotFoundException;
use Ramsey\Uuid\UuidInterface;

interface UserRepositoryInterface
{
    public function create(UserEntity $userEntity): void;

    public function update(UserEntity $userEntity): void;

    public function delete(UserEntity $userEntity): void;

    /**
     * @throws UserNotFoundException
     */
    public function getById(UuidInterface $id): UserEntity;

    public function getByCriteria(UserQueryCriteria $criteria): UserCollection;
}
