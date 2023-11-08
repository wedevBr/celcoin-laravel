<?php

namespace WeDevBr\Celcoin\Auth;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use WeDevBr\Celcoin\Events\CelcoinAuthenticatedEvent;

/**
 * Class Auth
 *
 * @package WeDevBr\Celcoin
 */
class Auth
{
    /** @var self */
    private static $login;

    /** @var ?string */
    protected ?string $loginUrl = null;

    /** @var ?string */
    private ?string $clientId = null;

    /** @var ?string */
    private ?string $clientSecret = null;

    /** @var ?string */
    protected ?string $grantType = 'client_credentials';

    /** @var ?string */
    private ?string $token = null;

    /** @var ?string */
    private ?string $tokenExpiry = null;
    /**
     * @var ?string
     */
    private ?string $mtlsPassphrase = null;
    private ?string $mtlsCert = null;
    private ?string $mtlsKey = null;

    private function __construct()
    {
        //
    }

    /**
     * Returns the instance of this class
     *
     * @return self
     */
    public static function login(): self
    {
        if (is_null(self::$login)) {
            self::$login = new Auth();
        }

        self::$login->loginUrl = config('celcoin')['login_url'];

        return self::$login;
    }

    /**
     * @return self
     */
    public function setClientCredentials(): self
    {
        $this->clientId = $this->clientId ?? config('celcoin')['client_id'];
        $this->clientSecret = $this->clientSecret ?? config('celcoin')['client_secret'];
        $this->mtlsPassphrase = $this->mtlsPassphrase ?? config('celcoin.mtls_passphrase');
        return $this;
    }

    /**
     * @param null|string $clientId
     * @return self
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
        return $this;
    }

    /**
     * @param null|string $clientSecret
     * @return self
     */
    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;
        return $this;
    }

    /**
     * @param string $grantType
     * @return self
     */
    public function setGrantType(string $grantType)
    {
        $this->grantType = $grantType;
        return $this;
    }

    /**
     * @param string $passPhrase
     * @return $this
     */
    public function setPassphrase(string $passPhrase): self
    {
        $this->mtlsPassphrase = $passPhrase;
        return $this;
    }

    /**
     * @param string $token
     * @return self
     */
    public function setToken(string $token): self
    {
        $this->token = $token;
        return $this;
    }

    /**
     * Reset token for new request
     *
     * @return self
     */
    public function resetToken(): self
    {
        $this->token = null;
        return $this;
    }

    /**
     * @return ?string
     * @throws RequestException
     */
    public function getToken(): ?string
    {
        if (now()->unix() > $this->tokenExpiry || !$this->token) {
            $this->auth();
        }

        return $this->token;
    }

    /**
     * @param string $tokenExpiry
     * @return self
     */
    public function setTokenExpiry(string $tokenExpiry): self
    {
        $this->tokenExpiry = $tokenExpiry;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTokenExpiry(): mixed
    {
        return $this->tokenExpiry;
    }

    public function setCertPath(string $path): self
    {
        $this->mtlsCert = $path;
        return $this;
    }

    /**
     * Set the cert.pem file path
     * @param string $path
     * @return self
     */
    public function setKeyPath(string $path): self
    {
        $this->mtlsKey = $path;
        return $this;
    }

    /**
     * @return void
     * @throws RequestException
     */
    private function auth(): void
    {
        $this->setClientCredentials();

        $body = [
            'grant_type' => $this->grantType,
            'client_secret' => $this->clientSecret,
            'client_id' => $this->clientId
        ];

        $request = Http::asForm();
        $options = [];

        if ($this->mtlsCert) {
            $options['cert'] = $this->mtlsCert;
        }

        if ($this->mtlsKey || $this->mtlsPassphrase) {
            $options['ssl_key'] = [];
            if ($this->mtlsKey) {
                $options['ssl_key'][] = $this->mtlsKey;
            }
            if ($this->mtlsPassphrase) {
                $options['ssl_key'][] = $this->mtlsPassphrase;
            }
        }

        if ($options) {
            $request = $request->withOptions($options);
        }

        $response = $request->post($this->loginUrl, $body)->throw()->json();

        $this->token = $response['access_token'];
        $this->tokenExpiry = now()->addSeconds($response['expires_in'])->unix();

        event(new CelcoinAuthenticatedEvent($this->token, $this->tokenExpiry));
    }

}
