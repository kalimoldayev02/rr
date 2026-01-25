<?php

declare(strict_types=1);

namespace App\Infrastructure\Mappers\Athlete;

use App\Domain\Criteria\Athlete\AthleteCriteriaInterface;
use Cycle\ORM\Select;
use Spiral\Config\ConfiguratorInterface;

final readonly class AthleteCriteriaMapper implements AthleteCriteriaMapperInterface
{
    private array $convertersMap;

    public function __construct(
        ConfiguratorInterface $config,
    ) {
        $this->convertersMap = $config->getConfig('criteria');
    }

    public function getSelect(AthleteCriteriaInterface $criteria, Select $select): Select
    {
        if (!\array_key_exists($criteria::class, $this->convertersMap)) {
            throw new \UnexpectedValueException("Criteria converter for " . $criteria::class . " not configured");
        }

        $converter = new $this->convertersMap[$criteria::class]();
        return $converter->map($criteria, $select);
    }
}
