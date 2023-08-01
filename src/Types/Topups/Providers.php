<?php

namespace WeDevBr\Celcoin\Types\Topups;

use WeDevBr\Celcoin\Enums\TopupProvidersCategoryEnum;
use WeDevBr\Celcoin\Enums\TopupProvidersTypeEnum;
use WeDevBr\Celcoin\Types\Data;

class Providers extends Data
{
    public int $stateCode;
    public TopupProvidersTypeEnum $type;
    public TopupProvidersCategoryEnum $category;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
