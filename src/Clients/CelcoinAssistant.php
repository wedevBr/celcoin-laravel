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
 */
class CelcoinAssistant extends CelcoinBaseApi
{
    public const GET_BALANCE_ENDPOINT = '/v5/merchant/balance';

    public const STATUS_CONSULT_ENDPOINT = '/v5/transactions/status-consult';

    public const GET_RECEIPT_ENDPOINT = '/v5/transactions/receipt/%s';

    public const FIND_INSTITUTIONS_ENDPOINT = '/v5/transactions/institutions';

    public const HEALTH_CHECK_ENDPOINT = '/v5/transactions/healthcheck';

    public const GET_BANKS_ENDPOINT = '/v5/transactions/banks';

    public const GET_PENDENCIES_LIST_ENDPOINT = '/v5/transactions/pendency';

    public function getBalance()
    {
        return $this->get(self::GET_BALANCE_ENDPOINT);
    }

    public function statusConsult(
        ?int $transactionId = null,
        ?int $externalNSU = null,
        ?string $externalTerminal = null,
        ?Carbon $operationDate = null
    ): mixed {
        return $this->get(
            self::STATUS_CONSULT_ENDPOINT,
            [
                'transactionId' => $transactionId,
                'externalNSU' => $externalNSU,
                'externalTerminal' => $externalTerminal,
                'operationDate' => ! empty($operationDate) ? $operationDate->format('Y-m-d') : null,
            ]
        );
    }

    public function getReceipt(string $transactionId)
    {
        return $this->get(sprintf(self::GET_RECEIPT_ENDPOINT, $transactionId));
    }

    public function findInstitutions(?InstitutionsTypeEnum $type = null, ?array $uf = null)
    {
        return $this->get(self::FIND_INSTITUTIONS_ENDPOINT, [
            'Type' => $type?->value,
            'UF' => $uf,
        ]);
    }

    public function healthCheck(?HealthCheckTypeEnum $type = null, ?HealthCheckPeriodEnum $period = null)
    {
        return $this->get(self::HEALTH_CHECK_ENDPOINT, [
            'type' => $type?->value,
            'period' => $period?->value,
        ]);
    }

    public function getBanks()
    {
        return $this->get(self::GET_BANKS_ENDPOINT);
    }

    public function getPendenciesList()
    {
        return $this->get(self::GET_PENDENCIES_LIST_ENDPOINT);
    }
}
