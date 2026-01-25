<?php

declare(strict_types=1);

namespace App\Infrastructure\Mappers\Activity;

use App\Domain\Criteria\Activity\ActivityCriteriaInterface;
use Cycle\ORM\Select;
use Spiral\Config\ConfiguratorInterface;

final readonly class ActivityCriteriaMapper implements ActivityCriteriaMapperInterface
{
    private array $convertersMap;

    public function __construct(
        ConfiguratorInterface $config,
    ) {
        $this->convertersMap = $config->getConfig('criteria');
    }

    /**
     * @throws \UnexpectedValueException
     */
    public function getSelect(ActivityCriteriaInterface $criteria, Select $select): Select
    {
        if (!\array_key_exists($criteria::class, $this->convertersMap)) {
            throw new \UnexpectedValueException("Criteria converter for " . $criteria::class . " not configured");
        }

        $converter = new $this->convertersMap[$criteria::class]();
        return $converter->map($criteria, $select);
    }
}
