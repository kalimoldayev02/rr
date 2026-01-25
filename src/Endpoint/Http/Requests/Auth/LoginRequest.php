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
final class LoginRequest extends Filter implements HasFilterDefinition
{
    #[Post]
    #[OA\Property]
    private readonly string $email;

    #[Post]
    #[OA\Property]
    private readonly string $password;

    public function filterDefinition(): FilterDefinitionInterface
    {
        return new FilterDefinition([
            'email' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6'],
        ]);
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
