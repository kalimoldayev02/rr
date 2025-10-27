<?php

declare(strict_types=1);

namespace App\Application\UseCases\Command\Auth\Login;

use App\Application\DTO\Token\TokenDTO;
use App\Domain\Services\Auth\Login\LoginInputDTO;
use App\Domain\Services\Auth\Login\LoginService;
use App\Domain\ValueObjects\EmailVO;

final readonly class LoginCommandHandler
{
    public function __construct(
        private LoginService $loginService,
    ) {}

    public function handle(LoginCommand $command): TokenDTO
    {
        $data = $this->loginService->login(new LoginInputDTO(
            email: new EmailVO($command->email),
            password: $command->password,
        ));

        return new TokenDTO(
            accessToken: $data->accessToken,
            refreshToken: $data->refreshToken,
        );
    }
}
