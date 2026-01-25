<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Repositories;

use App\Domain\Collections\UserCollection;
use App\Domain\Criteria\User\UserQueryCriteria;
use App\Domain\Entities\UserEntity;
use App\Domain\Exceptions\User\UserNotFoundException;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\ValueObjects\PaginationVO;
use App\Infrastructure\Mappers\User\UserCriteriaMapperInterface;
use App\Infrastructure\Persistence\CycleORM\Entities\UserCycleORMEntity;
use App\Infrastructure\Persistence\CycleORM\Mappers\User\DomainUserEntityToPersistenceUserEntityMapper;
use App\Infrastructure\Persistence\CycleORM\Mappers\User\PersistenceUserEntityToDomainUserEntityMapper;
use Cycle\ORM\EntityManagerInterface;
use Cycle\ORM\Select;
use Cycle\ORM\Select\Repository;
use Ramsey\Uuid\UuidInterface;

class UserCycleORMRepository extends Repository implements UserRepositoryInterface
{
    public function __construct(
        Select $select,
        private readonly EntityManagerInterface $entityManager,
        private readonly UserCriteriaMapperInterface $criteriaMapper,
        private readonly PersistenceUserEntityToDomainUserEntityMapper $toDomainUserMapper,
        private readonly DomainUserEntityToPersistenceUserEntityMapper $toPersistenceUserMapper,
    ) {
        parent::__construct($select);
    }

    public function create(UserEntity $userEntity): void
    {
        $persistenceUserEntity = new UserCycleORMEntity(
            id: $userEntity->getId(),
            email: $userEntity->getEmail()->getValue(),
            firstname: $userEntity->getFirstName(),
            lastname: $userEntity->getLastName(),
            gender: $userEntity->getGender()->name,
            birthday: $userEntity->getBirthday(),
            password: $userEntity->getPassword(),
        );

        $this->entityManager->persist($this->toPersistenceUserMapper->map(
            persistenceUserEntity: $persistenceUserEntity,
            domainUserEntity: $userEntity,
        ));
        $this->entityManager->run();
    }

    public function update(UserEntity $userEntity): void
    {
        $this->entityManager->persist($this->toPersistenceUserMapper->map(
            persistenceUserEntity: $this->get($userEntity->getId()),
            domainUserEntity: $userEntity,
        ));
        $this->entityManager->run();
    }

    public function delete(UserEntity $userEntity): void
    {
        $this->entityManager->delete($this->get($userEntity->getId()));
        $this->entityManager->run();
    }

    public function getById(UuidInterface $id): UserEntity
    {
        return $this->toDomainUserMapper->map($this->get($id));
    }

    public function get(UuidInterface $id): ?object
    {
        if (!$data = $this->select()->wherePK($id)->fetchOne()) {
            throw new UserNotFoundException();
        }
        return $data;
    }

    public function getByCriteria(UserQueryCriteria $criteria): UserCollection
    {
        $select = $this->criteriaMapper->getSelect($criteria, $this->select());


        $totalCountQuery = clone $select;
        if ($criteria->pagination) {
            $offset = ($criteria->pagination->page - 1) * $criteria->pagination->pageSize;
            $select->limit($criteria->pagination->pageSize)->offset($offset);
        }

        $data = $select->fetchAll();

        return new UserCollection(
            data: \array_map(fn(UserCycleORMEntity $userEntity) => $this->toDomainUserMapper->map(
                persistenceUserEntity: $userEntity,
            ), $data),
            pagination: new PaginationVO(
                page: $criteria->pagination?->page ?? 1,
                pageSize: $criteria->pagination?->pageSize ?? \count($data),
                totalCount: $totalCountQuery->count(),
            ),
        );
    }
}
