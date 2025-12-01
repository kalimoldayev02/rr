<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Repositories;

use App\Domain\Collections\AthleteCollection;
use App\Domain\Criteria\Athlete\AthleteCriteriaInterface;
use App\Domain\Entities\AthleteEntity;
use App\Domain\Exceptions\Athlete\AthleteNotFoundException;
use App\Domain\Repositories\AthleteRepositoryInterface;
use App\Domain\ValueObjects\PaginationVO;
use App\Infrastructure\Mappers\Athlete\AthleteCriteriaMapperInterface;
use App\Infrastructure\Persistence\CycleORM\Entities\AthleteCycleORMEntity;
use App\Infrastructure\Persistence\CycleORM\Mappers\Athlete\DomainAthleteEntityToPersistenceAthleteEntityMapper;
use App\Infrastructure\Persistence\CycleORM\Mappers\Athlete\PersistenceAthleteEntityToDomainAthleteEntityMapper;
use Cycle\ORM\Select\Repository;
use Cycle\ORM\EntityManagerInterface;
use Cycle\ORM\Select;
use Ramsey\Uuid\UuidInterface;

class AthleteCycleORMRepository extends Repository implements AthleteRepositoryInterface
{
    private const array RELATIONS = ['metadata', 'clubAthletes', 'oAuthTokens'];

    public function __construct(
        Select $select,
        private readonly EntityManagerInterface $entityManager,
        private readonly AthleteCriteriaMapperInterface $criteriaMapper,
        private readonly PersistenceAthleteEntityToDomainAthleteEntityMapper $toDomainAthleteEntityMapper,
        private readonly DomainAthleteEntityToPersistenceAthleteEntityMapper $toPersistenceAthleteEntityMapper,
    ) {
        parent::__construct($select);
    }

    public function create(AthleteEntity $athleteEntity): void
    {
        $persistenceAthleteEntity = new AthleteCycleORMEntity(
            id: $athleteEntity->getId(),
            email: $athleteEntity->getEmail()->getValue(),
            metadata: null,
            firstname: $athleteEntity->getFirstName(),
            lastname: $athleteEntity->getLastName(),
            gender: $athleteEntity->getGender()->name,
            birthday: $athleteEntity->getBirthday(),
            password: $athleteEntity->getPassword(),
        );

        $this->entityManager->persist($this->toPersistenceAthleteEntityMapper->map(
            persistenceAthleteEntity: $persistenceAthleteEntity,
            domainAthleteEntity: $athleteEntity,
        ));
        $this->entityManager->run();
    }

    public function update(AthleteEntity $athleteEntity): void
    {
        $this->entityManager->persist($this->toPersistenceAthleteEntityMapper->map(
            persistenceAthleteEntity: $this->get($athleteEntity->getId()),
            domainAthleteEntity: $athleteEntity,
        ));
        $this->entityManager->run();
    }

    public function delete(AthleteEntity $athleteEntity): void
    {
        $this->entityManager->delete($this->get($athleteEntity->getId()));
        $this->entityManager->run();
    }

    public function getById(UuidInterface $id): AthleteEntity
    {
        return $this->toDomainAthleteEntityMapper->map($this->get($id));
    }

    public function getByCriteria(AthleteCriteriaInterface $criteria): AthleteCollection
    {
        $select = $this->criteriaMapper->getSelect($criteria, $this->select()->load(self::RELATIONS));

        $totalCountQuery = clone $select;
        if ($criteria->pagination) {
            $offset = ($criteria->pagination->page - 1) * $criteria->pagination->pageSize;
            $select->limit($criteria->pagination->pageSize)->offset($offset);
        }

        $data = $select->fetchAll();

        return new AthleteCollection(
            data: \array_map(fn(AthleteCycleORMEntity $athleteEntity) => $this->toDomainAthleteEntityMapper->map(
                persistenceAthleteEntity: $athleteEntity,
            ), $data),
            pagination: new PaginationVO(
                page: $criteria->pagination?->page ?? 1,
                pageSize: $criteria->pagination?->pageSize ?? \count($data),
                totalCount: $totalCountQuery->count(),
            ),
        );
    }

    private function get(UuidInterface $id): object
    {
        if (!$data = $this->select()->wherePK($id)->load(self::RELATIONS)->fetchOne()) {
            throw new AthleteNotFoundException();
        }
        return $data;
    }
}
