<?php

namespace Mfgustav0\Nexti\Entity\Shared;

/**
 * @template TEntity of BaseEntity
 */
readonly class Response
{
    /**
     * Comments
     *
     * @var array<string>
     */
    public array $comments;

    /**
     * Id
     */
    public ?int $id;

    /**
     * Message
     */
    public ?string $message;

    /**
     * Value
     */
    public ?BaseEntity $value;

    /**
     * Create new instance
     *
     * @param  class-string<TEntity>  $class
     */
    public static function fromApi(array $data, string $class): static
    {
        $entity = new static;

        $entity->comments = data_get($data, 'comments', []);
        $entity->id = data_get($data, 'id');
        $entity->message = data_get($data, 'message');
        if ($value = data_get($data, 'value', [])) {
            $entity->value = $class::fromApi($value);
        }

        return $entity;
    }
}
