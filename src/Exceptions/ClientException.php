<?php

namespace Mfgustav0\Nexti\Exceptions;

use Exception;
use Illuminate\Http\Client\RequestException;

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
     * From Request Exception
     */
    public static function fromRequestException(RequestException $exception): static
    {
        $response = $exception->response->json();

        $message = [
            $response['message'] ?? null,
        ];

        if (isset($response['comments']) && count($response['comments']) > 0) {
            $comments = $response['comments'][0] ?? null;

            if ($comments) {
                $message[] = $comments;
            }
        }

        return new static(
            message: $message ? implode('; ', $message) : $exception->response->reason(),
            code: $exception->getCode()
        );
    }
}
