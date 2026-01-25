<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Controllers\Activity;

use App\Application\DTO\Activity\ActivityDTO;
use App\Application\Enums\Sort\SortDirectionEnum;
use App\Application\UseCases\Query\Activity\GetActivities\GetActivitiesQuery;
use App\Application\UseCases\Query\Activity\GetActivities\GetActivitiesQueryHandler;
use App\Application\UseCases\Query\PaginationQuery;
use App\Application\UseCases\Query\SortQuery;
use App\Endpoint\Http\Contexts\UserContext;
use App\Endpoint\Http\Mappers\Activity\ActivityDTOToActivityResponseMapper;
use App\Endpoint\Http\Mappers\Pagination\PaginationDTOToPaginationResponseMapper;
use App\Endpoint\Http\Mappers\Sort\SortRequestToSortQueryMapper;
use App\Endpoint\Http\Requests\Activity\GetActivitiesRequest;
use App\Endpoint\Http\Requests\Sort\SortRequest;
use App\Endpoint\Http\Responses\Activity\ActivityResponse;
use App\Endpoint\Http\Responses\Pagination\PaginatedResponse;
use OpenApi\Attributes as OA;
use RR\OpenApi as ROA;
use Spiral\Router\Annotation\Route;

#[OA\Get(path: '/activities', tags: ['Activities'])]
#[ROA\PaginatedResponse(itemsRef: ActivityResponse::class, itemsProperty: 'data')]
#[ROA\NotFoundResponse]
#[ROA\UnauthorizedResponse]
#[ROA\ValidationErrorResponse]
final readonly class GetActivitiesAction
{
    #[Route(route: '/activities', name: 'athlete.activities.list', methods: ['GET'], group: 'auth_api')]
    public function __invoke(
        UserContext $userContext,
        GetActivitiesRequest $request,
        SortRequestToSortQueryMapper $toSortQueryMapper,
        GetActivitiesQueryHandler $handler,
        ActivityDTOToActivityResponseMapper $responseMapper,
        PaginationDTOToPaginationResponseMapper $paginationResponseMapper,
    ): PaginatedResponse {
        $defaultSorts = [new SortQuery(
            field: 'id',
            direction: SortDirectionEnum::desc,
        )];

        $paginatedData = $handler->handle(new GetActivitiesQuery(
            athleteIds: [$userContext->getId()],
            fromDate: $request->getFromDate(),
            toDate: $request->getToDate(),
            sorts: $request->getSorts() ? \array_map(
                static fn(SortRequest $sortRequest) => $toSortQueryMapper->map($sortRequest),
                $request->getSorts(),
            ) : $defaultSorts,
            pagination: new PaginationQuery(
                page: $request->getPage(),
                pageSize: $request->getLimit(),
            ),
        ));

        return new PaginatedResponse(
            data: \array_map(
                static fn(ActivityDTO $activity) => $responseMapper->map($activity),
                $paginatedData->data,
            ),
            pagination: $paginationResponseMapper->map($paginatedData->pagination),
        );
    }
}
