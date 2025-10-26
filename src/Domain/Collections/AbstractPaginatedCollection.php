<?php

declare(strict_types=1);

namespace App\Domain\Collections;

use App\Domain\ValueObjects\PaginationVO;
use Ramsey\Collection\AbstractCollection;
use Ramsey\Collection\CollectionInterface;
use Ramsey\Collection\Sort;

abstract class AbstractPaginatedCollection extends AbstractCollection
{
    private ?PaginationVO $pagination = null;

    public function __construct(
        array $data = [],
        ?PaginationVO $pagination = null,
    ) {
        parent::__construct($data);

        $this->pagination = $pagination;
    }

    public function add(mixed $element): bool
    {
        $result = parent::add($element);

        if ($result) {
            $this->handlePaginationAfterModification();
        }

        return $result;
    }

    public function remove(mixed $element): bool
    {
        $result = parent::remove($element);

        if ($result) {
            $this->handlePaginationAfterModification();
        }

        return $result;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        parent::offsetSet($offset, $value);
        $this->handlePaginationAfterModification();
    }

    public function offsetUnset(mixed $offset): void
    {
        parent::offsetUnset($offset);
        $this->handlePaginationAfterModification();
    }

    public function clear(): void
    {
        parent::clear();
        $this->handlePaginationAfterModification();
    }

    public function filter(callable $callback): CollectionInterface
    {
        $collection = parent::filter($callback);

        if ($collection instanceof self) {
            $collection->pagination = null;
        }

        return $collection;
    }

    public function where(?string $propertyOrMethod, mixed $value): CollectionInterface
    {
        $collection = parent::where($propertyOrMethod, $value);

        if ($collection instanceof self) {
            $collection->pagination = null;
        }

        return $collection;
    }

    public function sort(?string $propertyOrMethod = null, Sort $order = Sort::Ascending): CollectionInterface
    {
        $collection = parent::sort($propertyOrMethod, $order);

        if ($this->pagination !== null && $collection instanceof self) {
            $collection->pagination = $this->pagination;
        }

        return $collection;
    }

    public function merge(CollectionInterface ...$collections): CollectionInterface
    {
        $collection = parent::merge(...$collections);

        if ($collection instanceof self) {
            $collection->pagination = null;
        }

        return $collection;
    }

    public function diff(CollectionInterface $other): CollectionInterface
    {
        $collection = parent::diff($other);

        if ($collection instanceof self) {
            $collection->pagination = null;
        }

        return $collection;
    }

    public function intersect(CollectionInterface $other): CollectionInterface
    {
        $collection = parent::intersect($other);

        if ($collection instanceof self) {
            $collection->pagination = null;
        }

        return $collection;
    }

    private function handlePaginationAfterModification(): void
    {
        if ($this->pagination === null) {
            return;
        }

        $this->recalculatePagination();
    }

    private function recalculatePagination(): void
    {
        if ($this->pagination === null) {
            return;
        }

        $currentCount = $this->count();
        $pageSize = $this->pagination->pageSize;
        $offset =  ($this->pagination->page - 1) * $pageSize;

        $newTotalCount = $offset + $currentCount;
        $newTotalPages = $pageSize > 0 ? (int)ceil($newTotalCount / $pageSize) : 1;
        $currentPage = min($this->pagination->page, max(1, $newTotalPages));

        $this->pagination = new PaginationVO(
            page: $currentPage,
            pageSize: $pageSize,
            totalCount: $newTotalCount,
        );
    }

    public function getPagination(): ?PaginationVO
    {
        return $this->pagination;
    }
}
