<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Controllers\Event;

use App\Application\DTO\Event\EventDTO;
use App\Application\Enums\Sort\SortDirectionEnum;
use App\Application\UseCases\Query\Event\GetEvents\GetEventsQuery;
use App\Application\UseCases\Query\Event\GetEvents\GetEventsQueryHandler;
use App\Application\UseCases\Query\PaginationQuery;
use App\Application\UseCases\Query\SortQuery;
use App\Endpoint\Http\Mappers\Event\EventDTOToEventResponseMapper;
use App\Endpoint\Http\Mappers\Pagination\PaginationDTOToPaginationResponseMapper;
use App\Endpoint\Http\Mappers\Sort\SortRequestToSortQueryMapper;
use App\Endpoint\Http\Requests\Event\GetEventsRequest;
use App\Endpoint\Http\Requests\Sort\SortRequest;
use App\Endpoint\Http\Responses\Event\EventResponse;
use App\Endpoint\Http\Responses\Pagination\PaginatedResponse;
use OpenApi\Attributes as OA;
use RR\OpenApi as ROA;
use Spiral\Router\Annotation\Route;

#[OA\Get(path: '/api/events', tags: ['Events'])]
#[OA\Parameter(name: 'ids', in: 'query', required: false, schema: new OA\Schema(type: 'array', items: new OA\Items(type: 'string', format: 'uuid')))]
#[OA\Parameter(name: 'clubIds', in: 'query', required: false, schema: new OA\Schema(type: 'array', items: new OA\Items(type: 'string', format: 'uuid')))]
#[OA\Parameter(name: 'athleteIds', in: 'query', required: false, schema: new OA\Schema(type: 'array', items: new OA\Items(type: 'string', format: 'uuid')))]
#[OA\Parameter(name: 'fromDate', in: 'query', required: false, schema: new OA\Schema(type: 'string', format: 'date-time'))]
#[OA\Parameter(name: 'toDate', in: 'query', required: false, schema: new OA\Schema(type: 'string', format: 'date-time'))]
#[OA\Parameter(name: 'title', in: 'query', required: false, schema: new OA\Schema(type: 'string'))]
#[OA\Parameter(name: 'page', in: 'query', required: false, schema: new OA\Schema(type: 'integer'))]
#[OA\Parameter(name: 'pageSize', in: 'query', required: false, schema: new OA\Schema(type: 'integer'))]
#[OA\Parameter(name: 'sort', in: 'query', required: false, schema: new OA\Schema(type: 'array', items: new OA\Items(type: 'string')))]
#[ROA\PaginatedResponse(itemsRef: EventResponse::class, itemsProperty: 'data')]
#[ROA\UnauthorizedResponse]
#[ROA\ValidationErrorResponse]
final readonly class GetEventsAction
{
    #[Route(route: '/api/events', name: 'events.list', methods: ['GET'], group: 'auth_api')]
    public function __invoke(
        GetEventsRequest $request,
        SortRequestToSortQueryMapper $toSortQueryMapper,
        GetEventsQueryHandler $handler,
        EventDTOToEventResponseMapper $responseMapper,
        PaginationDTOToPaginationResponseMapper $paginationResponseMapper,
    ): PaginatedResponse {
        $defaultSorts = [new SortQuery(
            field: 'id',
            direction: SortDirectionEnum::desc,
        )];

        $paginatedData = $handler->handle(new GetEventsQuery(
            ids: $request->getIds(),
            clubIds: $request->getClubIds(),
            athleteIds: $request->getAthleteIds(),
            fromDate: $request->getFromDate(),
            toDate: $request->getToDate(),
            title: $request->getTitle(),
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
                static fn(EventDTO $event) => $responseMapper->map($event),
                $paginatedData->data,
            ),
            pagination: $paginationResponseMapper->map($paginatedData->pagination),
        );
    }
}
