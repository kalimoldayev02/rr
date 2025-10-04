<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Responses;

trait JsonSerializableTrait
{
    public function jsonSerialize(): array
    {
        return (array) $this;
    }
}
