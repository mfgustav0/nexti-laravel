<?php

namespace Mfgustav0\Nexti\Services;

use Illuminate\Http\Client\ConnectionException;
use Mfgustav0\Nexti\Entity\City as CityEntity;
use Mfgustav0\Nexti\Entity\Shared\Response;
use Mfgustav0\Nexti\Entity\Shared\ResponsePaginate;
use Mfgustav0\Nexti\Exceptions\ClientException;
use Mfgustav0\Nexti\Services\Shared\BaseService;

class City extends BaseService
{
    /**
     * Get All Cities
     *
     * @throws ConnectionException|ClientException
     */
    public function getAllCities(int $page = 0, int $size = 10, ?string $filter = null): ResponsePaginate
    {
        $response = $this->client->getHttpClient()
            ->withQueryParameters([
                'page' => $page,
                'size' => $size,
                'filter' => $filter,
            ])
            ->get('cities/all')
            ->json();

        return $this->transformFromPaginate($response, CityEntity::class);
    }

    /**
     * Create new city
     *
     * @throws ConnectionException|ClientException
     */
    public function createCity(CityEntity $entity): Response
    {
        $response = $this->client->getHttpClient()
            ->asJson()
            ->post('cities', $entity->toArray())
            ->json();

        return $this->transformFromResponse($response, CityEntity::class);
    }

    /**
     * Get a single city
     *
     * @throws ConnectionException|ClientException
     */
    public function getCityByExternalId(string $externalid): Response
    {
        $response = $this->client->getHttpClient()
            ->get("cities/externalid/$externalid")
            ->json();

        return $this->transformFromResponse($response, CityEntity::class);
    }

    /**
     * Get a single city
     *
     * @throws ConnectionException|ClientException
     */
    public function getCityById(int $cityId): Response
    {
        $response = $this->client->getHttpClient()
            ->get("cities/$cityId")
            ->json();

        return $this->transformFromResponse($response, CityEntity::class);
    }

    /**
     * Get lists the cities by the external ID of a federated unit
     *
     * @throws ConnectionException|ClientException
     */
    public function getCitiesFromFederateUnitExternalId(string $federatedUnitExternalId, int $page = 1, int $size = 10): ResponsePaginate
    {
        $response = $this->client->getHttpClient()
            ->withQueryParameters([
                'page' => $page,
                'size' => $size,
            ])
            ->get("cities/federatedunit/externalid/$federatedUnitExternalId")
            ->json();

        return $this->transformFromPaginate($response, CityEntity::class);
    }

    /**
     * Get list the cities of a federated unit
     *
     * @throws ConnectionException|ClientException
     */
    public function getCitiesFromFederateUnitId(int $federatedUnitId, int $page = 0, int $size = 10): ResponsePaginate
    {
        $response = $this->client->getHttpClient()
            ->withQueryParameters([
                'page' => $page,
                'size' => $size,
            ])
            ->get("cities/federatedunit/$federatedUnitId")
            ->json();

        return $this->transformFromPaginate($response, CityEntity::class);
    }

    /**
     * Update city by Id
     *
     * @throws ConnectionException|ClientException
     */
    public function updateCityById(CityEntity $entity): Response
    {
        $response = $this->client->getHttpClient()
            ->asJson()
            ->put("cities/$entity->id", $entity->toArray())
            ->json();

        return $this->transformFromResponse($response, CityEntity::class);
    }

    /**
     * Delete city by Id
     *
     * @throws ConnectionException|ClientException
     */
    public function deleteCityById(int $cityId): Response
    {
        $response = $this->client->getHttpClient()
            ->asJson()
            ->delete("cities/$cityId")
            ->json();

        return $this->transformFromResponse($response, CityEntity::class);
    }
}
