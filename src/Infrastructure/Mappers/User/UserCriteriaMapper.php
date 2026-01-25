<?php

declare(strict_types=1);

namespace App\Infrastructure\Mappers\User;

use App\Domain\Criteria\User\UserCriteriaInterface;
use Cycle\ORM\Select;
use Spiral\Config\ConfiguratorInterface;

final readonly class UserCriteriaMapper implements UserCriteriaMapperInterface
{
    private array $convertersMap;

    public function __construct(
        ConfiguratorInterface $config,
    ) {
        $this->convertersMap = $config->getConfig('criteria');
    }

    public function getSelect(UserCriteriaInterface $criteria, Select $select): Select
    {
        if (!\array_key_exists($criteria::class, $this->convertersMap)) {
            throw new \UnexpectedValueException("Criteria converter for " . $criteria::class . " not configured");
        }

        $converter = new $this->convertersMap[$criteria::class]();
        return $converter->map($criteria, $select);
    }
}
