<?php

declare(strict_types=1);

namespace App\Domain\Services\Auth\Login;

use App\Domain\ValueObjects\EmailVO;

final readonly class LoginDTO
{
    public function __construct(
        public EmailVO $email,
        public string $password,
    ) {}
}
