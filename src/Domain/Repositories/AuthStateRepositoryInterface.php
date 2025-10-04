<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

interface AuthStateRepositoryInterface
{
    public function generateState(): string;

    public function create(string $state): void;

    public function delete(string $state): void;

    public function exists(string $state): bool;
}
