<?php

namespace Mfgustav0\Nexti\Entity\Shared;

abstract class BaseEntity
{
    /**
     * Create new instance from Api
     */
    abstract public static function fromApi(array $data): static;

    /**
     * Make Entity from paginate
     */
    public static function fromPaginateResponse(array $response): ResponsePaginate
    {
        return new ResponsePaginate($response, static::class);
    }

    /**
     * To Array
     */
    public function toArray(bool $withNotNull = true): array
    {
        return array_filter(
            array_map(
                function (mixed $item): mixed {
                    if (is_object($item) && method_exists($item, 'toArray')) {
                        return $item->toArray();
                    }

                    return $item;
                }, get_object_vars($this)
            ),
            function (mixed $item) use ($withNotNull) {

                if ($withNotNull) {
                    return ! is_null($item);
                }

                return true;
            }
        );
    }
}
