<?php

namespace WeDevBr\Celcoin\Common;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use WeDevBr\Celcoin\Auth\Auth;
use WeDevBr\Celcoin\Types\KYC\KycDocument;

class CelcoinBaseApi
{
    public const CACHE_NAME = 'celcoin_login_token';

    /** @var Cache */
    public Cache $cache;

    /** @var string */
    public ?string $api_url;

    /** @var string */
    private ?string $token = null;

    /** @var string */
    private ?string $mtlsCert;

    /** @var string */
    private ?string $mtlsKey;

    /** @var string */
    private ?string $mtlsPassphrase;

    public function __construct(?string $mtlsPassphrase = null)
    {
        $this->api_url = config('celcoin')['api_url'];
        $this->mtlsCert = config('celcoin')['mtls_cert_path'] ?? null;
        $this->mtlsKey = config('celcoin')['mtls_key_path'] ?? null;
        $this->mtlsPassphrase = $mtlsPassphrase ?? config('celcoin')['mtls_passphrase'] ?? null;
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    public function getToken(): string|null
    {
        if (Cache::has($this::CACHE_NAME)) {
            $this->token = Cache::get($this::CACHE_NAME);
        } else {
            $this->token = Auth::login()->getToken();
            Cache::put($this::CACHE_NAME, $this->token, 2400);
        }
        return $this->token;
    }

    public function setPassphrase(string $passPhrase): self
    {
        $this->mtlsPassphrase = $passPhrase;
        return $this;
    }

    /**
     * @throws RequestException
     */
    protected function get(string $endpoint, array|string|null $query = null, $responseJson = true)
    {
        $token = $this->getToken() ?? Auth::login()->getToken();
        $request = Http::withToken($token)
            ->withHeaders([
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]);

        if ($this->mtlsCert && $this->mtlsKey && $this->mtlsPassphrase) {
            $request = $this->setRequestMtls($request);
        }

        $request = $request->get($this->getFinalUrl($endpoint), $query)
            ->throw();

        return ($responseJson) ? $request->json() : $request;
    }

    /**
     * @throws RequestException
     */
    protected function post(string $endpoint, array $body = [])
    {
        $token = $this->getToken() ?? Auth::login()->getToken();
        $request = Http::withToken($token)
            ->withHeaders([
                'accept' => 'application/json',
                'content-type' => 'application/json'
            ]);

        if ($this->mtlsCert && $this->mtlsKey && $this->mtlsPassphrase) {
            $request = $this->setRequestMtls($request);
        }

        foreach ($body as $field => $document) {
            if ($document instanceof KycDocument) {
                $request->attach($field, $document->getContents(), $document->getFileName());
            }
        }

        return $request->post($this->getFinalUrl($endpoint), $body)
            ->throw()
            ->json();
    }

    /**
     * @throws RequestException
     */
    protected function put(
        string $endpoint,
        ?array $body = null,
    ): mixed
    {
        $token = $this->getToken() ?? Auth::login()->getToken();
        $request = Http::withToken($token)
            ->withHeaders([
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]);

        if ($this->mtlsCert && $this->mtlsKey && $this->mtlsPassphrase) {
            $request = $this->setRequestMtls($request);
        }

        return $request->put($this->getFinalUrl($endpoint), $body)
            ->throw()
            ->json();
    }

    /**
     * @throws RequestException
     */
    protected function patch(
        string $endpoint,
        ?array $body = null,
        bool $asJson = false
    ): mixed
    {
        $body_format = $asJson ? 'json' : 'form_params';
        $token = $this->getToken() ?? Auth::login()->getToken();
        $request = Http::withToken($token)
            ->bodyFormat($body_format)
            ->withHeaders([
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]);

        if ($this->mtlsCert && $this->mtlsKey && $this->mtlsPassphrase) {
            $request = $this->setRequestMtls($request);
        }

        return $request->patch($this->getFinalUrl($endpoint), $body)
            ->throw()
            ->json();
    }

    /**
     * @throws RequestException
     */
    protected function delete(string $endpoint, ?array $body = null): mixed
    {
        $token = $this->getToken() ?? Auth::login()->getToken();
        $request = Http::withToken($token);

        if ($this->mtlsCert && $this->mtlsKey && $this->mtlsPassphrase) {
            $request = $this->setRequestMtls($request);
        }

        return $request->delete($this->getFinalUrl($endpoint), $body)
            ->throw()
            ->json();
    }

    /**
     * @return PendingRequest
     */
    protected function setRequestMtls(PendingRequest $request): PendingRequest
    {
        return $request->withOptions([
            'cert' => $this->mtlsCert,
            'ssl_key' => [$this->mtlsKey, $this->mtlsPassphrase]
        ]);
    }

    protected function getFinalUrl(string $endpoint): string
    {
        $characters = " \t\n\r\0\x0B/";
        return rtrim($this->api_url, $characters) . "/" . ltrim($endpoint, $characters);
    }
}
