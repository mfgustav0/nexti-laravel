<?php

namespace Mfgustav0\Nexti\Entity\Shared;

use Illuminate\Support\Collection;

/**
 * @template TEntity of BaseEntity
 */
readonly class ResponsePaginate
{
    /**
     * Total Pages
     */
    public int $totalPages;

    /**
     * Size page
     */
    public int $size;

    /**
     * Number current page
     */
    public int $number;

    /**
     * Is first page
     */
    public bool $first;

    /**
     * Is last page
     */
    public bool $last;

    /**
     * Number of Elements
     */
    public int $numberOfElements;

    /**
     * Total of Elements
     */
    public int $totalElements;

    /**
     * Collection of entity
     *
     * @var Collection<TEntity>
     */
    public Collection $content;

    /**
     * Create new instance
     *
     * @param  class-string<TEntity>  $class
     */
    public function __construct(array $data, string $class)
    {
        $this->totalPages = intval(data_get($data, 'totalPages', 0));
        $this->size = intval(data_get($data, 'size', 0));
        $this->number = intval(data_get($data, 'number', 0));
        $this->first = boolval(data_get($data, 'first', true));
        $this->last = boolval(data_get($data, 'last', true));
        $this->numberOfElements = intval(data_get($data, 'numberOfElements', 0));
        $this->totalElements = intval(data_get($data, 'totalElements', 0));
        $this->content = collect(data_get($data, 'content', []))
            ->filter(fn (array $data) => is_array($data))
            ->map(fn (array $data) => $class::fromApi($data))
            ->values();
    }
}
