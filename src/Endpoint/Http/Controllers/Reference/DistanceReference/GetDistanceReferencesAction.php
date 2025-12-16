<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Controllers\Reference\DistanceReference;

use App\Application\DTO\Reference\DistanceReferenceDTO;
use App\Application\Enums\Sort\SortDirectionEnum;
use App\Application\UseCases\Query\PaginationQuery;
use App\Application\UseCases\Query\Reference\DistanceReference\GetDistanceReferences\GetDistanceReferencesQuery;
use App\Application\UseCases\Query\Reference\DistanceReference\GetDistanceReferences\GetDistanceReferencesQueryHandler;
use App\Application\UseCases\Query\SortQuery;
use App\Endpoint\Http\Mappers\Pagination\PaginationDTOToPaginationResponseMapper;
use App\Endpoint\Http\Mappers\Reference\DistanceReferenceDTOToDistanceReferenceResponseMapper;
use App\Endpoint\Http\Mappers\Sort\SortRequestToSortQueryMapper;
use App\Endpoint\Http\Requests\Reference\DistanceReference\GetDistanceReferencesRequest;
use App\Endpoint\Http\Requests\Sort\SortRequest;
use App\Endpoint\Http\Responses\Pagination\PaginatedResponse;
use App\Endpoint\Http\Responses\Reference\DistanceReferenceResponse;
use OpenApi\Attributes as OA;
use RR\OpenApi as ROA;
use Spiral\Router\Annotation\Route;

#[OA\Get(path: '/api/references/distances', tags: ['Distance References'])]
#[OA\Parameter(name: 'ids', in: 'query', required: false, schema: new OA\Schema(type: 'array', items: new OA\Items(type: 'string', format: 'uuid')))]
#[OA\Parameter(name: 'fromDistance', in: 'query', required: false, schema: new OA\Schema(type: 'number'))]
#[OA\Parameter(name: 'toDistance', in: 'query', required: false, schema: new OA\Schema(type: 'number'))]
#[OA\Parameter(name: 'distanceTypes', in: 'query', required: false, schema: new OA\Schema(type: 'array', items: new OA\Items(type: 'string')))]
#[OA\Parameter(name: 'page', in: 'query', required: false, schema: new OA\Schema(type: 'integer'))]
#[OA\Parameter(name: 'pageSize', in: 'query', required: false, schema: new OA\Schema(type: 'integer'))]
#[OA\Parameter(name: 'sort', in: 'query', required: false, schema: new OA\Schema(type: 'array', items: new OA\Items(type: 'string')))]
#[ROA\PaginatedResponse(itemsRef: DistanceReferenceResponse::class, itemsProperty: 'data')]
#[ROA\UnauthorizedResponse]
#[ROA\ValidationErrorResponse]
final readonly class GetDistanceReferencesAction
{
    #[Route(route: '/api/references/distances', name: 'references.distances.index', methods: ['GET'], group: 'auth_api')]
    public function __invoke(
        GetDistanceReferencesRequest $request,
        SortRequestToSortQueryMapper $toSortQueryMapper,
        GetDistanceReferencesQueryHandler $handler,
        DistanceReferenceDTOToDistanceReferenceResponseMapper $responseMapper,
        PaginationDTOToPaginationResponseMapper $paginationResponseMapper,
    ): PaginatedResponse {
        $defaultSorts = [new SortQuery(
            field: 'id',
            direction: SortDirectionEnum::desc,
        )];

        $paginatedData = $handler->handle(new GetDistanceReferencesQuery(
            ids: $request->getIds(),
            fromDistance: $request->getFromDistance(),
            toDistance: $request->getToDistance(),
            distanceTypes: $request->getDistanceTypes(),
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
                static fn(DistanceReferenceDTO $distanceReference) => $responseMapper->map($distanceReference),
                $paginatedData->data,
            ),
            pagination: $paginationResponseMapper->map($paginatedData->pagination),
        );
    }
}
