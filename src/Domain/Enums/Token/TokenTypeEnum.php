<?php

declare(strict_types=1);

namespace App\Domain\Enums\Token;

enum TokenTypeEnum
{
    case access;
    case refresh;
}
