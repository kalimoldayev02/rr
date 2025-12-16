<?php

declare(strict_types=1);

namespace src\Application\Enums\Access;

enum PermissionEnum
{
    case create;
    case edit;
    case delete;
}
