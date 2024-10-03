<?php

namespace Mfgustav0\Nexti;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Mfgustav0\Nexti\Entity\Auth;
use Mfgustav0\Nexti\Exceptions\ClientException;
use Mfgustav0\Nexti\Services\City;
use SensitiveParameter;
use Throwable;

class Client
{
    /**
     * Base Uri
     */
    private string $baseUri = 'https://api.nexti.com';

    /**
     * Http Client
     */
    private ?PendingRequest $httpRequest = null;

    /**
     * Client Id
     */
    private ?string $clientId;

    /**
     * Client Secret
     */
    private ?string $clientSecret;

    /**
     * Access Token
     */
    private ?string $accessToken = null;

    /**
     * Debug
     */
    private bool $debug = false;

    /**
     * Create new instance
     */
    public function __construct(#[SensitiveParameter] ?string $clientId, #[SensitiveParameter] ?string $clientSecret)
    {
        $this->withClientId($clientId)
            ->withClientSecret($clientSecret);
    }

    /**
     * Set Client Id
     */
    public function withClientId(#[SensitiveParameter] ?string $clientId): static
    {
        $this->clientId = $clientId;
        $this->clearHttpClient();

        return $this;
    }

    /**
     * Set Client Secret
     */
    public function withClientSecret(#[SensitiveParameter] ?string $clientSecret): static
    {
        $this->clientSecret = $clientSecret;
        $this->clearHttpClient();

        return $this;
    }

    /**
     * Set client with Debug
     */
    public function withDebug(): static
    {
        $this->debug = true;

        return $this;
    }

    /**
     * Set Client without Debug
     */
    public function withoutDebug(): static
    {
        $this->debug = false;

        return $this;
    }

    /**
     * Return instance of City Service
     */
    public function city(): City
    {
        return new City($this);
    }

    /**
     * Get the HTTP client.
     *
     * @throws ConnectionException
     * @throws ClientException
     */
    public function getHttpClient(): PendingRequest
    {
        if (! $this->httpRequest) {
            $this->authenticateClient();

            $this->httpRequest = Http::baseUrl($this->baseUri)
                ->when($this->accessToken,
                    fn (PendingRequest $request) => $request->withToken($this->accessToken)
                )
                ->when($this->debug,
                    fn (PendingRequest $request) => $request->withOptions(['debug' => true])
                )
                ->retry(3, when: function (Throwable $exception, PendingRequest $request) {
                    if ($exception instanceof RequestException) {
                        if ($exception->getCode() === 401) {
                            $this->authenticateClient();

                            $request->withToken($this->accessToken);

                            return true;
                        }

                        if ($exception->getCode() === 409) {
                            throw ClientException::conflictEntity($exception->response->json());
                        }

                        dd($exception->response->status(), $exception->response->getBody()->getContents());
                    }

                    return $exception instanceof ConnectionException;
                });
        }

        return $this->httpRequest;
    }

    /**
     * Authenticate Client
     *
     * @throws ConnectionException
     * @throws ClientException
     */
    protected function authenticateClient(): void
    {
        if (! $this->clientId || ! $this->clientSecret) {
            throw ClientException::missingCredentials();
        }

        $response = Http::baseUrl($this->baseUri)
            ->asJson()
            ->when($this->debug,
                fn (PendingRequest $request) => $request->withOptions(['debug' => true])
            )
            ->withQueryParameters([
                'grant_type' => 'client_credentials',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
            ])
            ->withBasicAuth($this->clientId, $this->clientSecret)
            ->post('security/oauth/token');

        if (! $response->ok()) {
            throw ClientException::unauthorized();
        }

        $entityAuth = Auth::fromApi($response->json());

        $this->setAccessToken($entityAuth->access_token);
    }

    /**
     * Set Access Token
     */
    private function setAccessToken(?string $accessToken): void
    {
        $this->accessToken = $accessToken;
    }

    /**
     * Clear Http Client
     */
    public function clearHttpClient(): void
    {
        if ($this->httpRequest) {
            unset($this->httpRequest);
        }

        $this->httpRequest = null;
        $this->setAccessToken(null);
    }
}
