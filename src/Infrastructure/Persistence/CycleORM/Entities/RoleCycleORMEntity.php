<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Entities;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\ORM\Entity\Behavior\Uuid\Uuid7;
use Ramsey\Uuid\UuidInterface;

#[Entity(table: 'roles')]
#[Uuid7(field: 'id', nullable: false)]
class RoleCycleORMEntity
{
    public function __construct(
        #[Column(type: 'uuid', primary: true)]
        private UuidInterface $id,
        #[Column(type: 'string', unique: true)]
        private string $name,
    ) {}

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function setId(UuidInterface $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
