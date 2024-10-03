<?php

namespace Mfgustav0\Nexti\Entity;

use Mfgustav0\Nexti\Entity\Shared\BaseEntity;

class Auth extends BaseEntity
{
    /**
     * Access Token
     */
    public string $access_token;

    /**
     * Token type
     */
    public string $token_type;

    /**
     * Expires in
     */
    public int $expires_in;

    /**
     * User Account Id
     */
    public int $user_account_id;

    /**
     * Scope
     */
    public string $scope;

    /**
     * Language
     */
    public string $language;

    /**
     * Jti
     */
    public string $jti;

    /**
     * Create new instance from Api
     */
    public static function fromApi(array $data): static
    {
        $entity = new static;

        $entity->access_token = data_get($data, 'access_token');
        $entity->token_type = data_get($data, 'token_type');
        $entity->expires_in = intval(data_get($data, 'expires_in', 0));
        $entity->scope = data_get($data, 'scope');
        $entity->user_account_id = intval(data_get($data, 'user_account_id', 0));
        $entity->language = data_get($data, 'language');
        $entity->jti = data_get($data, 'jti');

        return $entity;
    }
}
