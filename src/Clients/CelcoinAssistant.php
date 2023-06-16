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
    public function getBalance()
    {
        return $this->get("/v5/merchant/balance");
    }

    public function statusConsult(
        ?int $transactionId = null,
        ?int $externalNSU = null,
        ?string $externalTerminal = null,
        ?Carbon $operationDate = null
    ): mixed {
        return $this->get(
            "/v5/transactions/status-consult",
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
        return $this->get("/v5/transactions/receipt/{$transactionId}");
    }

    public function findInstitutions(?InstitutionsTypeEnum $type = null, ?array $uf = null)
    {
        return $this->get("/v5/transactions/institutions", [
            "Type" => $type?->value,
            "UF" => $uf,
        ]);
    }

    public function healthCheck(?HealthCheckTypeEnum $type = null, ?HealthCheckPeriodEnum $period = null)
    {
        return $this->get("/v5/transactions/healthcheck", [
            "type" => $type?->value,
            "period" => $period?->value,
        ]);
    }

    public function getBanks()
    {
        return $this->get("/v5/transactions/banks");
    }

    public function getPendenciesList()
    {
        return $this->get("/v5/transactions/pendency");
    }
}
