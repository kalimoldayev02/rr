<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Mappers\User;

use App\Domain\Criteria\SortCriteria;
use App\Domain\Criteria\User\UserQueryCriteria;
use App\Domain\Enums\User\UserGenderEnum;
use App\Domain\ValueObjects\EmailVO;
use Cycle\ORM\Select;

final readonly class UserQueryCriteriaToCycleSelectMapper
{
    public function map(UserQueryCriteria $criteria, Select $select): Select
    {
        if ($criteria->ids) {
            $select->andWhere('id', 'IN', $criteria->ids);
        }
        if ($criteria->emails) {
            $select->andWhere('email', 'IN', \array_map(static fn(EmailVO $email) => $email->getValue(), $criteria->emails));
        }
        if ($criteria->genders) {
            $select->andWhere('gender', 'IN', \array_map(static fn(UserGenderEnum $gender) => $gender->name, $criteria->genders));
        }
        foreach ($criteria->sorts ?? [] as $sort) {
            /** @var SortCriteria $sort */
            $select = $select->orderBy($sort->field, $sort->direction->name);
        }

        return $select;
    }
}
