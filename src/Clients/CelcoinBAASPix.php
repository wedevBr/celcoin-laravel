<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\BAAS\PixCashOut as BAASPixCashOut;
use WeDevBr\Celcoin\Rules\BAAS\RefundPix as BAASRefundPix;
use WeDevBr\Celcoin\Types\BAAS\PixCashOut;
use WeDevBr\Celcoin\Types\BAAS\RefundPix;

/**
 * Class CelcoinBAASPIX
 * API de Pix do BaaS possui o modulo de Pix Cash-out, através desse modulo você consegue realizar as seguintes operações:
 * @package WeDevBr\Celcoin
 */
class CelcoinBAASPIX extends CelcoinBaseApi
{

    const CASH_OUT_ENDPOINT = '/baas-wallet-transactions-webservice/v1/pix/payment';
    const GET_PARTICIPANT_ENDPOINT = '/celcoin-baas-wallet-transactions-webservice/v1/pix/participant';
    const STATUS_PIX_ENDPOINT = '/baas-wallet-transactions-webservice/v1/pix/payment/status';
    const SEARCH_PIX_KEY_ENDPOINT = '/celcoin-baas-pix-dict-webservice/v1/pix/dict/entry/external/%s';
    const REGISTER_PIX_KEY_ENDPOINT = '/celcoin-baas-pix-dict-webservice/v1/pix/dict/entry';
    const GET_ALL_PIX_KEY_ENDPOINT = '/celcoin-baas-pix-dict-webservice/v1/pix/dict/entry/%s';
    const DELETE_PIX_KEY_ENDPOINT = '/celcoin-baas-pix-dict-webservice/v1/pix/dict/entry/%s';
    const REFUND_PIX_ENDPOINT = '/baas-wallet-transactions-webservice/v1/pix/reverse';
    const STATUS_REFUND_PIX_ENDPOINT = '/baas-wallet-transactions-webservice/v1/pix/reverse';

    public function cashOut(PixCashOut $data)
    {
        $body = Validator::validate($data->toArray(), BAASPixCashOut::rules());
        return $this->post(
            self::CASH_OUT_ENDPOINT,
            $body
        );
    }

    public function getParticipant(?string $ISPB, ?string $name)
    {
        return $this->get(
            self::GET_PARTICIPANT_ENDPOINT,
            [
                'ISPB' => $ISPB,
                'Name' => $name,
            ]
        );
    }

    public function statusPix(?string $id, ?string $clientCode, ?string $endToEndId)
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

    public function searchPixKey(string $account, string $key)
    {
        return $this->get(
            sprintf(self::SEARCH_PIX_KEY_ENDPOINT, $account),
            [
                'key' => $key,
            ]
        );
    }

    public function registerPixKey(string $account, string $keyType, string $key)
    {
        return $this->post(
            self::REGISTER_PIX_KEY_ENDPOINT,
            [
                'account' => $account,
                'keyType' => $keyType,
                'key' => $key,
            ]
        );
    }

    public function getAllPixKey(string $account)
    {
        return $this->post(sprintf(self::GET_ALL_PIX_KEY_ENDPOINT, $account));
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

    public function statusRefundPix(string $id, string $clientCode, string $returnIdentification)
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
