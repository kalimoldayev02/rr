<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Entities\OAuthTokenEntity;

interface OAuthTokenRepositoryInterface
{
    public function create(OAuthTokenEntity $oauthToken): void;

    public function update(OAuthTokenEntity $oauthToken): void;
}
