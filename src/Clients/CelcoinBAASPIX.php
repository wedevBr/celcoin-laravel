<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\BAAS\PixCashOut as BAASPixCashOut;
use WeDevBr\Celcoin\Rules\BAAS\RefundPix as BAASRefundPix;
use WeDevBr\Celcoin\Rules\BAAS\RegisterPixKey as BAASRegisterPixKey;
use WeDevBr\Celcoin\Types\BAAS\PixCashOut;
use WeDevBr\Celcoin\Types\BAAS\RefundPix;
use WeDevBr\Celcoin\Types\BAAS\RegisterPixKey;

/**
 * Class CelcoinBAASPIX
 * API de Pix do BaaS possui o modulo de Pix Cash-out, através desse modulo você consegue realizar as seguintes operações:
 * @package WeDevBr\Celcoin
 */
class CelcoinBAASPIX extends CelcoinBaseApi
{

    const CASH_OUT_ENDPOINT = '/baas-wallet-transactions-webservice/v1/pix/payment';
    const GET_PARTICIPANT_ENDPOINT = '/baas-wallet-transactions-webservice/v1/pix/participant';
    const GET_EXTERNAL_KEY_ENDPOINT = '/celcoin-baas-pix-dict-webservice/v1/pix/dict/entry/external/%s';
    const STATUS_PIX_ENDPOINT = '/baas-wallet-transactions-webservice/v1/pix/payment/status';
    const REGISTER_PIX_KEY_ENDPOINT = '/celcoin-baas-pix-dict-webservice/v1/pix/dict/entry';
    const SEARCH_PIX_KEY_ENDPOINT = '/celcoin-baas-pix-dict-webservice/v1/pix/dict/entry/%s';
    const DELETE_PIX_KEY_ENDPOINT = '/celcoin-baas-pix-dict-webservice/v1/pix/dict/entry/%s';
    const REFUND_PIX_ENDPOINT = '/baas-wallet-transactions-webservice/v1/pix/reverse';
    const STATUS_REFUND_PIX_ENDPOINT = '/baas-wallet-transactions-webservice/v1/pix/reverse/status';

    /**
     * @throws RequestException
     */
    public function cashOut(PixCashOut $data)
    {
        $body = Validator::validate($data->toArray(), BAASPixCashOut::rules($data->initiationType->value));
        return $this->post(
            self::CASH_OUT_ENDPOINT,
            $body
        );
    }

    public function getParticipant(?string $ISPB = null, ?string $name = null)
    {
        return $this->get(
            self::GET_PARTICIPANT_ENDPOINT,
            [
                'ISPB' => $ISPB,
                'Name' => $name,
            ]
        );
    }

    public function getExternalPixKey(string $account, string $key)
    {
        return $this->get(
            sprintf(self::GET_EXTERNAL_KEY_ENDPOINT, $account),
            [
                'key' => $key,
            ]
        );
    }

    public function statusPix(?string $id = null, ?string $clientCode = null, ?string $endToEndId = null)
    {
        return $this->get(
            self::STATUS_PIX_ENDPOINT,
            [
                'id' => $id,
                'clientCode' => $clientCode,
                'endToEndId' => $endToEndId,
            ]
        );
    }

    public function registerPixKey(RegisterPixKey $data)
    {
        $body = Validator::validate($data->toArray(), BAASRegisterPixKey::rules());
        return $this->post(
            self::REGISTER_PIX_KEY_ENDPOINT,
            $body
        );
    }

    public function searchPixKey(string $account)
    {
        return $this->get(
            sprintf(self::SEARCH_PIX_KEY_ENDPOINT, $account)
        );
    }

    public function deletePixKey(string $account, string $key)
    {
        return $this->delete(
            sprintf(self::DELETE_PIX_KEY_ENDPOINT, $key),
            [
                'account' => $account,
            ]
        );
    }

    public function refundPix(RefundPix $data)
    {
        $body = Validator::validate($data->toArray(), BAASRefundPix::rules());
        return $this->post(
            self::REFUND_PIX_ENDPOINT,
            $body
        );
    }

    public function statusRefundPix(?string $id = null, ?string $clientCode = null, ?string $returnIdentification = null)
    {
        return $this->get(
            self::STATUS_REFUND_PIX_ENDPOINT,
            [
                'id' => $id,
                'clientCode' => $clientCode,
                'returnIdentification' => $returnIdentification,
            ]
        );
    }
}
