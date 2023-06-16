<?php

namespace WeDevBr\Celcoin\Types\ElectronicTransactions;

use WeDevBr\Celcoin\Types\Data;

class SecondAuthenticationData extends Data
{
    public ?string $dataForSecondAuthentication;
    public ?string $textForSecondIdentification;
    public ?bool $useSecondAuthentication;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
