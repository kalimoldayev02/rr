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
final class RegisterRequest extends Filter implements HasFilterDefinition
{
    private const int COST = 12;

    #[Post]
    #[OA\Property]
    private readonly string $state;

    #[Post]
    #[OA\Property]
    private readonly string $code;

    #[Post]
    #[OA\Property]
    private readonly string $email;

    #[Post]
    #[OA\Property]
    private readonly string $password;

    public function filterDefinition(): FilterDefinitionInterface
    {
        return new FilterDefinition([
            'code' => ['required', 'string'],
            'state' => ['required', 'string'],
            'email' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
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

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return \password_hash($this->password, PASSWORD_BCRYPT, ['cost' => self::COST]);
    }
}
