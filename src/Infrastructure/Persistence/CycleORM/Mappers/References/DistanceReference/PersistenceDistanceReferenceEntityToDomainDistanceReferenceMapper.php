<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Mappers\References\DistanceReference;

use App\Domain\Entities\DistanceReferenceEntity;
use App\Domain\Enums\Activity\DistanceTypeEnum;
use App\Domain\ValueObjects\DistanceVO;
use App\Infrastructure\Persistence\CycleORM\Entities\DistanceReferenceCycleORMEntity;

final readonly class PersistenceDistanceReferenceEntityToDomainDistanceReferenceMapper
{
    public function map(DistanceReferenceCycleORMEntity $persistenceDistanceReferenceEntity): DistanceReferenceEntity
    {
        return new DistanceReferenceEntity(
            id: $persistenceDistanceReferenceEntity->getId(),
            distance: new DistanceVO(
                value: $persistenceDistanceReferenceEntity->getDistance(),
                type: match ($persistenceDistanceReferenceEntity->getDistanceType()) {
                    DistanceTypeEnum::meters->name => DistanceTypeEnum::meters,
                    DistanceTypeEnum::miles->name => DistanceTypeEnum::miles,
                    DistanceTypeEnum::kilometers->name => DistanceTypeEnum::kilometers,
                },
            ),
        );
    }
}
