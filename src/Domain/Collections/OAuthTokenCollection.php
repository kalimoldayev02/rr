<?php

declare(strict_types=1);

namespace App\Domain\Collections;

use App\Domain\Entities\OAuthTokenEntity;
use App\Domain\Enums\Token\OAuthTokenProviderEnum;
use Ramsey\Collection\AbstractCollection;

final class OAuthTokenCollection extends AbstractCollection
{
    public function getType(): string
    {
        return OAuthTokenEntity::class;
    }

    public function getByProvider(OAuthTokenProviderEnum $provider): ?OAuthTokenEntity
    {
        /** @var OAuthTokenEntity $oAuthTokenEntity */
        foreach ($this->toArray() as $oAuthTokenEntity) {
            if ($oAuthTokenEntity->getProvider() === $provider) {
                return $oAuthTokenEntity;
            }
        }
        return null;
    }

    public function replace(OAuthTokenEntity $oAuthTokenEntity): void
    {
        foreach ($this->toArray() as $key => $item) {
            if ($item->getProvider() === $oAuthTokenEntity->getProvider()) {
                $this->data[$key] = $oAuthTokenEntity;
            }
        }
    }
}
