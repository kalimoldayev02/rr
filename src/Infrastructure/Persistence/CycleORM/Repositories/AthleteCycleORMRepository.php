<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Repositories;

use App\Domain\Collections\AthleteCollection;
use App\Domain\Criteria\Athlete\AthleteCriteriaInterface;
use App\Domain\Entities\AthleteEntity;
use App\Domain\Exceptions\Athlete\AthleteNotFoundException;
use App\Domain\Repositories\AthleteRepositoryInterface;
use App\Domain\ValueObjects\EmailVO;
use App\Infrastructure\Persistence\CycleORM\Entities\AthleteCycleORMEntity;
use App\Infrastructure\Persistence\CycleORM\Mappers\Athlete\DomainAthleteEntityToPersistenceAthleteEntityMapper;
use App\Infrastructure\Persistence\CycleORM\Mappers\Athlete\PersistenceAthleteEntityToDomainAthleteEntityMapper;
use Cycle\ORM\Select\Repository;
use Cycle\ORM\EntityManagerInterface;
use Cycle\ORM\Select;
use Ramsey\Uuid\UuidInterface;

class AthleteCycleORMRepository extends Repository implements AthleteRepositoryInterface
{
    private const RELATIONS = ['metadata'];

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
            id: $athleteEntity->getId()->getValue(),
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
            persistenceAthleteEntity: $this->get($athleteEntity->getId()->getValue()),
            domainAthleteEntity: $athleteEntity,
        ));
        $this->entityManager->run();
    }

    public function delete(AthleteEntity $athleteEntity): void
    {
        $this->entityManager->delete($this->toPersistenceAthleteEntityMapper->map(
            persistenceAthleteEntity: $this->get($athleteEntity->getId()->getValue()),
            domainAthleteEntity: $athleteEntity,
        ));
        $this->entityManager->run();
    }

    public function getById(UuidInterface $id): AthleteEntity
    {
        if (!$persistenceAthleteEntity = $this->get($id)) {
            throw new AthleteNotFoundException();
        }
        return $this->toDomainAthleteEntityMapper->map($persistenceAthleteEntity);
    }

    public function getByCriteria(AthleteCriteriaInterface $criteria): AthleteCollection
    {
        $query = $this->select()->load(self::RELATIONS);

        if (is_array($criteria->externalIds) && count($criteria->externalIds) > 0) {
            $query = $query->andWhere('metadata.external_id', 'IN', $criteria->externalIds);
        }
        if (is_array($criteria->emails) && count($criteria->emails) > 0) {
            $query = $query->andWhere('email', 'IN', array_map(fn(EmailVO $email) => $email->getValue(), $criteria->emails));
        }

        return new AthleteCollection(\array_map(fn(AthleteCycleORMEntity $athleteEntity) => $this->toDomainAthleteEntityMapper->map(
            persistenceAthleteEntity: $athleteEntity,
        ), $query->fetchAll()));
    }

    private function get(UuidInterface $id): ?object
    {
        return $this->select()->wherePK($id)->load(self::RELATIONS)->fetchOne();
    }
}
