<?php

namespace Mfgustav0\Nexti\Exceptions;

use Exception;

class ClientException extends Exception
{
    /**
     * Missing Credentials
     */
    public static function missingCredentials(): static
    {
        return new static('Client ID and Client secret are required.', 401);
    }

    /**
     * Unauthorized
     */
    public static function unauthorized(): static
    {
        return new static('Unauthorized', 401);
    }

    /**
     * Conflict Entity
     */
    public static function conflictEntity(array $response): static
    {
        $message = [
            $response['message'] ?? null,
        ];

        if (isset($response['comments']) && count($response['comments']) > 0) {
            $comments = $response['comments'][0] ?? null;

            if ($comments) {
                $message[] = $comments;
            }
        }

        return new static($message ? implode('; ', $message) : 'Conflict Entity', 409);
    }
}
