<?php

declare(strict_types=1);

namespace App\Application\UseCases\Command\Auth\Register;

final readonly class RegisterCommand
{
    public function __construct(
        public string $code,
        public string $state,
        public string $email,
        public string $password,
    ) {}
}
