<?php

namespace Mfgustav0\Nexti\Services\Shared;

use Mfgustav0\Nexti\Client;
use Mfgustav0\Nexti\Entity\Shared\BaseEntity;
use Mfgustav0\Nexti\Entity\Shared\Response;
use Mfgustav0\Nexti\Entity\Shared\ResponsePaginate;

/**
 * @template TEntity of BaseEntity
 */
abstract class BaseService
{
    /**
     * Create new instance
     */
    public function __construct(
        protected Client $client
    ) {}

    /**
     * Transform from Response
     *
     * @param  class-string<TEntity>  $class
     */
    protected function transformFromResponse(array $response, string $class): Response
    {
        return Response::fromApi($response, $class);
    }

    /**
     * Transform from Paginate
     *
     * @param  class-string<TEntity>  $class
     */
    protected function transformFromPaginate(mixed $response, string $class): ResponsePaginate
    {
        return $class::fromPaginateResponse($response);
    }
}
