<?php

namespace Mfgustav0\Nexti\Entity;

use Mfgustav0\Nexti\Entity\Shared\BaseEntity;

class City extends BaseEntity
{
    /**
     * City code
     */
    public ?string $code;

    /**
     * External city ID
     */
    public ?string $externalId;

    /**
     * External Federal Unit ID
     */
    public ?string $federatedUnitExternalId;

    /**
     * Federated Unit ID
     */
    public int $federatedUnitId;

    /**
     * Federal Unit name
     */
    public ?string $federatedUnitName;

    /**
     * City ID
     */
    public ?int $id;

    /**
     * City Name
     */
    public string $name;

    /**
     * Create new instance from Api
     */
    public static function fromApi(array $data): static
    {
        $entity = new static;

        $entity->code = data_get($data, 'code');
        $entity->externalId = data_get($data, 'externalId');
        $entity->federatedUnitExternalId = data_get($data, 'federatedUnitExternalId');
        $entity->federatedUnitId = data_get($data, 'federatedUnitId');
        $entity->federatedUnitName = data_get($data, 'federatedUnitName');
        $entity->id = data_get($data, 'id');
        $entity->name = data_get($data, 'name');

        return $entity;
    }
}
