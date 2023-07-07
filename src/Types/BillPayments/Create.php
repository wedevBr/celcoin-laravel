<?php

namespace WeDevBr\Celcoin\Types\BillPayments;

use WeDevBr\Celcoin\Types\Data;

/**
 *
 * @package WeDevBr\Celcoin\Types\BillPayments
 */
class Create extends Data
{
    public ?int $externalNSU;
    public ?string $externalTerminal;
    public string $cpfcnpj;
    public BillData $billData;
    public ?InfoBearer $infoBearer;
    public BarCode $barCode;
    public ?string $dueDate;
    public ?int $transactionIdAuthorize;

    public function __construct(array $data = [])
    {
        $data['billData'] = new BillData($data['billData'] ?? []);
        $data['infoBearer'] = new InfoBearer($data['infoBearer'] ?? []);
        $data['barCode'] = new BarCode($data['barCode'] ?? []);
        parent::__construct($data);
    }
}
