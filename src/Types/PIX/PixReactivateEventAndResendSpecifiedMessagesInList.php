<?php

namespace WeDevBr\Celcoin\Types\PIX;

use WeDevBr\Celcoin\Types\Data;

class PixReactivateEventAndResendSpecifiedMessagesInList extends Data
{
    public array $transactionsToResend = [];

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
