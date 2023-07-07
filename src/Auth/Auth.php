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
final class Auth
{
    /** @var self */
    private static $login;

    /** @var string */
    protected $loginUrl;

    /** @var string */
    private $clientId;

    /** @var string */
    private $clientSecret;

    /** @var string */
    protected $grantType = 'client_credentials';

    /** @var string */
    private $token;

    /** @var string */
    private $tokenExpiry;

    private function __construct()
    {
        //
    }

    /**
     * Returns the instance of this class
     *
     * @return self
     */
    public static function login()
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
    public function setClientCredentials()
    {
        $this->clientId = $this->clientId ?? config('celcoin')['client_id'];
        $this->clientSecret = $this->clientSecret ?? config('celcoin')['client_secret'];
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
     * @param string $token
     * @return self
     */
    public function setToken(string $token)
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
     * @return string
     * @throws RequestException
     */
    public function getToken()
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
    public function setTokenExpiry(string $tokenExpiry)
    {
        $this->tokenExpiry = $tokenExpiry;
        return $this;
    }

    /**
     * @return string
     */
    public function getTokenExpiry()
    {
        return $this->tokenExpiry;
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
        $response = $request->post($this->loginUrl, $body)->throw()->json();

        $this->token = $response['access_token'];
        $this->tokenExpiry = now()->addSeconds($response['expires_in'])->unix();

        event(new CelcoinAuthenticatedEvent($this->token, $this->tokenExpiry));
    }

}
