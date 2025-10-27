<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Repositories;

use App\Domain\Collections\AthleteCollection;
use App\Domain\Criteria\Athlete\AthleteCriteriaInterface;
use App\Domain\Criteria\SortCriteria;
use App\Domain\Entities\AthleteEntity;
use App\Domain\Enums\User\UserGenderEnum;
use App\Domain\Exceptions\Athlete\AthleteNotFoundException;
use App\Domain\Repositories\AthleteRepositoryInterface;
use App\Domain\ValueObjects\EmailVO;
use App\Domain\ValueObjects\PaginationVO;
use App\Infrastructure\Persistence\CycleORM\Entities\AthleteCycleORMEntity;
use App\Infrastructure\Persistence\CycleORM\Mappers\Athlete\DomainAthleteEntityToPersistenceAthleteEntityMapper;
use App\Infrastructure\Persistence\CycleORM\Mappers\Athlete\PersistenceAthleteEntityToDomainAthleteEntityMapper;
use Cycle\ORM\Select\Repository;
use Cycle\ORM\EntityManagerInterface;
use Cycle\ORM\Select;
use Ramsey\Uuid\UuidInterface;

class AthleteCycleORMRepository extends Repository implements AthleteRepositoryInterface
{
    private const array RELATIONS = ['metadata', 'clubAthletes'];

    public function __construct(
        Select $select,
        private readonly EntityManagerInterface $entityManager,
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
        $query = $this->select()->load(self::RELATIONS);

        if ($criteria->ids) {
            $query = $query->andWhere('id', 'IN', $criteria->ids);
        }
        if ($criteria->externalIds) {
            $query = $query->andWhere('metadata.external_id', 'IN', $criteria->externalIds);
        }
        if ($criteria->emails) {
            $query = $query->andWhere('email', 'IN', \array_map(static fn(EmailVO $email) => $email->getValue(), $criteria->emails));
        }
        if ($criteria->genders) {
            $query = $query->andWhere('gender', 'IN', \array_map(static fn(UserGenderEnum $gender) => $gender->name, $criteria->genders));
        }
        if ($criteria->clubIds) {
            $query = $query->andWhere('clubAthletes.club_id', 'IN', $criteria->clubIds);
        }
        if ($criteria->sorts) {
            foreach ($criteria->sorts as $sort) {
                /** @var SortCriteria $sort */
                $query->orderBy($sort->field, $sort->direction->name);
            }
        }

        $totalCountQuery = clone $query;
        if ($criteria->pagination) {
            $offset = ($criteria->pagination->page - 1) * $criteria->pagination->pageSize;
            $query->limit($criteria->pagination->pageSize)->offset($offset);
        }

        $data = \array_map(fn(AthleteCycleORMEntity $athleteEntity) => $this->toDomainAthleteEntityMapper->map(
            persistenceAthleteEntity: $athleteEntity,
        ), $query->fetchAll());

        return new AthleteCollection(
            data: $data,
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
