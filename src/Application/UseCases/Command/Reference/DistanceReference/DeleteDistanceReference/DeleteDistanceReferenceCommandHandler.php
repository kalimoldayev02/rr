<?php

declare(strict_types=1);

namespace App\Application\UseCases\Command\Reference\DistanceReference\DeleteDistanceReference;

use App\Application\Enums\Access\PermissionEnum;
use App\Application\Enums\Access\RoleEnum;
use App\Application\Services\Access\AccessService;
use App\Domain\Exceptions\AccessForbiddenException;
use App\Domain\Repositories\DistanceReferenceRepositoryInterface;

final readonly class DeleteDistanceReferenceCommandHandler
{
    public function __construct(
        private AccessService $accessService,
        private DistanceReferenceRepositoryInterface $distanceReferenceRepository,
    ) {}

    public function handle(DeleteDistanceReferenceCommand $command): void
    {
        if (!$this->accessService->can(userId: $command->userId, role: RoleEnum::reference, permission: PermissionEnum::delete)) {
            throw new AccessForbiddenException();
        }

        $this->distanceReferenceRepository->delete(
            $this->distanceReferenceRepository->getById($command->distanceReferenceId),
        );
    }
}
