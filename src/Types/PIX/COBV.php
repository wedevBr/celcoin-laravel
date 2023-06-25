<?php

namespace WeDevBr\Celcoin\Types\PIX;

class COBV extends COB
{
    public int $expirationAfterPayment;
    public string $duedate;
    public AmountDicount $amountDicount;
    public AmountAbatement $amountAbatement;
    public AmountFine $amountFine;
    public AmountInterest $amountInterest;
    public Receiver $receiver;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}