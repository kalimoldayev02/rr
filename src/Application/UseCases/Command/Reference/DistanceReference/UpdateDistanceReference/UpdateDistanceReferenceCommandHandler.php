<?php

declare(strict_types=1);

namespace App\Application\UseCases\Command\Reference\DistanceReference\UpdateDistanceReference;

use App\Application\Enums\Access\PermissionEnum;
use App\Application\Enums\Access\RoleEnum;
use App\Application\Services\Access\AccessService;
use App\Domain\Entities\DistanceReferenceEntity;
use App\Domain\Exceptions\AccessForbiddenException;
use App\Domain\Repositories\DistanceReferenceRepositoryInterface;

final readonly class UpdateDistanceReferenceCommandHandler
{
    public function __construct(
        private AccessService $accessService,
        private DistanceReferenceRepositoryInterface $distanceReferenceRepository,
    ) {}

    public function handle(UpdateDistanceReferenceCommand $command): void
    {
        if (!$this->accessService->can(userId: $command->userId, role: RoleEnum::reference, permission: PermissionEnum::update)) {
            throw new AccessForbiddenException();
        }

        $this->distanceReferenceRepository->update(new DistanceReferenceEntity(
            id: $command->distanceReferenceId,
            distance: $command->distance,
        ));
    }
}
