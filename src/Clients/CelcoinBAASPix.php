<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\BAAS\PixCashOut as BAASPixCashOut;
use WeDevBr\Celcoin\Rules\BAAS\RefundPix as BAASRefundPix;
use WeDevBr\Celcoin\Types\BAAS\PixCashOut;
use WeDevBr\Celcoin\Types\BAAS\RefundPix;

/**
 * Class CelcoinBAASPix
 * API de Pix do BaaS possui o modulo de Pix Cash-out, através desse modulo você consegue realizar as seguintes operações:
 * @package WeDevBr\Celcoin
 */
class CelcoinBAASPix extends CelcoinBaseApi
{
    public function cashOut(PixCashOut $data)
    {
        $body = Validator::validate($data->toArray(), BAASPixCashOut::rules());
        return $this->post(
            "/baas-wallet-transactions-webservice/v1/pix/payment",
            $body
        );
    }

    public function getParticipant(?string $ISPB, ?string $name)
    {
        return $this->get(
            "/celcoin-baas-wallet-transactions-webservice/v1/pix/participant",
            [
                'ISPB' => $ISPB,
                'Name' => $name,
            ]
        );
    }

    public function statusPix(?string $id, ?string $clientCode, ?string $endToEndId)
    {
        return $this->get(
            "/baas-wallet-transactions-webservice/v1/pix/payment/status",
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
            "/celcoin-baas-pix-dict-webservice/v1/pix/dict/entry/external/{$account}",
            [
                'key' => $key,
            ]
        );
    }

    public function registerPixKey(string $account, string $keyType, string $key)
    {
        return $this->post(
            "/celcoin-baas-pix-dict-webservice/v1/pix/dict/entry",
            [
                'account' => $account,
                'keyType' => $keyType,
                'key' => $key,
            ]
        );
    }

    public function getAllPixKey(string $account)
    {
        return $this->post("/celcoin-baas-pix-dict-webservice/v1/pix/dict/entry/{$account}");
    }

    public function deletePixKey(string $account, string $key)
    {
        return $this->delete(
            "/celcoin-baas-pix-dict-webservice/v1/pix/dict/entry/{$key}",
            [
                'account' => $account,
            ]
        );
    }

    public function refundPix(RefundPix $data)
    {
        $body = Validator::validate($data->toArray(), BAASRefundPix::rules());
        return $this->post(
            "/baas-wallet-transactions-webservice/v1/pix/reverse",
            $body
        );
    }

    public function statusRefundPix(string $id, string $clientCode, string $returnIdentification)
    {
        return $this->get(
            "/baas-wallet-transactions-webservice/v1/pix/reverse",
            [
                'id' => $id,
                'clientCode' => $clientCode,
                'returnIdentification' => $returnIdentification,
            ]
        );
    }
}
