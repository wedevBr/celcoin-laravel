<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\BAAS\BAASGetTEFTransfer;
use WeDevBr\Celcoin\Rules\BAAS\BAASTEFTransfer;
use WeDevBr\Celcoin\Rules\BAAS\TEDTransfer as BAASTEDTransfer;
use WeDevBr\Celcoin\Types\BAAS\TEDTransfer;
use WeDevBr\Celcoin\Types\BAAS\TEFTransfer;

/**
 * Class CelcoinBAASTED
 * API de BaaS possui o modulo de TED, esse modulo contempla os seguintes serviços Transferência via TED e Consultar Status de uma Transferência TED
 */
class CelcoinBAASTED extends CelcoinBaseApi
{
    public const TRANSFER_ENDPOINT = '/baas-wallet-transactions-webservice/v1/spb/transfer';

    public const GET_STATUS_TRANSFER_ENDPOINT = '/baas-wallet-transactions-webservice/v1/spb/transfer/status';

    public const INTERNAL_TRANSFER_ENDPOINT = '/baas-wallet-transactions-webservice/v1/wallet/internal/transfer';

    public const GET_STATUS_INTERNAL_TRANSFER_ENDPOINT = '/baas-wallet-transactions-webservice/v1/wallet/internal/transfer/status';

    /**
     * @throws RequestException
     */
    public function transfer(TEDTransfer $data): mixed
    {
        $body = Validator::validate($data->toArray(), BAASTEDTransfer::rules());

        return $this->post(
            self::TRANSFER_ENDPOINT,
            $body
        );
    }

    /**
     * @throws RequestException
     */
    public function getStatusTransfer(?string $id = null, ?string $clientCode = null): mixed
    {
        return $this->get(
            self::GET_STATUS_TRANSFER_ENDPOINT,
            [
                'id' => $id,
                'clientCode' => $clientCode,
            ]
        );
    }

    /**
     * @throws RequestException
     */
    public function internalTransfer(TEFTransfer $data): mixed
    {
        $body = Validator::validate($data->toArray(), BAASTEFTransfer::rules());

        return $this->post(self::INTERNAL_TRANSFER_ENDPOINT, $body);
    }

    /**
     * @throws RequestException
     */
    public function getStatusInternalTransfer(
        ?string $id = null,
        ?string $clientRequestId = null,
        ?string $endToEndId = null
    ): mixed {
        $query = Validator::validate(
            array_filter(
                [
                    'Id' => $id,
                    'ClientRequestId' => $clientRequestId,
                    'EndToEndId' => $endToEndId,
                ]
            ),
            BAASGetTEFTransfer::rules()
        );

        return $this->get(
            self::GET_STATUS_INTERNAL_TRANSFER_ENDPOINT,
            $query
        );
    }
}
