<?php

namespace WeDevBr\Celcoin\Types\DDA;

use WeDevBr\Celcoin\Types\Data;

class OAuthTwo extends Data
{
    public ?string $endpoint;
    public ?string $grantType;
    public ?string $clientId;
    public ?string $clientSecret;
    public ?string $scope;
    public ?string $state;
    public ?string $code;
    public ?string $refreshToken;
    public ?string $contentType;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
