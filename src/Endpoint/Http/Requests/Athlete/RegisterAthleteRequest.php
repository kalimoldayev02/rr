<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Requests\Athlete;

use OpenApi\Attributes as OA;
use Spiral\Filters\Attribute\Input\Post;
use Spiral\Filters\Model\Filter;
use Spiral\Filters\Model\FilterDefinitionInterface;
use Spiral\Filters\Model\HasFilterDefinition;
use Spiral\Validation\Laravel\FilterDefinition;

#[OA\Schema]
final class RegisterAthleteRequest extends Filter implements HasFilterDefinition
{
    #[Post]
    #[OA\Property]
    private readonly string $state;
    #[Post]
    #[OA\Property]
    private readonly string $code;

    public function filterDefinition(): FilterDefinitionInterface
    {
        return new FilterDefinition([
            'code' => ['required', 'string'],
            'state' => ['required', 'string'],
        ]);
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getCode(): string
    {
        return $this->code;
    }
}
