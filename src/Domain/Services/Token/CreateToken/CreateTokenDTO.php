<?php

declare(strict_types=1);

namespace App\Domain\Services\Token\CreateToken;

use App\Domain\Enums\Token\TokenTypeEnum;
use App\Domain\ValueObjects\TokenVO;
use Ramsey\Uuid\UuidInterface;

final readonly class CreateTokenDTO
{
    public function __construct(
        public UuidInterface $userId,
        public TokenTypeEnum $type,
        public TokenVO $tokenVO,
    ) {}
}
