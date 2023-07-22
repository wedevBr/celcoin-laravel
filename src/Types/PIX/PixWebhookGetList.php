<?php

namespace WeDevBr\Celcoin\Types\PIX;

use WeDevBr\Celcoin\Types\Data;

class PixWebhookGetList extends Data
{
    public string $dateFrom;
    public string $dateTo;
    public int $limit;
    public int $start;
    public bool $onlyPending;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
