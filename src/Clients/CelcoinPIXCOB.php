<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\PIX\COBCreate;
use WeDevBr\Celcoin\Rules\PIX\COBGet;
use WeDevBr\Celcoin\Rules\PIX\COBUpdate;
use WeDevBr\Celcoin\Types\PIX\COB;
use WeDevBr\Celcoin\Types\PIX\COBGet as COBGetInput;

class CelcoinPIXCOB extends CelcoinBaseApi
{
    public const CREATE_COB_PIX_URL = '/pix/v1/collection/immediate';

    public const UPDATE_COB_PIX_URL = '/pix/v1/collection/immediate/%d';

    public const DELETE_COB_PIX_URL = '/pix/v1/collection/immediate/%d';

    public const GET_COB_PIX_URL = '/pix/v1/collection/pi/immediate';

    public const UNLINK_COB_PIX_URL = '/pix/v1/collection/pi/immediate/%d/unlink';

    public const FETCH_COB_PIX_URL = '/pix/v1/collection/immediate/%d';

    public const PAYLOAD_COB_PIX_URL = '/pix/v1/collection/immediate/payload/%s';

    /**
     * @throws RequestException
     */
    final public function createCOBPIX(COB $cob): array
    {
        $body = Validator::validate($cob->toArray(), COBCreate::rules());

        return $this->post(
            self::CREATE_COB_PIX_URL,
            $body
        );
    }

    /**
     * @throws RequestException
     */
    final public function updateCOBPIX(int $transactionId, COB $cob): array
    {
        $body = Validator::validate($cob->toArray(), COBUpdate::rules());

        return $this->put(
            sprintf(self::UPDATE_COB_PIX_URL, $transactionId),
            $body
        );
    }

    /**
     * @throws RequestException
     */
    final public function getCOBPIX(COBGetInput $data): array
    {
        $params = Validator::validate($data->toArray(), COBGet::rules());

        return $this->get(
            sprintf(
                '%s?%s',
                self::GET_COB_PIX_URL,
                http_build_query($params)
            )
        );
    }

    /**
     * @throws RequestException
     */
    final public function deleteCOBPIX(int $transactionId): array
    {
        return $this->delete(
            sprintf(self::UPDATE_COB_PIX_URL, $transactionId)
        );
    }

    /**
     * @throws RequestException
     */
    final public function unlinkCOBPIX(int $transactionId): array
    {
        return $this->patch(
            sprintf(self::UNLINK_COB_PIX_URL, $transactionId)
        );
    }

    /**
     * @throws RequestException
     */
    final public function fetchCOBPIX(int $transactionId): array
    {
        return $this->get(
            sprintf(self::FETCH_COB_PIX_URL, $transactionId)
        );
    }

    /**
     * @throws RequestException
     */
    final public function payloadCOBPIX(string $url): array
    {
        return $this->get(
            sprintf(self::PAYLOAD_COB_PIX_URL, urlencode($url))
        );
    }
}
