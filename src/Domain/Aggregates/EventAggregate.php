<?php

declare(strict_types=1);

namespace App\Domain\Aggregates;

use App\Domain\Collections\EventResultCollection;
use App\Domain\Entities\EventResultEntity;
use Ramsey\Uuid\UuidInterface;

final class EventAggregate
{
    public function __construct(
        private UuidInterface $id,
        private UuidInterface $authorId,
        private UuidInterface $clubId,
        private \DateTimeImmutable $date,
        private string $title,
        private EventResultCollection $results = new EventResultCollection(),
    ) {}

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function setId(UuidInterface $id): void
    {
        $this->id = $id;
    }

    public function getAuthorId(): UuidInterface
    {
        return $this->authorId;
    }

    public function setAuthorId(UuidInterface $authorId): void
    {
        $this->authorId = $authorId;
    }

    public function getClubId(): UuidInterface
    {
        return $this->clubId;
    }

    public function setClubId(UuidInterface $clubId): void
    {
        $this->clubId = $clubId;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): void
    {
        $this->date = $date;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getResult(): EventResultCollection
    {
        return $this->results;
    }

    public function setResults(EventResultCollection $results): void
    {
        $this->results = $results;
    }

    public function addResult(EventResultEntity $resultEntity): void
    {
        $this->results->add($resultEntity);
    }
}
