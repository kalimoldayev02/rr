<?php

declare(strict_types=1);

namespace App\Domain\Services\OAuthToken\RefreshOAuthToken;

use App\Domain\Entities\OAuthTokenEntity;

interface RefreshOAuthTokenServiceInterface
{
    public function get(OAuthTokenEntity $oAuthTokenEntity): OAuthTokenEntity;
}
