<?php

declare(strict_types=1);

namespace App\Domain\Services\Activity\SyncActivityDetail;

interface GetActivityDetailExternalServiceInterface
{
    public function get(string $accessToken, int $id): ActivityDetailDTO;
}
