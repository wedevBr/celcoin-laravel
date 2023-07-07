<?php

namespace WeDevBr\Celcoin\Types\PIX;

use WeDevBr\Celcoin\Types\Data;

class Merchant extends Data
{
    public string $name;
    public string $city;
    public string $postalCode;
    public string $merchantCategoryCode;

    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
