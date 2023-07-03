<?php

namespace WeDevBr\Celcoin\Clients;

use Carbon\Carbon;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Enums\HealthCheckPeriodEnum;
use WeDevBr\Celcoin\Enums\HealthCheckTypeEnum;
use WeDevBr\Celcoin\Enums\InstitutionsTypeEnum;

/**
 * Class CelcoinAssistant
 * A API de Recargas Nacionais disponibiliza aos seus usuários a possibilidade de realizar recargas de telefonia e conteúdos digitais listados abaixo:
 * @package WeDevBr\Celcoin
 */
class CelcoinAssistant extends CelcoinBaseApi
{
    const GET_BALANCE = '/v5/merchant/balance';
    const STATUS_CONSULT = '/v5/transactions/status-consult';
    const GET_RECEIPT = '/v5/transactions/receipt/%s';
    const FIND_INSTITUTIONS = '/v5/transactions/institutions';
    const HEALTH_CHECK = '/v5/transactions/healthcheck';
    const GET_BANKS = '/v5/transactions/banks';
    const GET_PENDENCIES_LIST = '/v5/transactions/pendency';

    public function getBalance()
    {
        return $this->get(self::GET_BALANCE);
    }

    public function statusConsult(
        ?int $transactionId = null,
        ?int $externalNSU = null,
        ?string $externalTerminal = null,
        ?Carbon $operationDate = null
    ): mixed {
        return $this->get(
            self::STATUS_CONSULT,
            [
                'transactionId' => $transactionId,
                'externalNSU' => $externalNSU,
                'externalTerminal' => $externalTerminal,
                'operationDate' => !empty($operationDate) ? $operationDate->format("Y-m-d") : null,
            ]
        );
    }

    public function getReceipt(string $transactionId)
    {
        return $this->get(sprintf(self::GET_RECEIPT, $transactionId));
    }

    public function findInstitutions(?InstitutionsTypeEnum $type = null, ?array $uf = null)
    {
        return $this->get(self::FIND_INSTITUTIONS, [
            "Type" => $type?->value,
            "UF" => $uf,
        ]);
    }

    public function healthCheck(?HealthCheckTypeEnum $type = null, ?HealthCheckPeriodEnum $period = null)
    {
        return $this->get(self::HEALTH_CHECK, [
            "type" => $type?->value,
            "period" => $period?->value,
        ]);
    }

    public function getBanks()
    {
        return $this->get(self::GET_BANKS);
    }

    public function getPendenciesList()
    {
        return $this->get(self::GET_PENDENCIES_LIST);
    }
}
