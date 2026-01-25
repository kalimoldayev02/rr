<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Mappers\Athlete;

use App\Domain\Criteria\Athlete\AthleteQueryCriteria;
use App\Domain\Criteria\SortCriteria;
use App\Domain\Enums\Token\OAuthTokenProviderEnum;
use App\Domain\Enums\User\UserGenderEnum;
use App\Domain\ValueObjects\EmailVO;
use Cycle\ORM\Select;

final readonly class AthleteQueryCriteriaToCycleSelectMapper
{
    public function map(AthleteQueryCriteria $criteria, Select $select): Select
    {
        if ($criteria->ids) {
            $select->andWhere('id', 'IN', $criteria->ids);
        }

        if ($criteria->externalIds) {
            $select->andWhere('metadata.external_id', 'IN', $criteria->externalIds);
        }

        if ($criteria->emails) {
            $select->andWhere('email', 'IN', \array_map(static fn(EmailVO $email) => $email->getValue(), $criteria->emails));
        }

        if ($criteria->genders) {
            $select->andWhere('gender', 'IN', \array_map(static fn(UserGenderEnum $gender) => $gender->name, $criteria->genders));
        }

        if ($criteria->clubIds) {
            $select->andWhere('clubAthletes.club_id', 'IN', $criteria->clubIds);
        }
        if ($criteria->oAuthTokenCriteria) {
            $oAuthCriteria = $criteria->oAuthTokenCriteria;
            if ($oAuthCriteria->providers) {
                $select->with('oAuthTokens', ['method' => Select\JoinableLoader::JOIN])
                    ->andWhere(static function ($q) use ($oAuthCriteria): void {
                        $q->where('oAuthTokens.provider', 'IN', \array_map(
                            static fn(OAuthTokenProviderEnum $providerType) => $providerType->name,
                            $oAuthCriteria->providers,
                        ));
                    });
            }
        }
        foreach ($criteria->sorts ?? [] as $sort) {
            /** @var SortCriteria $sort */
            $select = $select->orderBy($sort->field, $sort->direction->name);
        }

        return $select;
    }
}
