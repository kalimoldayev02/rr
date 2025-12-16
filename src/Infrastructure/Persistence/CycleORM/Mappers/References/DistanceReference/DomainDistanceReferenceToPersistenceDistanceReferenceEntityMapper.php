<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Mappers\References\DistanceReference;

use App\Domain\Entities\DistanceReferenceEntity;
use App\Domain\Enums\Activity\DistanceTypeEnum;
use App\Infrastructure\Persistence\CycleORM\Entities\DistanceReferenceCycleORMEntity;

final readonly class DomainDistanceReferenceToPersistenceDistanceReferenceEntityMapper
{
    public function map(DistanceReferenceCycleORMEntity $persistenceDistanceReferenceEntity, DistanceReferenceEntity $domainDistanceReferenceEntity): DistanceReferenceCycleORMEntity
    {
        $persistenceDistanceReferenceEntity->setId($domainDistanceReferenceEntity->getId());
        $persistenceDistanceReferenceEntity->setDistance($domainDistanceReferenceEntity->getDistance()->getValueAs(DistanceTypeEnum::meters));
        $persistenceDistanceReferenceEntity->setDistanceType(DistanceTypeEnum::meters->name);

        return $persistenceDistanceReferenceEntity;
    }
}
