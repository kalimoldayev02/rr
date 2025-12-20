<?php

declare(strict_types=1);

namespace App\Infrastructure\Mappers\Event;

use App\Domain\Criteria\Event\EventCriteriaInterface;
use Cycle\ORM\Select;
use Spiral\Config\ConfiguratorInterface;

final readonly class EventCriteriaMapper implements EventCriteriaMapperInterface
{
    private array $convertersMap;

    public function __construct(
        ConfiguratorInterface $config,
    ) {
        $this->convertersMap = $config->getConfig('criteria');
    }

    public function getSelect(EventCriteriaInterface $criteria, Select $select): Select
    {
        if (!\array_key_exists($criteria::class, $this->convertersMap)) {
            throw new \UnexpectedValueException("Criteria converter for " . $criteria::class . " not configured");
        }

        $converter = new $this->convertersMap[$criteria::class]();
        return $converter->map($criteria, $select);
    }
}
