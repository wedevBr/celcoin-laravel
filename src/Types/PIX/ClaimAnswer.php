<?php

namespace WeDevBr\Celcoin\Types\PIX;

use WeDevBr\Celcoin\Enums\ClaimAnswerReasonEnum;
use WeDevBr\Celcoin\Types\Data;

class ClaimAnswer extends Data
{
    public string $id;

    public ClaimAnswerReasonEnum $reason;

    public function __construct(array $data)
    {
        parent::__construct($data);
        $this->reason = ClaimAnswerReasonEnum::from($data['reason']);
    }
}
