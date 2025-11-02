<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Requests\Auth;

use OpenApi\Attributes as OA;
use Spiral\Filters\Attribute\Input\Post;
use Spiral\Filters\Model\Filter;
use Spiral\Filters\Model\FilterDefinitionInterface;
use Spiral\Filters\Model\HasFilterDefinition;
use Spiral\Validation\Laravel\FilterDefinition;

#[OA\Schema]
final class LogoutRequest extends Filter implements HasFilterDefinition
{
    #[Post]
    #[OA\Property]
    private readonly string $accessToken;

    #[Post]
    #[OA\Property]
    private readonly string $refreshToken;

    public function filterDefinition(): FilterDefinitionInterface
    {
        return new FilterDefinition([
            'accessToken' => ['required', 'string'],
            'refreshToken' => ['required', 'string'],
        ]);
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }
}
