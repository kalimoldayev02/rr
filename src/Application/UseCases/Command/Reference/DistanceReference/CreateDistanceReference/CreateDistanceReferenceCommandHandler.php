<?php

declare(strict_types=1);

namespace App\Application\UseCases\Command\Reference\DistanceReference\CreateDistanceReference;

use App\Application\Enums\Access\PermissionEnum;
use App\Application\Enums\Access\RoleEnum;
use App\Application\Services\Access\AccessService;
use App\Domain\Entities\DistanceReferenceEntity;
use App\Domain\Exceptions\AccessForbiddenException;
use App\Domain\Repositories\DistanceReferenceRepositoryInterface;
use App\Domain\ValueObjects\IdVO;

final readonly class CreateDistanceReferenceCommandHandler
{
    public function __construct(
        private AccessService $accessService,
        private DistanceReferenceRepositoryInterface $distanceReferenceRepository,
    ) {}

    public function handle(CreateDistanceReferenceCommand $command): void
    {
        if (!$this->accessService->can(userId: $command->userId, role: RoleEnum::reference, permission: PermissionEnum::create)) {
            throw new AccessForbiddenException();
        }

        $this->distanceReferenceRepository->create(new DistanceReferenceEntity(
            id: new IdVO()->getValue(),
            distance: $command->distance,
        ));
    }
}
